<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

$this->title = 'thanks-for-registration';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="login-page">
    <div class="header">
        <div class="logo">
            <img src="/img/logo-pool.svg" alt="Pool">
        </div>
    </div>
    <div class="login-content thanks-wrap">
        <div class="img-cont">
            <img src="/img/thanks-registr-bg.jpg" alt="">
        </div>
        <div class="agreement-form">
            <div class="text">
                <div class="login-header">
                    Спасибо!
                </div>
                <div class="under-header">
                    Вы добавлены в базу для опросов.
                </div>
                <div class="under-header">
                    На вашу почту было отправлено письмо, для подтверждения регистрации <span class="bold">перейдите по ссылке</span>
                </div>
                <div class="under-header">
                    Проходите опросы и зарабатывайте деньги
                </div>
            </div>
            <div class="btn-cont">
                <a href="#" class="btn-next active">
                    Зарабатывать!
                </a>
            </div>
        </div>
    </div>
</div>
<div class="load-wrapper">
    <div class="loader"></div>
</div>