<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CementLocation */

$this->title = 'Редактировать местоположение: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Cement Locations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="cement-location-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
