<?php

use common\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var common\models\UserSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <form method="post" id="users-list-form" action="<?= Url::to(['user/bulk-survey-email']) ?>">
        <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>" value="<?= Yii::$app->request->csrfToken; ?>" />

        <div style="margin-top: 30px; margin-bottom: 30px;">
            <button class="btn btn-primary">Send bulk survey email</button>
            <a href="<?= Url::to(['/user/index']) ?>" class="btn btn-warning">Reset filter</a>

            <div class="pages-with-active-users" style="display: none;"><div><h3>You have user(s) selected on page: <span></span></div>
        </div>

        <input type="hidden" name="userIds" value="">

    </form>

    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'class' => 'yii\grid\CheckboxColumn',
                'checkboxOptions' => function ($model) {
                    return ['checked' => false];
                }
            ],

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
                'urlCreator' => function ($action, User $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>

<?php

$this->registerJs(<<<JS

ids = [];
watchedPagesData = {};
activePages = [];

$(document).delegate('[name="selection[]"]', 'change', e => {
    const self = $(e.currentTarget);
    
    watchedPagesData[$('.pagination .active a').text()] = $('[name="selection[]"]').map((idx, e) => e.value);
    
    if (self.prop('checked')) {
        ids.push(self.val());
    } else {
        ids = ids.filter(id => id !== self.val());
    }
    
    $('[name="userIds"]').val(ids.join(','));
    
    activePages = [];
        
    for (const page in watchedPagesData) {            
        watchedPagesData[page].map((_, _id) => {
            if (ids.indexOf(_id) !== -1 && activePages.indexOf(page) === -1) {
                activePages.push(page);
            }
        });
    }
    
    $('.pages-with-active-users span').html(activePages.join(', '));
    
    activePages.length ? $('.pages-with-active-users').fadeIn() :  $('.pages-with-active-users').fadeOut();
});

$(document).delegate('.pagination a', 'click', e => {
    setTimeout(() => {
        ids.map(id => $(`input[type="checkbox"][value="\${id}"]`).prop('checked', true));
    }, 100);
});

JS);

?>