<?php

namespace backend\controllers;

use common\services\importer\FileParserExcel;
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
class ExtraController extends Controller
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
        $importer = new FileParserExcel();
        $importer->setFile('/home/jermuk_arm/Desktop/temp/Структура (для опросника) пример.xlsx');
        $importer->parse();

        echo '<br>==============================<br>'; exit;
    }

}
