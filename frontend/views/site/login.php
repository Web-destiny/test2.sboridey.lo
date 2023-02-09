<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\bootstrap4\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="login-page">
    <!-- <div class="header">
        <div class="logo">
            <img src="/img/idea-logo.png" alt="Pool">
        </div>
    </div> -->
    <header class="page-header" style="padding: 59px 0 39px 0 !important">
        <div class="container">
            <a href="https://sboridey.ru/" class="page-header__logo"><img src="/landing/images/logo-header.svg" alt="header-logo"></a>
        </div>
    </header>

    <div class="login-content">
        <div class="img-cont">
            <img src="/img/login2-bg.png" alt="">
        </div>
        <div class="login-form send-form">
            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
                'fieldConfig' => [
                    'options' => [
                        'tag' => false,
                    ],
                ],
            ]); ?>
            <div class="login-header">
                Вход
            </div>
            <div class="under-header">
                Нет аккаунта? <a href="<?php echo Url::to(['/site/sign-up']) ?>" class="bold">Зарегестрируйтесь</a>
            </div>
            <div class="login-input <?php if ($err) echo 'has-error';  ?>">
                <input type="text" name="LoginForm[username]" placeholder="Имя" data-reqired>
            </div>
            <div class="login-input <?php if ($err) echo 'has-error';  ?>">
                <input type="password" name="LoginForm[password]" placeholder="Пароль" data-reqired>
            </div>

            <?php if ($err) : ?>
                <div class="login-error">
                    <?php echo $err;  ?>
                </div>
            <?php endif; ?>
            <div class="btns-cont">
                <div class="btn-cont">
                    <button type="submit" class="btn-submit">
                        Далее
                    </button>
                </div>
                <div class="btn-cont">
                    <button class="btn-enter-google btn-enter-social">
                        <span>
                            Вход с помощью
                        </span>
                    </button>
                </div>
                <div class="btn-cont">
                    <button class="btn-enter-vk btn-enter-social">
                        <span>
                            Вход с помощью
                        </span>
                    </button>
                </div>
                <div class="btn-cont">
                    <button class="btn-enter-facebook btn-enter-social">
                        <span>
                            Вход с помощью
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
<script src="/js/login.js?345345"></script>