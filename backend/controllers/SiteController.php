<?php

namespace backend\controllers;

use backend\models\forms\LoginForm;
use backend\models\User;
use common\constructor\Constructor;
use common\constructorResults\ConstructorResults;
use common\constructorResults\ConstructorResultsDTOExport;
use common\models\Answers;
use common\models\CementDepartment;
use common\models\CementLocation;
use common\models\CementSupervisor;
use common\models\Consultation;
use common\models\SantaQuestion;
use common\models\RandUrl;
use common\models\Survey;
use common\models\SurveyTypes;
use common\services\exporter\FileExportAdapter;
use backend\models\SignupForm;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends Controller
{
    public $layout = 'main-pool';

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'indexadmin', 'constructor', 'create-pool', 'preview', 'preview-cement', 'archive', 'export', 'survey-url', 'managers', 'update-manager',
                            'delete-manager', 'answer-details', 'results', 'result-details', 'update-pool', 'consultations'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['get'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function beforeAction($event)
    {
        if (User::isCementManager() && !ArrayHelper::isIn(Yii::$app->controller->action->id, ['results', 'result-details'])) {
            $this->redirect('/backend/web/site/results');
        }

        return parent::beforeAction($event);
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $this->layout = 'main-pool-main';

        $published = Yii::$app->request->get('published', '');
        $id = Yii::$app->request->get('id', '');

        if($id && $published) {
            $survey = Survey::find()->where(['id' => $id])->one();
            if($published == 'archive') {
                $published_status = 0;
            } else {
                $published_status = 1;
            }
            $survey->archiveSurvey($id, $published_status);
            $this->redirect('/backend/web/site/index');
            return false;
        }

        if(User::isAdminOrSuperAdmin()) {
            $surveys = Survey::find()->where(['published' => 1, ])->all();
        } else {
            $surveys = Survey::find()->where(['published' => 1, 'admin_id' => Yii::$app->user->getId()])->all();
        }



        return $this->render('index', [
            'surveys' => $surveys
        ]);
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionArchive()
    {
        $this->layout = 'main-pool-main';

        $published = Yii::$app->request->get('published', '');
        $id = Yii::$app->request->get('id', '');

        if($id && $published) {
            $survey = Survey::find()->where(['id' => $id])->one();
            if($published == 'dearchive') {
                $published_status = 1;
            }
            $survey->archiveSurvey($id, $published_status);
            $this->redirect('/backend/web/site/archive');
            return false;
        }

        if(User::isAdminOrSuperAdmin()) {
            $surveys = Survey::find()->where(['published' => 0])->all();
        } else {
            $surveys = Survey::find()->where(['published' => 0, 'admin_id' => Yii::$app->user->getId()])->all();
        }



        return $this->render('archive', [
            'surveys' => $surveys
        ]);
    }

    /**
     * Displays preview.
     *
     * @return string
     */
    public function actionPreview($id)
    {
        if (!is_numeric($id)) {
            throw new NotFoundHttpException('404 page');
        }

        $survey = Survey::find()->where(['id' => $id])->one();


        return $this->render('preview', [
            'id' => $id,
            'survey' => $survey,
            'pageName' => 'preview',
            'constructor' => Constructor::initialize($id)->generateQuestionnaire(),
//            'elements' => Constructor::initialize($id)->getElementsData(),
        ]);
    }

    /**
     * Displays preview cement.
     *
     * @return string
     */
    public function actionPreviewCement($id)
    {
        if (!is_numeric($id)) {
            throw new NotFoundHttpException('404 page');
        }

        $survey = Survey::find()->where(['id' => $id])->one();

        $locations = CementLocation::find()->all();

        return $this->render('preview_cement', [
            'id' => $id,
            'survey' => $survey,
            'locations' => $locations,
            'pageName' => 'preview',
            'elements' => Constructor::initialize($id)->getElementsData(),
        ]);
    }

    /**
     * Displays create-pool.
     *
     * @return string
     */
    public function actionCreatePool()
    {
        $user =  Yii::$app->user->id;

        $model = new Survey();
        $model->has_numbering =1;
        $types = SurveyTypes::find()->all();
        $itemsTypes = ArrayHelper::map($types,'id','title');

        $model->admin_id = $user;
        $model->rand_string = Yii::$app->security->generateRandomString(8);
        if ($model->load($request = Yii::$app->request->post()) && $model->validate()) {
            $has_numbering = Yii::$app->request->post('has_numbering', '');
            $has_numbering = ($has_numbering == 'on' ? 1 :0);
            $model->has_numbering = $has_numbering;
            $model->save();
            return $this->redirect(['/site/constructor', 'id' => $model->id]);
        }

        return $this->render('create-pool', [
            'types' => $types,
            'itemsTypes' => $itemsTypes,
            'model' => $model,
        ]);
    }

    public function actionUpdatePool()
    {
        $user =  Yii::$app->user->id;
        $survey_id =  Yii::$app->request->get('survey_id', '');

        if (!is_numeric($survey_id)) {
            throw new NotFoundHttpException('404 page');
        }

        $model =Survey::find()->where(['id' => $survey_id])->one();
        $types = SurveyTypes::find()->all();
        $itemsTypes = ArrayHelper::map($types,'id','title');

        $model->admin_id = $user;
        $model->rand_string = Yii::$app->security->generateRandomString(8);
        if ($model->load($request = Yii::$app->request->post()) && $model->validate()) {
            $has_numbering = Yii::$app->request->post('has_numbering', '');
            $has_numbering = ($has_numbering == 'on' ? 1 :0);
            $model->has_numbering = $has_numbering;
            $model->save();
            return $this->redirect(['/site/constructor', 'id' => $model->id]);
        }

        return $this->render('update-pool', [
            'types' => $types,
            'itemsTypes' => $itemsTypes,
            'model' => $model,
        ]);
    }

    /**
     * Displays constructor.
     *
     * @return string
     */
    public function actionConstructor($id)
    {
        if (!is_numeric($id)) {
            throw new NotFoundHttpException('404 page');
        }

        $survey = Survey::find()->where(['id' => $id])->one();

        $constructor = Constructor::initialize($id)->generateConstructor();

        if(ArrayHelper::keyExists('preview', Yii::$app->request->post())) {
            return $this->redirect(Url::to(['site/preview', 'id' => $id]));
        } elseif (ArrayHelper::keyExists('previewCement', Yii::$app->request->post())) {
            return $this->redirect(Url::to(['site/preview-cement', 'id' => $id]));
        } elseif (ArrayHelper::keyExists('saveData', Yii::$app->request->post())) {
            return $this->redirect(Url::to(['site/constructor', 'id' => $id]));
        }

        $locations = CementLocation::find()->all();

        $previewButtonName = $survey->isCementExtra() ? 'previewCement' : 'preview';

        return $this->render('constructor', [
            'id' => $id,
            'survey' => $survey,
            'constructor' => $constructor,
            'locations' => $locations,
            'previewButtonName' => $previewButtonName,
        ]);
    }

    /**
     * Displays index-admin.
     *
     * @return string
     */
    public function actionIndexadmin()
    {
        $this->layout = 'main';
        return $this->render('index_admin');
    }

    public function actionAnswerDetails($survey_id)
    {
        if (!is_numeric($survey_id)) {
            throw new NotFoundHttpException('404 page');
        }

        $query = Answers::find()->where(['survey_id' => $survey_id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 50
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
        ]);

        return $this->render('answer-details', [
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionResults($type = null)
    {
        $this->layout = 'main-pool-main';

        if(User::isAdminOrSuperAdmin()) {
            $query = Survey::find();
        } else {
            $query = Survey::find()->where(['admin_id' => Yii::$app->user->getId()]);
        }

        $surveyTable = Survey::tableName();
        $answersTable = Answers::tableName();

        $query->select([
            '*',
            'count_total' => "(SELECT COUNT(distinct session_token) FROM $answersTable WHERE $answersTable.survey_id=$surveyTable.id)"
        ]);

        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);

        $pages->setPageSize(20);
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->asArray()
            ->all();

        return $this->render('results', [
            'models' => $models,
            'pages' => $pages,
        ]);
    }

    public function actionResultDetails($id)
    {
        $this->layout = 'main-pool-main';

        Yii::$app->view->params['showTopMenu'] = false;

        $survey = Survey::findOne(intval($id));

        if (empty($survey)) {
            throw new NotFoundHttpException('404 page');
        }

        if(!User::isAdminOrSuperAdmin() && $survey->admin_id != Yii::$app->user->getId()) {
            throw new NotFoundHttpException('404 page');
        }

        $param1 = (string) Yii::$app->request->get('param1');
        $param2 = (string) Yii::$app->request->get('param2');
        $param3 = (string) Yii::$app->request->get('param3');

        $options = compact('param1', 'param2', 'param3');

        $cementDepartments = $cementSupervisor = [];

        if (!empty($param1)) {
            $cementDepartments = CementDepartment::findAll(['location_id' => $param1]);
        }

        if (!empty($param2)) {
            $cementSupervisor = CementSupervisor::findAll(['department_id' => $param2]);
        }

        $results = new ConstructorResults($survey->id, $options);

        $cementLocations = CementLocation::find()->all();

        return $this->render('result-details', [
            'html' => $results->render(),
            'id' => $id,
            'cementLocations' => $cementLocations,
            'cementDepartments' => $cementDepartments,
            'cementSupervisor' => $cementSupervisor,
            'options' => $options,
        ]);
    }

    public function actionExport($id = null)
    {
        $this->layout = 'main-pool-main';

        $survey = Survey::findOne(intval($id));

        if (empty($survey)) {
            throw new NotFoundHttpException('404 page');
        }

        $results = new ConstructorResultsDTOExport($survey->id);

        $data = Answers::sortDataByUniqueKey($results->answers, $results->questionData, true);

        FileExportAdapter::instance(FileExportAdapter::TYPE_EXCEL)
            ->setExportData(['Sheet_1' => $data['array']])
            ->setHeader(['Sheet_1' => $data['Sheet1Header']])
            ->setFilename('Survey Reports.xlsx')
            ->setOptions(['Sheet_1_headerStyle' => [
                'fill' => '#ccc', 'font' => 'Arial', 'font-size' => 10, 'font-style' => 'bold', 'halign' => 'center', 'valign' => 'center',
                'widths' => $data['widths']
            ]])->export();

        return true;
    }

    public function actionConsultations()
    {
        $this->layout = 'main-pool-main';
//        $model = new Consultation();



        $dataProvider = new ActiveDataProvider([
            'query' => Consultation::find(),
        ]);

        return $this->render('consultations', [
//            'model' => $model,
            'dataProvider' => $dataProvider,
//            'action' => 'insert',
        ]);
    }

    /**
     * Signup action.
     *
     * @return string|Response
     */
    public function actionManagers()
    {
        $this->layout = 'main-pool-main';
        $model = new SignupForm();

        $model->permissionViewResultsOnly = (bool) (Yii::$app->request->post('SignupForm')['permissionViewResultsOnly'] ?? false);

        if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', Yii::t('app', 'Manager has successfully been added.'));

            return $this->refresh();
        }

        $dataProvider = new ActiveDataProvider([
            'query' => User::find(),
        ]);

        return $this->render('managers', [
            'model' => $model,
            'dataProvider' => $dataProvider,
            'action' => 'insert',
        ]);
    }

    public function actionUpdateManager()
    {
        $this->layout = 'main-pool-main';

        $id = intval(Yii::$app->request->get('id'));
        $user = User::find()->where(['id' => $id])->one();

        if (!$id || ! $user) {
            throw new NotFoundHttpException("Not found.");
        }

        $user->permissionViewResultsOnly = Yii::$app->getAuthManager()->checkAccess($user->id, User::PERMISSION_VIEW_RESULTS_ONLY);

        if (Yii::$app->request->isPost) {
            $user->permissionViewResultsOnly = (bool) (Yii::$app->request->post('User')['permissionViewResultsOnly'] ?? false);

            $user->assignDefaultRules();
        }

        if(Yii::$app->request->isPost && $user->load(Yii::$app->request->post()) && $user->validate()) {
            if (!empty($user->password_hash)) {
                $user->password_hash = Yii::$app->security->generatePasswordHash($user->password_hash);
            }

            if ($user->save()) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'Manager has successfully been updated.'));

                return $this->redirect(['managers']);
            }
        }

        return $this->render('managers', [
            'model' => $user,
            'action' => 'update',
        ]);
    }

    public function actionDeleteManager($id)
    {
        User::deleteAll(['id' => $id]);

        Yii::$app->session->setFlash('success', Yii::t('app', 'Manager has successfully been deleted.'));

        return $this->redirect(['managers']);
    }

    /**
     * Login action.
     *
     * @return string|Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'login';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(['/']);
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }


    public function actionSurveyUrl($id)
    {
        $this->layout = 'main-pool-main';

        if (!$id || !is_numeric($id)) {
            throw new NotFoundHttpException('404 page');
        }

        $randomUrlObject = new RandUrl();

        $dataProvider = new ActiveDataProvider([
            'query' =>  ($query = $randomUrlObject->find()->with('survey')->where(['survey_id' => $id])),
            'pagination' => [
                'pageSize' => 5
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
        ]);

        $requestCount = intval(Yii::$app->request->post('survey_links_count'));

        if (Yii::$app->request->isAjax && $requestCount) {
            if ($randomUrlObject->generateRandomUrl($id, $requestCount)) {
                return $this->renderAjax('_survey-view', ['dataProvider' => $dataProvider]);
            } else {
                die('validation_fail');
            }
        }

        if (Yii::$app->request->post('export-survey-links') && !empty($data = $query->asArray()->all())) {
            FileExportAdapter::instance(FileExportAdapter::TYPE_EXCEL)
                ->setExportData(['Sheet_1' => $data])
                ->setHeader(['Sheet_1' => ['ID' => 'string', 'Опрос' => 'string', 'URL' => 'string', 'Статус' => 'string']])
                ->setFilename($data[0]['survey']['name'] . '.xlsx')
                ->setOptions(['Sheet_1_headerStyle' => [
                    'fill' => '#ccc', 'font' => 'Arial', 'font-size' => 10, 'font-style' => 'bold', 'halign' => 'center', 'valign' => 'center',
                    'widths' => [30, 30, 30, 30]
                ]])->export();
            die;
        }

        return $this->render('survey-url', [
            'requestCount' => $requestCount,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionShortLinks() {
        //$data = SantaRandString::find()->select(['id', 'rand_string_long'])->all();
        $data = RandUrl::find()->all();

        $n = 0;
        foreach ($data as $d) {
            if($n>10) break;
            $url = 'https://cutt.ly/api/api.php?key=a0b3c28c1a5b3e48e8c0dcd49efba6217376b&short=https://4service.family/santapool?ud='. $d->rand_string_long;
            //echo $url.'<br>';

            $shortLInk = RandUrl::getShortLink($url);
            if(!$shortLInk) {
                echo '<br> no shortling'.$shortLInk.'<br>';
                continue;
            }

            $d->rand_string = $shortLInk;
            if($d->validate()) {
                // $d->save();
            } else {
                $err = $d->getErrors();
                print_r($err);
                exit;
            }
            echo '<br>id='.$d->id.'<br>';
            $n++;
        }





        echo $shortLInk;



        echo '<br>End curl';
        exit;
    }


}
