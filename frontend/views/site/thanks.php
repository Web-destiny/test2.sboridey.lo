<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Опрос</title>

    <link rel="icon" type="image/svg+xml" href="/frontend/web/img/favicon/favicon.svg">
    <link rel="apple-touch-icon" sizes="180x180" href="/frontend/web/img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/frontend/web/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/frontend/web/img/favicon/favicon-16x16.png">
    <link rel="manifest" href="/frontend/web/img/favicon/site.webmanifest">

    <link rel="stylesheet" href="/font/Gilroy/stylesheet.css">
    <link rel="stylesheet" href="/css/style.css?4523423">

    <script src="/js/jquery-3.5.1.min.js"></script>
</head>
<body>
<div class="page-wrap">
    <div class="content-wrap survey-page">
        <div class="pool-wrap">
            <div class="pool-bg" style="background-image: url(/frontend/web/img/survey/j-4WXQ8PDmI.jpg);"></div>
            <div class="thanks-wrap">
                <div class="thanks-text">
                <div class="text-big">
                    Благодарим за прохождение опроса!
                </div>
                <div class="text">
                    Вы помогаете нам стать лучше
                </div>

                </div>
                <div class="link-wrap">
                    <a class="link-item" href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/">На сайт</a>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="load-wrapper">
    <div class="loader"></div>
</div>
<script src="/js/script.js"></script>
</body>
</html>