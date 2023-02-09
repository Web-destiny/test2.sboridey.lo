<?php
use common\models\User;
use yii\widgets\DetailView;


/**
 * @var User $modelUser
 */

$model->refresh(); // update relations

$sredaComRUDetailView = DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        [
            'attribute' => 'full_name',
            'value' => function ($data) use ($model) {
                return $model->name;
            },
            'format' => 'html'
        ],
        [
            'attribute' => 'phone',
            'value' => function ($data) use ($model) {
                return $model->phone;
            },
            'format' => 'html'
        ],
        'email:email',
        'created_at:date',
    ],
]);;

$forServiceDetailView = '';

$detailView = $sredaComRUDetailView;

?>

<div id="style_16382785640123976895_BODY">
    <div class="cl_297271">
        <p>Добрый день!</p>
        <?= $sredaComRUDetailView; ?>

    </div>
</div>
