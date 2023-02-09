<?php

use backend\assets\AppAsset;
use yii\helpers\Html;

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
        <title><?php echo  \Yii::t('app', 'Все опросы'); ?> </title>

        <link rel="icon" type="image/svg+xml" href="/backend/web/img/favicon/favicon.svg">
        <link rel="apple-touch-icon" sizes="180x180" href="/backend/web/img/favicon/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/backend/web/img/favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/backend/web/img/favicon/favicon-16x16.png">
        <link rel="manifest" href="/backend/web/img/favicon/site.webmanifest">

        <link rel="stylesheet" href="/backend/web/font/Gilroy/stylesheet.css">
        <link rel="stylesheet" href="/backend/web/css/jquery-ui.css">
        <link rel="stylesheet" href="/backend/web/css/custom-select.css?<?= time(); ?>">
        <link rel="stylesheet" href="/backend/web/css/bootstrap-datepicker3.standalone.css">
        <link rel="stylesheet" href="/backend/web/css/intlTelInput.css">
        <link rel="stylesheet" href="/backend/web/css/style.css?<?= time(); ?>">

        <script src="/backend/web/js/jquery-3.5.1.min.js"></script>


        <?php $this->registerCsrfMetaTags() ?>
    </head>

    <body class="login-page">

    <?php $this->beginBody() ?>

    <?= $content ?>






    <script src="/backend/web/js/preview.js?<?= time(); ?>"></script>


    <?php $this->endBody() ?>


    </body>

    </html>
<?php $this->endPage() ?>
