<?php

/* @var $this \yii\web\View */
/* @var $content string */

dmstr\web\AdminLteAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0">
    <title>All survey </title>

    <link rel="icon" type="image/svg+xml" href="/backend/web/img/favicon/favicon.svg">
    <link rel="apple-touch-icon" sizes="180x180" href="/backend/web/img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/backend/web/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/backend/web/img/favicon/favicon-16x16.png">
    <link rel="manifest" href="/backend/web/img/favicon/site.webmanifest">

    <link rel="stylesheet" href="/backend/web/font/Gilroy/stylesheet.css">
    <link rel="stylesheet" href="/backend/web/css/jquery-ui.css">
    <link rel="stylesheet" href="/backend/web/css/custom-select.css">
    <link rel="stylesheet" href="/backend/web/css/bootstrap-datepicker3.standalone.css">
    <link rel="stylesheet" href="/backend/web/css/intlTelInput.css">
    <link rel="stylesheet" href="/backend/web/css/style.css?3453534536">

    <?php $this->head() ?>

    <script src="/backend/web/js/jquery-3.5.1.min.js"></script>

    <?php $this->registerCsrfMetaTags() ?>
</head>

<body>

    <?php $this->beginBody() ?>

    <?php

    use backend\models\User;
    use yii\helpers\ArrayHelper;
    use  yii\helpers\Url;
    ?>

    <div class="page-wrap">
        <div class="top-panel">
            <div class="logo">
                <img src="/backend/web/img/idea-logo-white.png" alt="">
            </div>
            <div class="notification-wrap">
                <a href="<?php echo \yii\helpers\Url::to(['site/logout']) ?>">
                    <div class="icon  <?php echo (!Yii::$app->user->isGuest) ? 'active' : '';   ?>">
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
            <?php if (ArrayHelper::getValue($this->params, 'showTopMenu', true)) : ?>
                <div class="top-nav">
                    <div class="pools-menu">
                        <?php if (User::isAdmin()) : ?>
                            <div class="menu-item <?= Yii::$app->controller->action->id == 'index' ? 'active' : ''; ?>">
                                <a href="<?= Url::to(['/site/index'])  ?>">
                                    Все опросы
                                </a>
                            </div>
                            <div class="menu-item <?= Yii::$app->controller->action->id == 'archive' ? 'active' : ''; ?>">
                                <a href="<?= Url::to(['/site/archive'])  ?>">
                                    Архив
                                </a>
                            </div>
                        <?php endif; ?>

                        <div class="menu-item <?= Yii::$app->controller->action->id == 'export' ? 'active' : ''; ?>">
                            <a href="<?= Url::to(['/site/results'])  ?>">
                                Результаты
                            </a>
                        </div>
                        <?php if (User::isAdmin()) : ?>
                            <div class="menu-item <?= Yii::$app->controller->action->id == 'managers' ? 'active' : ''; ?>">
                                <a href="<?= Url::to(['/site/managers'])  ?>">
                                    Managers
                                </a>
                            </div>

                            <div class="menu-item <?= Yii::$app->controller->action->id == 'consultations' ? 'active' : ''; ?>">
                                <a href="<?= Url::to(['/site/consultations'])  ?>">
                                    Консультации
                                </a>
                            </div>

                            <div class="menu-item >">
                                <a href="<?= Url::to(['/cement-city/common'])  ?>">
                                    Страница - цемент
                                </a>
                            </div>
                        <?php endif; ?>

                    </div>
                    <div class="btn-wrap">
                        <a href="<?= Url::to(['/site/create-pool'])  ?>" class="btn-create-pool">Создать опрос</a>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (Yii::$app->session->hasFlash('success')) : ?>
                <div class="alert alert-success">
                    <?= Yii::$app->session->getFlash('success'); ?>
                </div>
            <?php endif; ?>

            <?= $content ?>
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
    <script src="/backend/web/js/script.js"></script>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>