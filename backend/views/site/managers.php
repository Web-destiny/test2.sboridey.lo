<?php

/**
 * @var $this \yii\web\View;
 */

use backend\models\User;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

?>

<?php $form = Pjax::begin(); ?>

<?= $this->render('_manager_form', ['model' => $model]); ?>

<?= $action === 'insert' ? GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        'id',
        'username',
        'auth_key',
        'password_hash',
        'password_reset_token',
        [
            'header' => 'hasPermissionViewResultsOnly',
            'attribute' => 'HasPermissionViewResultsOnly',
            'value' => function ($user) {
                return Yii::$app->getAuthManager()->checkAccess($user->id, User::PERMISSION_VIEW_RESULTS_ONLY) ? 'Yes' : 'No';
            },
        ],
        //'email:email',
        //'status',
        //'created_at',
        //'updated_at',

        [
            'class' => 'yii\grid\ActionColumn',
            'urlCreator' => function ($action, $model, $key, $index) {
                return Url::toRoute([$action . '-manager', 'id' => $model->id]);
            }
        ],
    ],
]) : ''; ?>

<?php Pjax::end(); ?>
