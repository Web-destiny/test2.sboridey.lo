<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model \common\models\LoginForm */

use common\models\User;
use kartik\date\DatePicker;
use yii\bootstrap4\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="login-page">
    <div class="header">
        <div class="logo">
            <img src="/img/logo-pool.svg" alt="Pool">
        </div>
    </div>
    <div class="login-content">
        <div class="img-cont">
            <img src="/img/detail-form-bg.png" alt="">
        </div>
        <div class="login-form send-form">
            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
                'enableAjaxValidation' => true,
                'validationUrl' => Url::toRoute('site/sign-up-validation'),
                'options' => ['class' => 'form-horizontal'],
            ]) ?>

                <div class="login-header">
                    Немного подробностей
                </div>
                <div class="detail-form-text-cont text-popUp">
                    <div class="detail-form-text">
                        Давайте сверим,<br>
                        все ли данные внесены верно
                    </div>
                </div>

                <?= $form->field($model, 'first_name', ['options' => ['class' => 'login-input']])->textInput(['class' => '', 'placeholder' => 'Имя'])->label(false); ?>
                <?= $form->field($model, 'last_name', ['options' => ['class' => 'login-input']])->textInput(['class' => '', 'placeholder' => 'Фамилия'])->label(false); ?>
                <?= $form->field($model, 'phone', ['options' => ['class' => 'login-input']])->textInput(['class' => '', 'placeholder' => 'Номер телефона'])->label(false); ?>
                <?= $form->field($model, 'email', ['options' => ['class' => 'login-input']])->textInput(['class' => '', 'placeholder' => 'E-mail', 'type' => 'email'])->label(false); ?>
                <?= $form->field($model, 'birth_day', ['options' => ['class' => 'login-input']])->widget(DatePicker::class, [
                    'options' => ['placeholder' => 'Дата рождения', 'class' => 'login-input'],
                    'addInputCss' => '',
                    'pluginOptions' => [
                        'format' => 'dd-mm-yyyy',
                        'todayHighlight' => true,
                    ]
                ])->label(false); ?>

                <?= $form->field($model, 'gender', ['options' => ['class' => 'login-input']])->dropdownList([User::GENDER_MALE => 'Мужской', User::GENDER_FEMALE => 'Женский'], ['class' => 'customselect'])->label(false); ?>

                <?= $form->field($model, 'region', ['options' => ['class' => 'login-input']])->dropdownList(ArrayHelper::merge(['Выберите регион' => 'Выберите регион'], $regionsArray), ['class' => 'customselect region-select'])->label(false); ?>
                <?= $form->field($model, 'city', ['options' => ['class' => 'login-input']])->dropdownList([], ['prompt'=>'Выберите город', 'class' => 'customselect city-select'])->label(false); ?>

                <?= $form->field($model, 'education', ['options' => ['class' => 'login-input']])->dropdownList($educationsArray, ['prompt'=>'Укажите Ваш уровень образования', 'class' => 'customselect '])->label(false); ?>
                <?= $form->field($model, 'count_of_children', ['options' => ['class' => 'login-input']])->textInput(['class' => '', 'placeholder' => 'Сколько у Вас лично детей до 18 лет, живущих с Вами?'])->label(false); ?>

            <!--   ==============================================================================================    -->

            <?= $form->field($model, 'age_of_children', ['options' => ['class' => 'login-input', ]])->dropdownList($age_of_children, ['class' => 'customselect', 'multiple' => true])->label('ВОЗРАСТ РЕБЕНКА (ЛЕТ)'); ?>

            <!--   ==============================================================================================    -->



            <?= $form->field($model, 'profession', ['options' => ['class' => 'login-input']])->dropdownList($professionsArray, ['prompt'=>'Род деятельности', 'class' => 'customselect profession-select'])->label(false); ?>
                <?= $form->field($model, 'profession_comment')->textarea(['class' => 'login-input', 'placeholder' => 'Комментарий - Род деятельности'])->label(false); ?>

                <?= $form->field($model, 'department', ['options' => ['class' => 'login-input']])->dropdownList($departmentsArray, ['prompt'=>'В каком отделе вы работаете', 'class' => 'customselect department-select'])->label(false); ?>

                <?= $form->field($model, 'fieldofactivity', ['options' => ['class' => 'login-input']])->dropdownList($fieldofactivitysArray, ['prompt'=>'Сфера деятельности', 'class' => 'customselect fieldofactivity-select'])->label(false); ?>

                <?= $form->field($model, 'company_size', ['options' => ['class' => 'login-input']])->dropdownList($companySizeArray, ['prompt'=>'Какой размер компании, в которой Вы работаете', 'class' => 'customselect company_size-select'])->label(false); ?>

                <?= $form->field($model, 'password', ['options' => ['class' => 'login-input']])->passwordInput(['class' => '', 'placeholder' => 'Пароль'])->label(false); ?>
                <?= $form->field($model, 'password_repeat', ['options' => ['class' => 'login-input']])->passwordInput(['class' => '', 'placeholder' => 'Повторить пароль'])->label(false); ?>

                <?= $form->field($model, 'agreement', ['template' => '{input}{label}{error}'])->checkbox([
                    'checked' => false,
                    'uncheck' => null,
                'label'=>'',
                'labelOptions'=>array('style'=>'padding:7px;'),
                'disabled'=>false,
                'style' => 'margin-left: 10px;',
            ])
                ->label('Cогласен на обработку персональных данных');
//            ?>



            <div class="btns-cont">
                    <div class="btn-cont">
                        <?= Html::submitButton('В личный кабинет', ['class' => 'btn-submit active']) ?>
                    </div>
                </div>

                <?php ActiveForm::end() ?>
        </div>
    </div>
</div>
<div class="load-wrapper">
    <div class="loader"></div>
</div>

<script src="/backend/web/js/region_city.js?<?= time(); ?>"></script>
<?php
$this->registerCss(<<<CSS
.input-group-addon {
    display: none;
}

CSS, );
?>