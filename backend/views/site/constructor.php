<?php

use yii\helpers\Url;

?>
<div class="page-wrap">
    <div class="top-panel">
        <div class="logo">
            <img src="/img/idea-logo-white.png" alt="">
        </div>
        <div class="notification-wrap">

            <div class="icon-exit">
                <a href="#">
                    <div class="icon active">
                        <img src="/img/notification-icon.png" alt="notification">
                    </div>
                </a>
                <div class="exit-wrap">
                    <a href="<?php echo \yii\helpers\Url::to(['site/logout']) ?>">
                        <div class="exit-icon"></div>
                        <div class="exit-text">
                            <?php echo  \Yii::t('app', 'Выйти'); ?>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="content-wrap">
        <div class="top-nav">
            <div class="nav-back">
                <a href="<?php echo Url::to(['/site/index']); ?>">
                    <?php echo $survey->name ?>
                </a>
            </div>
            <div class="pools-menu">
                <div class="menu-item active">
                    <a href="#">
                        <?php echo  \Yii::t('app', 'Вопросы'); ?>
                    </a>
                </div>
                <div class="menu-item">
                    <a href="#">
                        <?php echo  \Yii::t('app', 'Дизайн'); ?>
                    </a>
                </div>
                <div class="menu-item active">
                    <a href="<?php echo Url::to(['/site/update-pool', 'survey_id' => $survey->id]); ?>">
                        Редактировать описание
                    </a>
                </div>
            </div>
        </div>
        <div class="constr-wrap">
            <div class="left-side">
                <div class="mobile-aside">
                    <span></span>
                </div>
                <div class="mode-view-wrap">
                    <div class="mode-view-item">
                        <div class="mode-view mode-full active"></div>
                    </div>
                    <div class="mode-view-item">
                        <div class="mode-view mode-icons"></div>
                    </div>
                </div>
                <div class="listbox">
                    <div class="list-item" data-type="single">
                        <div class="icon icon-single"></div>
                        <div class="name"><?php echo  \Yii::t('app', 'Выбор из списка'); ?></div>
                    </div>
                    <div class="list-item" data-type="free-answer">
                        <div class="icon icon-free"></div>
                        <div class="name"><?php echo  \Yii::t('app', 'Свободный ответ'); ?></div>
                    </div>
                    <!-- <div class="list-item" data-type="branching">
                        <div class="icon icon-branching"></div>
                        <div class="name">Ветвление ответа</div>
                    </div> -->
                    <div class="list-item" data-type="scale">
                        <div class="icon icon-scale"></div>
                        <div class="name"><?php echo  \Yii::t('app', 'Шкала оценок'); ?></div>
                    </div>
                    <div class="list-item" data-type="nps">
                        <div class="icon icon-scale"></div>
                        <div class="name">NPS</div>
                    </div>
                    <div class="list-item" data-type="dropdown">
                        <div class="icon icon-dropdown"></div>
                        <div class="name"><?php echo  \Yii::t('app', 'Выпадающий список'); ?></div>
                    </div>
                    <div class="list-item" data-type="matrix">
                        <div class="icon icon-matrix"></div>
                        <div class="name"><?php echo  \Yii::t('app', 'Матрица'); ?></div>
                    </div>
                    <div class="list-item" data-type="ranging">
                        <div class="icon icon-ranging"></div>
                        <div class="name"><?php echo  \Yii::t('app', 'Ранжирование'); ?></div>
                    </div>
                    <div class="list-item" data-type="name">
                        <div class="icon icon-name"></div>
                        <div class="name"><?php echo  \Yii::t('app', 'ФИО'); ?></div>
                    </div>
                    <div class="list-item" data-type="date">
                        <div class="icon icon-date"></div>
                        <div class="name"><?php echo  \Yii::t('app', 'Дата'); ?></div>
                    </div>
                    <div class="list-item" data-type="email">
                        <div class="icon icon-email"></div>
                        <div class="name">E-mail</div>
                    </div>
                    <!--
                    <div class="list-item" data-type="phone">
                        <div class="icon icon-phone"></div>
                        <div class="name">Номер телефона</div>
                    </div>
                    <div class="list-item" data-type="file">
                        <div class="icon icon-file"></div>
                        <div class="name">Загрузить файл</div>
                    </div> -->
                </div>
            </div>
            <div class="center-block">
                <div class="filter-wrap">
                    <div class="filter-item">
                        <select name="" class="customselect">
                            <option selected disabled>Пол</option>
                            <option value="Мужской">Мужской</option>
                            <option value="Женский">Женский</option>
                        </select>
                    </div>
                    <div class="filter-item">
                        <select name="" class="customselect">
                            <option selected disabled>Возраст</option>
                            <option value="18-25 лет">18-25 лет</option>
                            <option value="25-35 лет">25-35 лет</option>
                            <option value="35-45 лет">35-45 лет</option>
                            <option value="45-60 лет">45-60 лет</option>
                            <option value="Старше 60 лет">Старше 60 лет</option>
                        </select>
                    </div>
                    <div class="filter-item">
                        <select name="" class="customselect">
                            <option selected disabled>ГЕО</option>
                            <option value="города 1 млн+">города 1 млн+</option>
                            <option value="города 500+">города 500+</option>
                            <option value="города 100+">города 100+</option>
                        </select>
                    </div>

                    <div class="filter-item">
                        <select name="" class="customselect city-select">
                            <option selected disabled>Город</option>
                            <?php foreach ($locations as $location): ?>
                                <option value="<?= $location->id; ?>"><?= $location->name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="add-chapter-wrap">
                    <div class="chapter-item add-chapter" data-type="chapter"><?php echo  \Yii::t('app', 'Раздел анкеты'); ?></div>
                    <div class="chapter-item chapter-position-btn"><?php echo  \Yii::t('app', 'Переместить раздел'); ?></div>
                </div>
                <div class="questions-box <?= $constructor ? '' : 'empty' ?>">
                    <form action="<?= Url::to(['site/constructor', 'id' => $id]) ?>" class="constructo-form" autocomplete="off" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>" value="<?= Yii::$app->request->csrfToken; ?>" />

                        <div class="questions-list">

                            <?= $constructor; ?>

                            <div class="btn-preview-wrap">
                                <button class="btn-save btn-default" name="saveData"><?php echo  \Yii::t('app', 'Сохранить'); ?></button>
                                <button class="btn-preview btn-default" name="preview"><?php echo  \Yii::t('app', 'Предпросмотр'); ?></button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="chapters-list-bg">
    <div class="chapters-list-container">
        <div class="chapter-list-header">
            <p><?php echo  \Yii::t('app', 'Изменить порядок разделов'); ?></p>
            <p><?php echo  \Yii::t('app', 'Проверьте логичность переходов между разделами после изменения порядка'); ?>.</p>
        </div>
        <div class="chapters-list">
            <form action="">
            </form>
        </div>
        <div class="chapters-list__navigation-btn-wrapper">
            <i class="chapters-list__popup-close constructor-btn"></i>
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
<script src="/backend/web/js/jquery-ui.js"></script>
<script src="/backend/web/js/jquery.ui.touch-punch.min.js"></script>
<script src="/backend/web/js/Sortable.min.js"></script>
<script src="/backend/web/js/bootstrap-datepicker.min.js"></script>
<script src="/backend/web/js/bootstrap-datepicker.ru.min.js"></script>
<script src="/backend/web/js/custom_select.js"></script>
<script src="/backend/web/js/wavesurfer.min.js"></script>
<script src="/backend/web/js/video-radio-star.js"></script>
<script src="/backend/web/js/intlTelInput.js"></script>
<script src="/backend/web/js/jquery.mask.min.js"></script>
<script src="/backend/web/js/script.js?1253242341"></script>
<script src="/backend/web/js/validation.js?<?= time(); ?>"></script>
<script type="module" src="/backend/web/js/constructor.js?<?= time(); ?>"></script>

<?php
echo $this->render('/site/partials/varieblesTranslate', []);
?>

