<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CementSupervisor */

$this->title = 'Редактировать руководителя: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Cement Supervisors', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="cement-supervisor-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
