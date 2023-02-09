<?php

use yii\grid\GridView;
use yii\helpers\Url;

?>

<div class="top-nav btn-wrap" style="margin: 50px;">
    <a href="<?= Url::to(['site/export', 'type' => 'excel']) ?>" class="btn-create-pool">Export</a>
</div>

<div class="pools-table-wrap">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'survey_id',
            'unique',
            [
                'attribute'=>'questiion',
                'format'=>'raw',
                'value' => function($data)
                {
                    return
                        \yii\helpers\Html::a($data->questiion, ['site/answer-details','survey_id'=>$data->survey_id], ['title' => 'View','class'=>'no-pjax']);
                }
            ],
            [
                'attribute' => 'created_at',
                'format' => ['date', 'php:Y-m-d']
            ],

            // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>