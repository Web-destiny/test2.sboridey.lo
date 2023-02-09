<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CementDepartment */

$this->title = 'Новое Подразделение';
$this->params['breadcrumbs'][] = ['label' => 'Cement Departments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cement-department-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'isUpdate' => false,
        'locations' => $locations,
    ]) ?>

</div>
