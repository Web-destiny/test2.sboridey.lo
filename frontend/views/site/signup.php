<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;

$this->title = 'Signup';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="login-page">
    <div class="header">
        <div class="logo">
            <img src="/img/idea-logo.png" alt="Pool">
        </div>
    </div>

    <?php if (Yii::$app->session->hasFlash('error_registration_first_step')) : ?>
        <div class="alert alert-danger alert-dismissable">
            <!--            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>-->
            <!--            <h4><i class="icon fa fa-check"></i>Saved!</h4>-->
            <?= Yii::$app->session->getFlash('error_registration_first_step') ?>
        </div>
    <?php endif; ?>

    <div class="login-content">
        <div class="img-cont">
            <img src="/img/login-bg.png" alt="">
        </div>
        <div class="login-form send-form">
            <?php $form = ActiveForm::begin([
                'id' => 'signup-form',
                'action' => ['site/agreement'],
                'method' => 'post',
            ]); ?>
            <!--            <form action="--><?php //echo Url::to(['/site/agreement']) 
                                                ?>
            <!--">-->
            <div class="login-header">
                Приветствуем вас <br>
                на платформе опросов
            </div>
            <div class="under-header">
                Уже есть аккаунт? <a href="<?php echo Url::to(['/site/login']) ?>" class="bold">Войдите</a>
            </div>
            <div class="login-input">
                <input type="text" name="SignupForm[username]" placeholder="Имя" data-reqired>
            </div>
            <div class="login-input">
                <input type="email" name="SignupForm[email]" placeholder="Введите еmail" data-reqired>
            </div>
            <div class="btns-cont">
                <div class="btn-cont">
                    <button type="submit" class="btn-submit">
                        Далее
                    </button>
                </div>
                <div class="btn-cont">
                    <button class="btn-enter-google btn-enter-social">
                        <span>
                            Регистрация с помощью
                        </span>
                    </button>
                </div>
                <div class="btn-cont">
                    <button class="btn-enter-vk btn-enter-social">
                        <span>
                            Регистрация с помощью
                        </span>
                    </button>
                </div>
                <div class="btn-cont">
                    <button class="btn-enter-facebook btn-enter-social">
                        <span>
                            Регистрация с помощью
                        </span>
                    </button>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<div class="load-wrapper">
    <div class="shape">
        <div class="circle"></div>
        <div class="circle"></div>
        <div class="circle"></div>
    </div>
    <div class="bottom-shadow">
        <div class="shape-shadow"></div>
        <div class="shape-shadow"></div>
        <div class="shape-shadow"></div>
    </div>
</div>
<script src="/js/login.js?57645346789"></script>