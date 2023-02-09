<?php

namespace frontend\controllers;

use common\constructor\Constructor;
use common\constructor\traits\ConstructorStorage;
use common\models\CementDepartment;
use common\models\CementLocation;
use common\models\City;
use common\models\CompanySize;
use common\models\Consultation;
use common\models\Department;
use common\models\Education;
use common\models\Fieldofactivity;
use common\models\Profession;
use common\models\Region;
use common\models\Survey;
use common\models\SurveyElement;
use common\models\User;
use common\models\UserProfile;
use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\caching\ExpressionDependency;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;
use function Symfony\Component\Translation\t;
use function Webmozart\Assert\Tests\StaticAnalysis\false;

/**
 * Site controller
 */
class SiteController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup', 'survey'],
                'rules' => [
                    [
                        'actions' => ['signup', 'logout', 'survey', 'thanks-for-registration', 'finished', 'cities', 'demo-email'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout', 'survey'],
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
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'onAuthSuccess'],
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = 'login';

        if(Yii::$app->user->isGuest) {
            $this->redirect([Url::to(['/site/landing'])]);
        }

        $query = Survey::find()->where(['published' => 1]);
        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count]);
        $pagination->pageSize = 30;
        $queryClone = clone $query;
        $surveys = $queryClone->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        $surveysCount = SurveyElement::getCountOfQuestions($surveys);

        return $this->render('index', [
            'surveys' => $surveys,
            'surveysCount' => $surveysCount,
            'pagination' => $pagination,
        ]);
    }

    /**
     * Displays landing page.
     *
     * @return mixed
     */
    public function actionLanding()
    {
        $this->layout = false;

        if(!Yii::$app->user->isGuest) {
            $this->redirect([Url::to(['/site/index'])]);
        }

        return $this->render('landing', []);
    }

    public function actionDemoEmail()
    {
        $name = Yii::$app->request->get('name', '');
        $email = Yii::$app->request->get('email', '');
        $phone = Yii::$app->request->get('phone', '');
        $comment = Yii::$app->request->get('comment', '');

        if (!$name | !$email | !$phone) {
            echo json_encode('err');
        } else {
            $model = new Consultation();
            $model->name = $name;
            $model->email = $email;
            $model->phone = $phone;
            $model->comment = $comment;

            if ($model->validate()) {
                $model->save();

                User::sendEmailforConsultation($model);

                echo json_encode('ok');
                exit;
            } else {
//                $err = $model->getErrors();
//                echo '<pre>';
//                print_r($err);
//                die;
//                echo '</pre>';

                //echo json_encode('err');
            }

        }

        exit;
    }



    /**
     * Displays survey.
     *
     * @return mixed
     */
    public function actionSurvey()
    {
        $rand_string = Yii::$app->request->get('rs', '');
        $id = Yii::$app->request->get('id', '');

        $extra1 = '';
        // TODO временно. для опросы цемент
        ///////////////////////////////////////////  start  ////////////////////////////////////////////////////////////
        $extra1 = Yii::$app->request->get('extra1', '');    // for survey 170
        $param1 = Yii::$app->request->get('param1', '');    // fro survey 174   extra1=1&param1=1
        ///////////////////////////////////////////  end  //////////////////////////////////////////////////////////////


        if (!$rand_string) {
            throw new NotFoundHttpException('Page not found');
        }

        $survey = Survey::find()
            ->innerJoinWith(['randUrl' => function($query) use ($rand_string) {
                return $query->where(['url' => $rand_string]);
            }, 'randUrl'])
            ->where(['survey.id' => $id]);

        if($extra1) {
            // TODO временно. для опросы цемент
            $survey->andwhere(['extra1' => 1]);
        } else {
            $survey->andwhere('extra1 is null or extra1 <> 1');
        }

        $survey = $survey->one();

        if (!$survey || !$id || !$rand_string) {
            throw new NotFoundHttpException('Page not found');
        }

        if(!$survey->status || !$survey->published) {
            $this->redirect('/site/finished');
        }


        $id = $survey->id;

        ConstructorStorage::setSurveyId($id);
        $constructor = new Constructor();
        $data = ConstructorStorage::getElementsData();

        $this->layout = false;

        if(Yii::$app->request->post()) {
            $surveyObj = new Survey();
            $result = $surveyObj->saveAnswers(Yii::$app->request->post(), $rand_string);
            if($result) {
                $this->redirect('/site/thanks');
            }
        }

        if($survey->id == 170 || $survey->id == 174) {
            $locations = CementLocation::find()
                ->where(['extra1' => '1'])
                ->all();
        } else {
            $locations = CementLocation::find()->all();
        }


        $previewButtonName = $survey->isCementExtra() ? 'previewCement' : 'preview';

        return $this->render('survey', [
            'id' => $id,
            'survey' => $survey,
            'constructor' => $constructor,
            'data' => $data,
            'locations' => $locations,
            'previewButtonName' => $previewButtonName,
            'extra1' => $extra1,
            'param1' => $param1,
        ]);
    }


    /**
     * Displays thanks
     *
     * @return mixed
     */
    public function actionThanks()
    {
        $this->layout = false;

        return $this->render('thanks');
    }

    /**
     * Displays finished
     *
     * @return mixed
     */
    public function actionFinished()
    {
        $this->layout = false;

        return $this->render('finished');
    }

    /**
     * Displays thanks
     *
     * @return mixed
     */
    public function actionThanksForRegistration()
    {
        $this->layout = 'login';

        return $this->render('thanks-for-registration');
    }

    /**
     * Displays detail-form
     *
     * @return mixed
     */
    public function actionDetailForm()
    {
        $this->layout = 'login';

        $model = new SignupForm(['scenario' => SignupForm::SCENARIO_USER_LAST_STEP_REG]);

        if (empty($model->username = Yii::$app->session->get('username')) || empty($model->email = Yii::$app->session->get('email'))) {
            return $this->redirect('site/sign-up');
        }

        if (Yii::$app->request->isPost) {
            $model->setScenario(SignupForm::SCENARIO_USER_LAST_STEP_REG);
            $model->load(Yii::$app->request->post());
            $model->age_of_children = implode(', ', $model->age_of_children);
            if ($model->validate()) {
                $user_id = $model->signup();

                $userProfile = New UserProfile();
                $userProfile->user_id = $user_id;
                $userProfile->save();

                $this->redirect('/site/thanks-for-registration');
            } else {
//                $err = $model->getErrors();
//                print_r($err);
            }
        }

        $regions = Region::find()->all();
        $regionsArray = [];
        array_map(function ($region) use (&$regionsArray) {
            $regionsArray["$region->id"] = $region->name;
        }, $regions);

        $professions = Profession::find()->all();
        $professionsArray = [];
        array_map(function ($profession) use (&$professionsArray) {
            $professionsArray["$profession->id"] = $profession->name;
        }, $professions);

        $departments = Department::find()->all();
        $departmentsArray = [];
        array_map(function ($department) use (&$departmentsArray) {
            $departmentsArray["$department->id"] = $department->name;
        }, $departments);

        $fieldofactivitys = Fieldofactivity::find()->all();
        $fieldofactivitysArray = [];
        array_map(function ($fieldofactivity) use (&$fieldofactivitysArray) {
            $fieldofactivitysArray["$fieldofactivity->id"] = $fieldofactivity->name;
        }, $fieldofactivitys);

        $educations = Education::find()->all();
        $educationsArray = [];
        array_map(function ($education) use (&$educationsArray) {
            $educationsArray["$education->id"] = $education->name;
        }, $educations);

        $companySize = CompanySize::find()->all();
        $companySizeArray = [];
        array_map(function ($companySize) use (&$companySizeArray) {
            $companySizeArray["$companySize->id"] = $companySize->alias;
        }, $companySize);

        $age_of_children = [];
        for($i = 0; $i < 50; $i++) {
            $age_of_children[] = $i;
        }

        return $this->render('detail_form', [
            'model' => $model,
            'regionsArray' => $regionsArray,
            'professionsArray' => $professionsArray,
            'departmentsArray' => $departmentsArray,
            'fieldofactivitysArray' => $fieldofactivitysArray,
            'educationsArray' => $educationsArray,
            'age_of_children' => $age_of_children,
            'companySizeArray' => $companySizeArray,
        ]);
    }

    public function actionCities()
    {
        $value = Yii::$app->request->get('value', '');
       \Yii::$app->response->format = Response::FORMAT_JSON;
        $cities =City::find()->where(['region_id' => $value])->all();

        return $cities;
    }

    public function actionProfessinVisibility()
    {
        $value = Yii::$app->request->get('value', '');
       \Yii::$app->response->format = Response::FORMAT_JSON;
        $result =Profession::find()->where(['id' => $value])->one();

        return $result;
    }


    /**
     * Displays agreement.
     *
     * @return mixed
     */
    public function actionAgreement()
    {
        $this->layout = 'login';

        $model = new SignupForm();
        $post = Yii::$app->request->post();

        if($model->load($post) && $model->validate()) {
            $session = Yii::$app->session;
            $username = $post['SignupForm']['username'];
            $email = $post['SignupForm']['email'];

            $session->set('username', $username);
            $session->set('email', $email);
        } else {
            Yii::$app->session->setFlash('error_registration_first_step', 'Такой email или Имя существуют или не правильно заполнены поля!');
            return $this->redirect('/site/sign-up');
        }

        return $this->render('agreement');
    }


    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        $this->layout = 'login';

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        $err = '';
        if ($model->load(Yii::$app->request->post())) {
            if($model->validate()) {
                if($model->login()) {
                    return $this->redirect(['/user-profile/additional-update', 'user_id' => $model->user->id]);
                    exit;
                }
            }else {
                $err = 'Не правильный логин или пароль';
                $errors = $model->getErrors();
//                dd($errors);
            }

        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
            'err' => $err,
        ]);
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        }

        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignUp()
    {
        $this->layout = 'login';

        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
            return $this->goHome();
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * User sign up validation.
     *
     * @throws BadRequestHttpException
     * @return array
     */
    public function actionSignUpValidation() : array
    {
        if (!Yii::$app->request->isAjax || !Yii::$app->request->isPost) {
            throw new BadRequestHttpException("You don't have access to this page.");
        }

        Yii::$app->response->format = Response::FORMAT_JSON;

        $model = new SignupForm(['scenario' => SignupForm::SCENARIO_USER_LAST_STEP_REG]);

        $model->load(Yii::$app->request->post());
        $model->validate();

        return ActiveForm::validate($model);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            }

            Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @throws BadRequestHttpException
     * @return yii\web\Response
     */
    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if (($user = $model->verifyEmail()) && Yii::$app->user->login($user)) {
            Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
            return $this->redirect(Url::to(["user-profile/additional-update?user_id=" . Yii::$app->user->id]));;
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }

    public function actionTest()
    {
        $this->layout = 'login';


        ///////////////////////////////// Email  ///////////////////////////////////////////////////////////////////////////////
//        Yii::$app->mailer
//            ->compose()
//            ->setFrom(['admmin@mail.ru'])
//            ->setTo('armjer@mail.ru')
//            ->setSubject( Yii::$app->name)
//            ->setTextBody('Текстовая версия письма (без HTML)')
//            ->setHtmlBody('<p>HTML версия письма</p>')
//            ->send();
//            echo '77777777777777777777777777'; exit;
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//        $auth = Yii::$app->authManager;
//        $adminRole = $auth->getRole('manager');
//        $auth->assign($adminRole, 3);
//        echo '7777777777777'; exit;
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        echo '<br>==================================<br>';
        exit;


    }

}
