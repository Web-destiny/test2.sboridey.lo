<?php

use yii\grid\GridView;

?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        'survey_id',
        'url',
        [
            'attribute' => 'url',
            'value' => function($model) {
                if (isset($_SERVER['HTTPS']) &&
                    ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) ||
                    isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
                    $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
                    $protocol = 'https://';
                }
                else {
                    $protocol = 'http://';
                }
                return $protocol . $_SERVER['HTTP_HOST'] . "/site/survey?id={$model->survey_id}&rs=" .  $model->url;
            }
        ],

        // 'status',
//                    [
//                        'attribute' => 'created_at',
//                        'format' => ['date', 'php:Y-m-d']
//                    ],

        //             ['class' => 'yii\grid\ActionColumn'],
    ],
]); ?>