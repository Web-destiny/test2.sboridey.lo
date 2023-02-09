<?php

use common\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\UserSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="hidden">
        <p>
            <?= Html::a('Расширенный профиль', [Url::to(['user-profile/additional-update', 'user_id' => Yii::$app->user->id])], ['class' => 'btn btn-success']) ?>
        </p>
    </div>


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'username',
            'first_name',
            'last_name',
            'gender',
            //'region',
            //'city',
            //'education',
            //'count_of_children',
            //'age_of_children',
            //'phone',
            //'birth_day',
            //'profession',
            //'profession_comment:ntext',
            //'department',
            //'fieldofactivity',
            //'company_size',
            //'password',
            //'auth_key',
            //'password_hash',
            //'password_reset_token',
            //'email:email',
            //'status',
            //'verification_token',
            //'created_at',
            //'updated_at',
            [
                'class' => ActionColumn::className(),
                'template' => '{update}',
                'urlCreator' => function ($action, User $model, $key, $index, $column) {
                    return Url::to(['user-profile/base-index', 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>


</div>
