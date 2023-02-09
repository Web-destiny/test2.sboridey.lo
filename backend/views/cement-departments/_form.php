<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\CementDepartment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cement-department-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php  $isReadonly = $isUpdate ? true : false; ?>
    <?= $form->field($model, 'id')->hiddenInput(['readonly'=> $isReadonly])->label(false); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?php if(isset($locations)): ?>
        <?= $form->field($model, 'location_id')->dropDownList(\yii\helpers\ArrayHelper::map($locations, 'id', 'name')); ?>
    <?php else: ?>
        <?= $form->field($model, 'location_id')->textInput(); ?>
    <?php endif; ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
