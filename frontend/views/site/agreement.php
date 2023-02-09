<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

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
            <img src="/img/login-bg.png" alt="">
        </div>
        <div class="agreement-form send-form">
            <form action="detail-form">
                <div class="login-header">
                    Пользовательськое<br>
                    соглашение!
                </div>
                <div class="under-header">
                    Настоящим, действуя своей волей и в своем интересе, даю согласие Poolcomment на обработку своих персональных данных  с целью изучения конъюнктуры рынка, получения и исследования статистических данных, участия в исследованиях, осуществления других видов деятельности в рамках законодательства РФ с обязательным выполнением требований законодательства РФ в области персональных данных, а также соглашаюсь с тем, что мои персональные данные могут быть переданы третьим лицам с соблюдением требований законодательства РФ и на условиях конфиденциальности в случае, если это необходимо для реализации вышеуказанных целей и выражаю свое согласие на получение  рекламных и иных материалов путем осуществления прямых контактов с использованием всех средств связи, включая, но не ограничиваясь: почтовая рассылка, СМС-рассылка, голосовая рассылка, рассылка электронных писем.
                </div>
                <div class="radio-input">
                    <input type="checkbox" name="q-1" id="q-1" data-reqired="reqired">
                    <label for="q-1">
                        <div class="check"></div>
                        <span>
                                Я ознакомился и принимаю <span class="bold">Пользовательское соглашение</span>
                            </span>
                    </label>
                </div>
                <div class="btns-cont">
                    <div class="btn-cont">
                        <button type="submit" class="btn-submit">
                            Далее
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="load-wrapper">
    <div class="loader"></div>
</div>

<div class="load-wrapper">
    <div class="loader"></div>
</div>
