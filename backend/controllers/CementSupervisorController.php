<?php

namespace backend\controllers;

use common\models\CementDepartment;
use common\models\CementLocation;
use common\models\CementSupervisor;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CementSupervisorController implements the CRUD actions for CementSupervisor model.
 */
class CementSupervisorController extends Controller
{
    /**
     * @inheritDoc
     */
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

    /**
     * Lists all CementSupervisor models.
     * @return mixed
     */
    public function actionIndex()
    {
//        $departmentsModel = new CementDepartment();
//        $departments = CementDepartment::find()->all();

        $requestCity = \Yii::$app->request->post('CementLocation', []);
        if(\Yii::$app->request->post() && $requestCity) {
            $model = CementLocation::find()->where(['id' => $requestCity['id']])->one();
        } else {
            $model = new CementLocation();
        }
        $locations = CementLocation::find()->all();

        $requestDepartment = \Yii::$app->request->post('CementDepartment', []);
        if(\Yii::$app->request->post() && $requestCity && $requestDepartment) {
            $departmentsModel = CementDepartment::find()->where(['location_id' => $requestCity['id']])->one();
            $departmentsModel->id = $requestDepartment['id'];
            $departments = CementDepartment::find()->where(['location_id' => $requestCity['id']])->all();
        } else {
            $departmentsModel = new CementDepartment();
            $departments = [];
        }


        $dataProvider = new ActiveDataProvider([
            'query' => CementSupervisor::find()->where(['department_id' => $departmentsModel->id]),
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

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'locations' => $locations,
            'model' => $model,
            'departments' => $departments,
            'departmentsModel' => $departmentsModel,
        ]);
    }

    /**
     * Displays a single CementSupervisor model.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new CementSupervisor model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CementSupervisor();
        $department_id = \Yii::$app->request->get('department_id', '');
        $departamenObj = CementDepartment::find()->where(['id' => $department_id])->one();

        if(!$department_id) {
            throw new \yii\web\HttpException(404, 'Не выбрано подразделение!');
        }

        $model->department_id = $department_id;

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'department_id' => $department_id,
            'departamenObj' => $departamenObj,
        ]);
    }

    /**
     * Updates an existing CementSupervisor model.
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

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing CementSupervisor model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the CementSupervisor model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return CementSupervisor the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CementSupervisor::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
