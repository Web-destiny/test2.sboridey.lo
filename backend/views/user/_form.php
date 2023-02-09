<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\User $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'gender', ['options' => ['class' => 'login-input']])->dropdownList([\common\models\User::GENDER_MALE => 'Мужской', \common\models\User::GENDER_FEMALE => 'Женский'], ['class' => ''])->label(); ?>

    <?= $form->field($model, 'region')->textInput() ?>

    <?= $form->field($model, 'city')->textInput() ?>

    <?= $form->field($model, 'education')->textInput() ?>

    <?= $form->field($model, 'count_of_children')->textInput() ?>

    <?= $form->field($model, 'age_of_children')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'birth_day')->textInput() ?>

    <?= $form->field($model, 'profession')->textInput() ?>

    <?= $form->field($model, 'profession_comment')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'department')->textInput() ?>

    <?= $form->field($model, 'fieldofactivity')->textInput() ?>

    <?= $form->field($model, 'company_size')->textInput() ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
