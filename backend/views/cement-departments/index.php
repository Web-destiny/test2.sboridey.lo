<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Подразделения';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cement-department-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Cement Department', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php $form = ActiveForm::begin(); ?>
        <div class="cement-department-form">
            <div class="row">
                <div class="col-md-4">
                    <div data-id="1" class="cement-select-label" style="color: #FF0000; font-size: 15px;">Выберите пожалуйса, свое местоположение</div>

                    <?= $form->field($model, 'id', ['template' => '{input}{error}{hint}'])
                        ->dropDownList(ArrayHelper::merge(['' => 'Город'], ArrayHelper::map($locations, 'id', 'name')), [
                            "empty" => "Не выбрано",
                            'class' => 'form-control customselect city-select',
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

    <?php ActiveForm::end(); ?>



    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'location_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>

<?php
$this->registerCss(<<<CSS
.cement-department-form {
    padding-top: 20px;
    padding-bottom: 20px;
    border-bottom: solid 1px;
    margin-bottom: 40px;
}
CSS);
?>

<?php
$this->registerJs(<<<JS
$('.form-group').map((idx, item) => {
    item = $(item);

    const classes = item.find('[data-group-class]').data('group-class');
    
    item.addClass(classes);
});
JS);
?>