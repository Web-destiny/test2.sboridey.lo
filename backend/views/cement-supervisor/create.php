<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CementSupervisor */

$this->title = 'Новый руководитель';
$this->params['breadcrumbs'][] = ['label' => 'Cement Supervisors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cement-supervisor-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
