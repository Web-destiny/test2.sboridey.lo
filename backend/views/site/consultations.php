<?php

/**
 * @var $this \yii\web\View;
 */

use backend\models\User;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

?>

<div>
    <h2>Консультации</h2>
</div>

<?php $form = Pjax::begin(); ?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        'id',
        'email',
        'name',
        [
            'attribute'=>'phone',
            'headerOptions' => ['style' => 'width:180px'],
        ],
        [
            'attribute'=>'comment',
            'headerOptions' => ['style' => 'width:400px'],
        ],
        [
            'header' => 'Дата',
            'attribute' => 'created_at',
            'value' => function ($model) {
                return \Yii::$app->formatter->asDate($model->created_at, 'php:Y-m-d : H:i:s');
            },
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{delete}',
            'urlCreator' => function ($action, $model, $key, $index) {
                return Url::toRoute([$action . '-manager', 'id' => $model->id]);
            }
        ],
    ],
]); ?>

<?php Pjax::end(); ?>
