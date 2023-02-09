<?php

namespace backend\controllers;

use common\models\CementDepartment;
use common\models\CementLocation;
use common\models\CementSupervisor;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * CementController implements the CRUD actions for CementLocation model.
 */
class CementCityController extends Controller
{
    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),

            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    public function actionCommon()
    {
        return $this->render('/cement-city/common', []);
    }

    /**
     * Lists all CementLocation models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => CementLocation::find(),
            /*
            'pagination' => [
                'pageSize' => 50
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
            */
        ]);

        return $this->render('/cement-city/index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CementLocation model.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('/cement-city/view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new CementLocation model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CementLocation();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('/cement-city/create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing CementLocation model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('/cement-city/update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing CementLocation model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['/cement-city/index']);
    }

    /**
     * Finds the CementLocation model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return CementLocation the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CementLocation::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionDepartments()
    {
        $extra1 = \Yii::$app->request->post('extra1', '');
        $param1 = \Yii::$app->request->post('param1', '');
        \Yii::$app->response->format = Response::FORMAT_JSON;

        if(!$extra1) {
            $results = CementDepartment::find()->where(['location_id' => \Yii::$app->request->post('value') ]);
            $results->andwhere('extra1 is null or extra1 <> 1');
            $results->andwhere('id not in(42, 43, 41, 44, 45)');
        } elseif($extra1 == 1 && !$param1) {
            $results = CementDepartment::find()->where(['location_id' => \Yii::$app->request->post('value'), 'extra1' => 1]);
            $results->andWhere('param1 is null');
        } elseif($extra1 == 1 && $param1 == 1) {
            $results = CementDepartment::find()->where(['location_id' => \Yii::$app->request->post('value'), 'extra1' => 1]);
            $results->andWhere(['param1' => 1]);
        }
        else {
            $results = CementDepartment::find()->where(['location_id' => \Yii::$app->request->post('value'), 'extra1' => 1]);
        }

        return $results->all();
    }

    public function actionSupervisors()
    {
        $extra1 = \Yii::$app->request->post('extra1', '');
        $param1 = \Yii::$app->request->post('param1', '');
        \Yii::$app->response->format = Response::FORMAT_JSON;

        if(!$extra1) {
            $results = CementSupervisor::find()->where(['department_id' => \Yii::$app->request->post('value')]);
        }  elseif($extra1 == 1 && !$param1) {
            $results = CementSupervisor::find()->where(['department_id' => \Yii::$app->request->post('value'), 'extra1' => 1]);
            $results->andWhere('param1 is null');
        } elseif($extra1 == 1 && $param1 == 1) {
            $results = CementSupervisor::find()->where(['department_id' => \Yii::$app->request->post('value'), 'extra1' => 1]);
            $results->andWhere(['param1' => 1]);
        }
        else {
            $results = CementSupervisor::find()->where(['department_id' => \Yii::$app->request->post('value'), 'extra1' => 1]);
        }

        return $results->all();
    }

}
