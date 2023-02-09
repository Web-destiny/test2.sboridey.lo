<?php

/* @var $this \yii\web\View */
/* @var $content string */

use common\widgets\Alert;
use frontend\assets\AppAsset;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
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

    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>


<body class="d-flex flex-column h-100">
    <?php $this->beginBody() ?>

    <?= $content ?>

    <script src="/js/login.js?57645346789"></script>

<!--    <script src="/js/apexcharts.min.js"></script>-->
<!--    <script src="/js/custom_select.js"></script>-->
<!--    <script src="/js/owl.carousel.min.js"></script>-->
<!--    <script src="/js/statistic_chart.js"></script>-->
<!--    <script src="/js/script.js?76545678"></script>-->

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage();
