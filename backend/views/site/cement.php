<?php

use yii\bootstrap4\ActiveForm;
?>

<div class="page-wrap">
    <div class="top-panel">
        <div class="logo">
            <img src="/backend/web/img/idea-logo-white.png" alt="">
        </div>
        <div class="notification-wrap">
            <a href="#">
                <div class="icon active">
                    <img src="/backend/web/img/notification-icon.png" alt="notification">
                </div>
            </a>
            <div class="exit-wrap">
                <a href="<?php echo \yii\helpers\Url::to(['site/logout']) ?>">
                    <div class="exit-icon"></div>
                    <div class="exit-text">
                        Выйти
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="content-wrap">
        <div class="top-nav">
            <div class="nav-back">
                <a href="<?php echo \yii\helpers\Url::to(['/site/index'])  ?>">
                    Все опросы
                </a>
            </div>
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
<script src="/backend/web/js/custom_select.js"></script>
<script src="/backend/web/js/script.js?876564587"></script>
<script src="/backend/web/js/form-script.js?345345345"></script>