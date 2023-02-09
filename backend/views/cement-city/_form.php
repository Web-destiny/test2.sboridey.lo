<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

/* @var $this yii\web\View */
/* @var $model common\models\CementLocation */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cement-location-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput(['readonly' => true]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
