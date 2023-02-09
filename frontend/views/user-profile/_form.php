<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\UserProfile $model */
/** @var yii\widgets\ActiveForm $form */
?>

<script src="/js/jquery-3.5.1.min.js"></script>

<div class="login-page">
    <div class="login-content">
        <div class="login-form send-form">

            <?php $form = ActiveForm::begin([
                'options' => ['class' => 'form-horizontal'],
            ]); ?>

            <?= $form->field($model, 'has_car', ['options' => ['class' => 'login-input']])->dropdownList([0 => 'Нет', 1 => 'Да'], ['class' => 'customselect'])->label('Есть ли у Вас в семье личный автомобиль'); ?>
            <?= $form->field($model, 'car_mark', ['options' => ['class' => 'login-input']])->dropdownList($carMarkArray, ['prompt'=>'Выбрать', 'class' => 'customselect'])->label('Укажите марку'); ?>
            <?= $form->field($model, 'class_car', ['options' => ['class' => 'login-input']])->dropdownList($carTypeArray, ['prompt'=>'Выбрать', 'class' => 'customselect'])->label('Класс автомобиля'); ?>

            <?= $form->field($model, 'income_level', ['options' => ['class' => 'login-input']])->dropdownList($incomeLevelArray, ['prompt'=>'Выбрать', 'class' => 'customselect'])->label('Укажите Ваш уровень дохода'); ?>
            <?= $form->field($model, 'monthly_income_per_member', ['options' => ['class' => 'login-input']])->dropdownList($monthlyIncomePerMemberArray, ['prompt'=>'Выбрать', 'class' => 'customselect'])->label('Какой месячный доход на одного члена Вашей семьи'); ?>
            <?= $form->field($model, 'personal_income_level', ['options' => ['class' => 'login-input']])->dropdownList($personalIncomeLevelArray, ['prompt'=>'Выбрать', 'class' => 'customselect'])->label('Каков Ваш личный месячный доход'); ?>

            <?= $form->field($model, 'banks', ['options' => ['class' => 'login-input']])->dropdownList($banksArray, ['prompt'=>'Выбрать', 'class' => 'customselect'])->label('Услугами каких банков Вы пользуетесь (не более 5 ответов)'); ?>

            <?= $form->field($model, 'bank_services', ['options' => ['class' => 'login-input']])->dropdownList($bankServicesArray, ['prompt'=>'Выбрать', 'class' => 'customselect'])->label('Какими банковскими/финансовыми продуктами/услугами вы пользовались за последний год или пользуетесь в настоящее время'); ?>


            <?= $form->field($model, 'purchases', ['options' => ['class' => 'login-input']])->dropdownList($purchasesArray, ['prompt'=>'Выбрать', 'class' => 'customselect'])->label('Что из перечисленного Вы покупали в интернет-магазинах онлайн за последние 3 месяца'); ?>

            <?= $form->field($model, 'operators', ['options' => ['class' => 'login-input']])->dropdownList($operatorsArray, ['prompt'=>'Выбрать', 'class' => 'customselect'])->label('Услугами какого оператора или операторов связи Вы пользуетесь в настоящий момент(не более 3 ответов)'); ?>

            <?= $form->field($model, 'Which_of_the_following_do_you_have', ['options' => ['class' => 'login-input']])->dropdownList($WhichOfTheFollowingDoYouHaveArray, ['prompt'=>'Выбрать', 'class' => 'customselect'])->label('Что из перечисленного есть у Вас'); ?>

            <?= $form->field($model, 'what_did_you_do', ['options' => ['class' => 'login-input']])->dropdownList($whatDidYouDoArray, ['prompt'=>'Выбрать', 'class' => 'customselect'])->label('ЧТО ИЗ ПЕРЕЧИСЛЕННОГО ВЫ ЛИЧНО ДЕЛАЛИ'); ?>

            <?= $form->field($model, 'provider', ['options' => ['class' => 'login-input']])->dropdownList($providerArray, ['prompt'=>'Выбрать', 'class' => 'customselect'])->label('Услугами какого или каких из перечисленных ниже интернет-провайдеров вы пользуетесь?'); ?>

            <?= $form->field($model, 'smoking', ['options' => ['class' => 'login-input']])->dropdownList([0 => 'Нет', 1 => 'Да'], ['prompt'=>'Выбрать', 'class' => 'customselect'])->label('Вы курите?'); ?>

            <?= $form->field($model, 'what_smoking', ['options' => ['class' => 'login-input']])->dropdownList($whatSmokingArray, ['prompt'=>'Выбрать', 'class' => 'customselect'])->label('Если  Да, то что?'); ?>

            <div class="login-input">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>



