<?php
/**
 * @var \yii\web\View $this
 * @var string $html
 * @var string $id
 * @var array $options
 * @var array $cementLocations
 * @var array $cementDepartments
 * @var array $cementSupervisor
 */

use yii\helpers\Url; ?>


<form method="get" class="filter-wrap cement-block mb-10 pd-20">
    <input type="hidden" name="id" value="<?= $id ?>">

    <div class="filter-item-cement mb-20">
        <div data-id="1" class="cement-select-label mb-10" hidden style="color: rgb(255, 0, 0);">Выберите пожалуйста, свое местоположение</div>
        <select name="param1" class="customselect city-select">
            <?php if (empty($options['param1'])): ?>
                <option selected disabled>Город</option>
            <?php endif; ?>

            <?php foreach ($cementLocations as $item): ?>
                <option <?= $options['param1'] == $item->id ? 'selected' : ''; ?> value="<?= $item->id; ?>"><?= $item->name; ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="filter-item-cement mb-20">
        <div data-id="2" class="cement-select-label mb-10" hidden style="color: rgb(255, 0, 0);">Укажите Ваше подразделение</div>
        <select name="param2" class="customselect department-select">
            <?php if (empty($options['param2'])): ?>
                <option selected disabled>Подразделение</option>
            <?php endif; ?>

            <?php foreach ($cementDepartments as $item): ?>
                <option <?= $options['param2'] == $item->id ? 'selected' : ''; ?> value="<?= $item->id; ?>"><?= $item->name; ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="filter-item-cement">
        <div data-id="3" class="cement-select-label mb-10" hidden style="color: rgb(255, 0, 0);">Выберите имя Вашего руководителя</div>
        <select name="param3" class="customselect supervisor-select">
            <?php if (empty($options['param3'])): ?>
                <option selected disabled>ФИО руководителя</option>
            <?php endif; ?>

            <?php foreach ($cementSupervisor as $item): ?>
                <option <?= $options['param3'] == $item->id ? 'selected' : ''; ?> value="<?= $item->id; ?>"><?= $item->name; ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="filter-item-cement filter-item-btn">
        <div data-id="2" class="cement-select-label mb-10" hidden style="color: rgb(255, 0, 0);">&nbsp;</div>
        <button type="submit" class="btn btn-md btn-primary">Filter</button>
        <a href="<?= Url::to(['site/result-details', 'id' => $id]) ?>" class="btn btn-md btn-danger">Reset</a>
    </div>
</form>


<?php

$this->registerCssFile('/backend/web/npsResultsv2/css/results/daterangepicker.css');
$this->registerCssFile('/backend/web/npsResultsv2/css/results/results.css');

echo $html;

$this->registerJsFile('/backend/web/npsResultsv2/js/results/moment.js');
$this->registerJsFile('/backend/web/npsResultsv2/js/results/daterangepicker.js');
$this->registerJsFile('/backend/web/npsResultsv2/js/results/results.js');
$this->registerJsFile('/backend/web/npsResultsv2/js/custom_select.js');
$this->registerJsFile('/backend/web/npsResultsv2/js/results/results-libs/chart.js');
$this->registerJsFile('/backend/web/npsResultsv2/js/results/results-libs/chartjs-plugin-datalabels.min.js');

$this->registerCss(<<<CSS
.cement-block {
    display: flex;
    column-gap: 50px;
    row-gap: 50px;
    flex-wrap: wrap;
    align-items: center;
    margin-top: 35px;
}
.cement-block .cement-select-label {
    padding-bottom: 20px;
}
.cement-block .filter-item-btn {
    display: flex;
    flex-wrap: wrap;
    column-gap: 10px;
}
.cement-block .btn {
    min-width: 100px;
}
.cement-block .customselect-wrapper {
    max-width: 100%;
    min-width: 300px;
}
CSS);

$this->registerJs(<<<JS
jQuery(function ($) {
            $(function () {
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
                }, function (start, end, label) {});
            });
            $('.box-date input[type=text]').on('focus', function () {
                $(this).parent('.box-date').addClass('active-date');
            })
            $('.box-date input[type=text]').on('apply.daterangepicker', function (ev, picker) {
                $(this).val(picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format(
                    'DD-MM-YYYY'));
                $(this).parent('.box-date').removeClass('active-date');
            });

            $('.box-date input[type=text]').on('cancel.daterangepicker', function (ev, picker) {
                $(this).parent('.box-date').removeClass('active-date');
            });

            $(document).mouseup(function (e) {
                let date = $('.daterangepicker');
                if (!e.target.classList.contains('date')) {
                    if (e.target != date[0] && date.has(e.target).length === 0) {
                        $('.active-date').removeClass('active-date');
                    }
                }
            });
        });
JS);
$this->registerJsFile('/backend/web/npsResultsv2/js/results/results-charts.js');
$this->registerJsFile('/backend/web/js/cement.js');

?>
