<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>

<div class="page-cont">
    <aside class="left-side">
        <div class="mobile-menu">
            <div class="b-menu">
                <div class="b-bun b-bun--top"></div>
                <div class="b-bun b-bun--mid"></div>
                <div class="b-bun b-bun--bottom"></div>
            </div>
        </div>
        <div class="main-panel">
            <div class="top-content">
                <div class="logo">
                    <img src="/img/idea-logo-white.png" alt="Pool">
                </div>
                <nav class="left-menu">
                    <div class="menu-item active">
                        <a href="./index.html">
                            <div class="icon icon-all"></div>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a href="<?php echo \yii\helpers\Url::to(['user-profile/index']) ?>">
                            <div class="icon icon-personal"></div>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a href="#">
                            <div class="icon icon-payment"></div>
                        </a>
                    </div>
                </nav>
            </div>
            <div class="bottom-content">
                <div class="faq-icon-wrap">
                    <div class="faq-icon show-faq-block">
                    </div>
                </div>
                <div class="chat-wrapper">
                    <div class="chat-top">
                        <div class="expand"></div>
                    </div>
                    <div class="messages-block">
                        <div class="messages-wrap">

                        </div>
                    </div>
                    <div class="message-input-wrap">
                        <form action="#">
                            <textarea name="message" rows="1" placeholder="Напишите, что вас беспокоит"></textarea>
                        </form>
                    </div>
                </div>
                <div class="faq-block">
                    <div class="faq-header">
                        Может, помочь?
                    </div>
                    <a href="#" class="faq-btn show-chat">
                        Да, пожалуйста
                    </a>
                    <div class="faq-img">
                        <img src="./img/faq-img.png" alt="FAQ">
                    </div>
                    <div class="bottom-text"></div>
                </div>
            </div>
        </div>
    </aside>
    <div class="right-side">
        <div class="top-panel">
            <div class="btn-cont">
                <a href="#" class="btn-orange btn-putInfo">
                    Заполнить информацию
                </a>
            </div>
            <div class="notification-cont">
                <a href="<?php echo \yii\helpers\Url::to(['site/logout']) ?>" class="notification-icon  <?php echo (!Yii::$app->user->isGuest) ? 'active' : '';   ?> "></a>
            </div>
        </div>
        <div class="page-content">
            <div class="right-block">
                <div class="statistic-block">
                    <div class="blocks-testStatistics">
                        <div class="block">
                            <div class="number">11</div>
                            <div class="text">
                                Тестов <br>
                                пройдены
                            </div>
                        </div>
                        <div class="block">
                            <div class="number">
                                4
                            </div>
                            <div class="text">
                                Тестов <br>
                                в процессе
                            </div>
                        </div>
                    </div>
                    <div class="statistic-content">
                        <div class="statistic-top">
                            <div class="menu">
                                <ul>
                                    <li>
                                        <a href="#" class="active">
                                            Learning Hours
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            My Courses
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="statistic-filter">
                                <form action="#">
                                    <div class="select-cont">
                                        <select name="q-1" class="customselect">
                                            <option value="Daily">Daily</option>
                                            <option selected value="Weekly">Weekly</option>
                                            <option value="Monthly">Monthly</option>
                                            <option value="Yearly">Yearly</option>
                                        </select>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="statistic-chart">
                            <div id="statisticChart"></div>
                            <script>
                                statisticData = {
                                    data: [0, 1.5, 2.5, 1, 4, 3, 2],
                                    labels: ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'],
                                }
                            </script>
                        </div>
                    </div>
                </div>
                <div class="ad-block">
                    <div class="ad-block-row">
                        <div class="ad-block-col">
                            <div class="header">
                                Learn even more!
                            </div>
                            <div class="text">
                                Unlock premium features
                                only for $9.99 per month.
                            </div>
                            <a href="#" class="get-premium">Go Premium</a>
                        </div>
                        <div class="ad-block-img">
                            <img src="/img/ad-block-img.svg" alt="Go Premium">
                        </div>
                    </div>
                </div>
            </div>
            <div class="center-block">
                <div class="wellcome-block">
                    <div class="flex-row">
                        <div class="text-col">
                            <div class="header">
                                Добро пожаловать!
                            </div>
                            <div class="notifications">
                                <div class="notification unread current">
                                    <a href="#">Для вас открыт новый опрос, <span class="main-text">хотите пройти?</span></a>
                                </div>
                                <div class="notification">
                                    <a href="#"><span class="main-text">Просмотрите результаты</span> за последние полгода</a>
                                </div>
                                <div class="notification">
                                    <a href="#"><span class="main-text">Завершите</span> тест, вам осталось 9%</a>
                                </div>
                            </div>
                        </div>
                        <div class="img-col">
                            <img src="/img/wellcom-img.svg" alt="Wellcome">
                        </div>
                    </div>
                </div>
                <div class="unfinished-pools-block">
                    <div class="pools-wrap">
                        <div class="unfinished-pools-list owl-carousel">
                            <div class="pools-item">
                                <div class="icon">
                                    <img src="/img/pool-picture-1.jpg" alt="">
                                </div>
                                <div class="name">
                                    Название теста
                                </div>
                                <div class="progress-wrap">
                                    <div class="percent progress-cirlce" data-percent="83">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="-1 -1 34 34">
                                            <circle cx="16" cy="16" r="15.9155" class="progress-bar__background" />
                                            <circle cx="16" cy="16" r="15.9155" class="progress-bar__progress js-progress-bar" />
                                        </svg>
                                    </div>
                                    <div class="text">
                                        83%
                                    </div>
                                </div>
                                <a href="#" class="btn-finish-pool">
                                    Продолжить
                                </a>
                            </div>
                            <div class="pools-item">
                                <div class="icon">
                                    <img src="/img/pool-picture-2.jpg" alt="">
                                </div>
                                <div class="name">
                                    Название теста
                                </div>
                                <div class="progress-wrap">
                                    <div class="percent progress-cirlce" data-percent="17">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="-1 -1 34 34">
                                            <circle cx="16" cy="16" r="15.9155" class="progress-bar__background" />
                                            <circle cx="16" cy="16" r="15.9155" class="progress-bar__progress js-progress-bar" />
                                        </svg>
                                    </div>
                                    <div class="text">
                                        17%
                                    </div>
                                </div>
                                <a href="#" class="btn-finish-pool">
                                    Продолжить
                                </a>
                            </div>
                            <div class="pools-item">
                                <div class="icon">
                                    <img src="/img/pool-picture-3.jpg" alt="">
                                </div>
                                <div class="name">
                                    Название теста
                                </div>
                                <div class="progress-wrap">
                                    <div class="percent progress-cirlce" data-percent="68">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="-1 -1 34 34">
                                            <circle cx="16" cy="16" r="15.9155" class="progress-bar__background" />
                                            <circle cx="16" cy="16" r="15.9155" class="progress-bar__progress js-progress-bar" />
                                        </svg>
                                    </div>
                                    <div class="text">
                                        68%
                                    </div>
                                </div>
                                <a href="#" class="btn-finish-pool">
                                    Продолжить
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-nav">
                        <div class="btn-prev"></div>
                        <div class="btn-next"></div>
                    </div>
                </div>
                <div class="header">
                    Тесты
                </div>
                <div class="top-menu">
                    <ul>
                        <li>
                            <a href="./index.html" class="active">
                                Все опросы
                            </a>
                        </li>
                        <li>
                            <a href="./saved_pools.html">
                                Сохраненные
                            </a>
                        </li>
                        <li>
                            <a href="./completed_pools.html">
                                Пройденные
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="pool-list">
                    <?php foreach ($surveys as $survey) : ?>
                        <div class="pool-item">
                            <div class="icon">
                                <img src="/img/pool-picture-2.jpg" alt="">
                            </div>
                            <div class="name">
                                <?php echo $survey->name;  ?>
                            </div>
                            <div class="time-block">
                                <div class="time-icon"></div>
                                <div class="sum"><?php echo (isset($surveysCount[$survey->id])) ? $surveysCount[$survey->id] : 0 ?> вопросов</div>
                            </div>
                            <div class="btn-wrap">
                                <a class="start-pool" href="<?php echo  \yii\helpers\Url::to(['/site/survey', 'id' => $survey->id, 'rs' => $survey->rand_string]) ?>">
                                    Пройти
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <?php
                    echo \yii\widgets\LinkPager::widget([
                        'pagination' => $pagination,
                        'hideOnSinglePage' => true,
                        'prevPageLabel' => '&laquo; ',
                        'nextPageLabel' => ' &raquo;',
                        'options' => [
                            'class' => 'pag-nav pagination pagination-circle pg-blue mb-0'
                        ],
                        'linkOptions' => ['class' => 'page-link'],
                        'activePageCssClass' => 'active-page',
                    ]);
                    ?>

                    <!--                    <div class="pool-item">-->
                    <!--                        <div class="icon">-->
                    <!--                            <img src="./img/pool-picture-2.jpg" alt="">-->
                    <!--                        </div>-->
                    <!--                        <div class="name">-->
                    <!--                            Название теста11111111111111111-->
                    <!--                        </div>-->
                    <!--                        <div class="time-block">-->
                    <!--                            <div class="time-icon"></div>-->
                    <!--                            <div class="sum">55 вопросов</div>-->
                    <!--                        </div>-->
                    <!--                        <div class="btn-wrap">-->
                    <!--                            <a class="start-pool" href="#">-->
                    <!--                                Пройти-->
                    <!--                            </a>-->
                    <!--                        </div>-->
                    <!--                    </div>-->
                    <!--                    <div class="pool-item">-->
                    <!--                        <div class="icon">-->
                    <!--                            <img src="./img/pool-picture-3.jpg" alt="">-->
                    <!--                        </div>-->
                    <!--                        <div class="name">-->
                    <!--                            Название теста-->
                    <!--                        </div>-->
                    <!--                        <div class="time-block">-->
                    <!--                            <div class="time-icon"></div>-->
                    <!--                            <div class="sum">55 вопросов</div>-->
                    <!--                        </div>-->
                    <!--                        <div class="btn-wrap">-->
                    <!--                            <a class="start-pool" href="#">-->
                    <!--                                Пройти-->
                    <!--                            </a>-->
                    <!--                        </div>-->
                    <!--                    </div>-->
                    <!--                    <div class="pool-item">-->
                    <!--                        <div class="icon">-->
                    <!--                            <img src="./img/pool-picture-4.jpg" alt="">-->
                    <!--                        </div>-->
                    <!--                        <div class="name">-->
                    <!--                            Название теста-->
                    <!--                        </div>-->
                    <!--                        <div class="time-block">-->
                    <!--                            <div class="time-icon"></div>-->
                    <!--                            <div class="sum">55 вопросов</div>-->
                    <!--                        </div>-->
                    <!--                        <div class="btn-wrap">-->
                    <!--                            <a class="start-pool" href="#">-->
                    <!--                                Пройти-->
                    <!--                            </a>-->
                    <!--                        </div>-->
                    <!--                    </div>-->
                    <!--                    <div class="pool-item">-->
                    <!--                        <div class="icon">-->
                    <!--                            <img src="./img/pool-picture-5.jpg" alt="">-->
                    <!--                        </div>-->
                    <!--                        <div class="name">-->
                    <!--                            Название теста-->
                    <!--                        </div>-->
                    <!--                        <div class="time-block">-->
                    <!--                            <div class="time-icon"></div>-->
                    <!--                            <div class="sum">55 вопросов</div>-->
                    <!--                        </div>-->
                    <!--                        <div class="btn-wrap">-->
                    <!--                            <a class="start-pool" href="#">-->
                    <!--                                Пройти-->
                    <!--                            </a>-->
                    <!--                        </div>-->
                    <!--                    </div>-->
                    <!--                    <div class="pool-item">-->
                    <!--                        <div class="icon">-->
                    <!--                            <img src="./img/pool-picture-6.jpg" alt="">-->
                    <!--                        </div>-->
                    <!--                        <div class="name">-->
                    <!--                            Название теста-->
                    <!--                        </div>-->
                    <!--                        <div class="time-block">-->
                    <!--                            <div class="time-icon"></div>-->
                    <!--                            <div class="sum">55 вопросов</div>-->
                    <!--                        </div>-->
                    <!--                        <div class="btn-wrap">-->
                    <!--                            <a class="start-pool" href="#">-->
                    <!--                                Пройти-->
                    <!--                            </a>-->
                    <!--                        </div>-->
                    <!--                    </div>-->
                </div>
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
<script src="/js/apexcharts.min.js"></script>
<script src="/js/custom_select.js"></script>
<script src="/js/owl.carousel.min.js"></script>
<script src="/js/statistic_chart.js"></script>
<script src="/js/script.js?76545678"></script>