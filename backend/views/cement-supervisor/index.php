<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Руководители';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cement-supervisor-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <form id="newForm" method="get" action="/backend/web/cement-supervisor/create">
        <p>
            <input type="hidden" id="supervizorId" name="department_id" value="">
            <button type="button" id="new-supervizor" class="btn btn-primary">Новый руковдитель</button>
        </p>
    </form>


    <hr>
    <?php $form = \yii\widgets\ActiveForm::begin(); ?>
    <div class="cement-department-form">
        <div class="row">
            <div class="col-md-4">
                <div data-id="1" class="cement-select-label" style="color: #FF0000; font-size: 15px;">Выберите пожалуйса, свое местоположение</div>

                <?= $form->field($model, 'id', ['template' => '{input}{error}{hint}'])
                    ->dropDownList(\yii\helpers\ArrayHelper::merge(['' => 'Город'], \yii\helpers\ArrayHelper::map($locations, 'id', 'name')), [
                        "empty" => "Не выбрано",
                        'class' => 'form-control customselect city-select',
                        'data-group-class' => 'filter-item-cement'
                    ]);?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div data-id="1" class="cement-select-label" style="color: #FF0000; font-size: 15px;">Укажите Ваше подразделениее</div>

                <?= $form->field($departmentsModel, 'id', ['template' => '{input}{error}{hint}'])
                    ->dropDownList(\yii\helpers\ArrayHelper::merge(['' => 'Подразделение'], \yii\helpers\ArrayHelper::map($departments, 'id', 'name')), [
                        "empty" => "Не выбрано",
                        'class' => 'form-control customselect department-select',
                        'data-group-class' => 'filter-item-cement'
                    ]);?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <?= Html::submitButton('Выбрать', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>

    <?php \yii\widgets\ActiveForm::end(); ?>
    <hr>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'department_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>


<?php
$this->registerJs(<<<JS

$( "#new-supervizor" ).on( "click", function() {
    if($.isNumeric(parseInt($('#cementdepartment-id').val()))) {
        $('#supervizorId').val($('#cementdepartment-id').val());
        $('#newForm').submit();
    }
    
});
JS);
?>

<script src="/frontend/web/js/jquery-3.5.1.min.js"></script>
<script src="/backend/web/js/cement.js?<?= time(); ?>"></script>
