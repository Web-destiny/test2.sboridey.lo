<?php

use yii\grid\GridView;
use yii\helpers\Url;
?>

<link rel="stylesheet" href="/backend/web/npsResultsv2/font/Gilroy/stylesheet.css">
<link rel="stylesheet" href="/backend/web/npsResultsv2/css/results/daterangepicker.css">
<link rel="stylesheet" href="/backend/web/npsResultsv2/css/custom-select.css">
<link rel="stylesheet" href="/backend/web/npsResultsv2/css/style.css?v=1.0.0">
<link rel="stylesheet" href="/backend/web/npsResultsv2/css/results/results.css?v=1.0.1">

<script src="/backend/web/npsResultsv2/js/jquery-3.5.1.min.js"></script>

<div class="page-wrap">
    <div class="top-panel">
        <div class="logo">
            <img src="/backend/web/npsResultsv2/img/logo-white.svg" alt="">
        </div>
        <div class="notification-wrap">
            <a href="#">
                <div class="icon active">
                    <img src="/backend/web/npsResultsv2/img/notification-icon.png" alt="notification">
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
    <div class="content-wrap nps-content-wrap" style="margin-top: 20px;">
        <div class="filters-wrap hidden">
            <form action="">
                <div class="filters-wrapp__items">
                    <!-- блок выбора даты -->
                    <div class="box box-date">
                        <input readonly="readonly" type="text" class="date" value="Период">
                    </div>
                </div>
            </form>
        </div>
        <div class="questions-main-wrapper">
            <div class="questions-table-section">
                <div class="table-wrapper">
                    <div class="table-box">
                        <table>
                            <thead>
                                <tr>
                                    <th>ID опроса</th>
                                    <th>Название опроса</th>
                                    <th>Дата запуска</th>
                                    <th hidden>Перешли по ссылке</th>
                                    <th>Прошли опрос</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($models as $model): $model = (object) $model; ?>
                                    <tr>
                                        <td><?php echo $model->id ?></td>
                                        <td><?php echo $model->name; ?></td>
                                        <td><?php echo Yii::$app->formatter->asDate($model->created_at, 'php:d-m-Y H:i:s'); ?></td>
                                        <td hidden><?php echo $model->count_started; ?></td>
                                        <td><?php echo $model->count_total; ?></td>
                                        <td>
                                            <div class="table-icons">
                                                <a href="<?php echo Url::to(['/site/result-details', 'id' => $model->id]) ?>" class="icon">
                                                    <div class="icon-watch"></div>
                                                </a>
                                                <a href="<?php echo '/backend/web/site/export?id=' . $model->id; ?>" class="icon">
<!--                                                <a href="--><?php //echo Url::to(['/site/export', 'id' => $model->id]) ?><!--" class="icon">-->
                                                    <div class="icon-excel"></div>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

                        <?php
                        echo \yii\widgets\LinkPager::widget([
                            'pagination' => $pages,
                        ]);
                        ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="load-wrapper">
    <div class="loader"></div>
</div>
<script src="/backend/web/npsResultsv2/js/results/moment.js"></script>
<script src="/backend/web/npsResultsv2/js/results/daterangepicker.js"></script>
<script src="/backend/web/npsResultsv2/js/results/results.js"></script>
<script src="/backend/web/npsResultsv2/js/custom_select.js"></script>
<!-- <script src="./js/nps-results/table.js"></script> -->
<script>
    jQuery(function($) {
        $(function() {
            $('.box-date input[type=text]').daterangepicker({
                opens: 'rigth',
                autoUpdateInput: false,
                locale: {
                    format: 'DD-MM-YYYY',
                    applyLabel: 'Принять',
                    cancelLabel: 'Отмена',
                    invalidDateLabel: 'Выберите дату',
                    daysOfWeek: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'],
                    monthNames: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь',
                        'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'
                    ],
                    firstDay: 1
                }
            }, function(start, end, label) {});
        });
        $('.box-date input[type=text]').on('focus', function() {
            $(this).parent('.box-date').addClass('active-date');
        })
        $('.box-date input[type=text]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format(
                'DD-MM-YYYY'));
            $(this).parent('.box-date').removeClass('active-date');
        });

        $('.box-date input[type=text]').on('cancel.daterangepicker', function(ev, picker) {
            $(this).parent('.box-date').removeClass('active-date');
        });

        $(document).mouseup(function(e) {
            let date = $('.daterangepicker');
            if (!e.target.classList.contains('date')) {
                if (e.target != date[0] && date.has(e.target).length === 0) {
                    $('.active-date').removeClass('active-date');
                }
            }
        });
    });
    const items = $(('.menu-item'))
    $(items[2]).addClass('active');
</script>