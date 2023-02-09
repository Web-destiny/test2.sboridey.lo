<?php

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link rel="icon" type="image/svg+xml" href="/backend/web/img/favicon/favicon.svg">
    <link rel="apple-touch-icon" sizes="180x180" href="/backend/web/img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/backend/web/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/backend/web/img/favicon/favicon-16x16.png">
    <link rel="manifest" href="/backend/web/img/favicon/site.webmanifest">

    <link rel="stylesheet" href="/backend/web/font/Gilroy/stylesheet.css">
    <link rel="stylesheet" href="/backend/web/css/login.css?86754678">

    <script src="/backend/web/js/jquery-3.5.1.min.js"></script>
</head>

<body>
    <div class="login-page">
        <div class="header">
            <div class="logo">
                <img src="/backend/web/img/idea-logo.png" alt="Pool">
            </div>
        </div>
        <div class="login-content">
            <div class="img-cont">
                <img src="/backend/web/img/login-bg.png" alt="Вход">
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
                <div class="login-input">
                    <input type="email" name="LoginForm[email]" placeholder="Введите еmail" data-reqired>
                    <?php //echo  $form->field($model, 'email')->textInput(['autofocus' => true, 'placeholder' => 'Введите еmail',  'data-reqired' => 'reqired'])->label(false) 
                    ?>
                </div>
                <div class="login-input">
                    <input type="password" name="LoginForm[password]" placeholder="Пароль" data-reqired>
                    <?php  //echo  $form->field($model, 'password')->passwordInput(['placeholder' => 'Пароль', 'data-reqired' => 'reqired'])->label(false) 
                    ?>
                </div>
                <a class="forgot-password" href="#">Забыли пароль?</a>
                <div class="btns-cont">
                    <div class="btn-cont">
                        <button type="submit" class="btn-submit">
                            Далее
                        </button>
                    </div>
                    <div class="btn-cont">
                        <button class="btn-enter-google">
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
        <div class="loader"></div>
    </div>
    <script src="/backend/web/js/login.js?35345345"></script>
</body>

</html>