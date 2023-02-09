<?php

namespace backend\controllers;

use Yii;
use common\models\CementDepartment;
use common\models\CementLocation;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CementDepartmentsController implements the CRUD actions for CementDepartment model.
 */
class CementDepartmentsController extends Controller
{
    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

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
     * Lists all CementDepartment models.
     * @return mixed
     */
    public function actionIndex()
    {

        $city = '';
        $locations = CementLocation::find()->all();

        $requestCity = \Yii::$app->request->post('CementLocation', []);
        if(Yii::$app->request->post()) {
            $model = CementLocation::find()->where(['id' => $requestCity['id']])->one();
        } else {
            $model = new CementLocation();
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $city = $model->id;
        }


        $dataProvider = new ActiveDataProvider([
            'query' => CementDepartment::find()->where(['location_id' => $city]),
        ]);
        

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'locations' => $locations,
            'model' => $model,
        ]);
    }



    /**
     * Displays a single CementDepartment model.
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
     * Creates a new CementDepartment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CementDepartment();
        $locations = CementLocation::find()->all();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'locations' => $locations,
        ]);
    }

    /**
     * Updates an existing CementDepartment model.
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
     * Deletes an existing CementDepartment model.
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
     * Finds the CementDepartment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return CementDepartment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CementDepartment::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
