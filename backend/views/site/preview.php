<?php

use  yii\helpers\Url;
?>

<div class="page-wrap">
    <div class="top-panel">
        <div class="logo">
            <img src="/backend/web/img/logo-white.svg" alt="">
        </div>
        <div class="notification-wrap">
            <?= \backend\widgets\languages\LanguagesWidget::widget() ?>
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
                <a href="<?= Url::to(['site/constructor', 'id' => $id]) ?>">
                    <?php echo $survey->name;  ?>
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
            </div>
        </div>
        <?php
        $banner = ($survey->banner) ? '/frontend/web/img/survey/' . $survey->banner : '';
        ?>
        <div class="preview-bg" style="background-image: url('<?php echo $banner; ?>');"></div>
        <div class="pool-wrap">
            <div class="question-list">
                <!--  ------------------start elements------------------------------------------------------------   -->
                <?php echo $constructor; ?>
                <!--  ------------------end elements--------------------------------------------------------------   -->
            </div>
        </div>


        <div class="preview-footer">
            <div class="proggres">
            </div>


            <div class="footer-row">
                <div class="link-back-wrap">
                    <a href="<?= Url::to(['site/constructor', 'id' => $id]) ?>" class="link-back"><?php echo  \Yii::t('app', 'Назад'); ?></a>
                </div>
                <div class="btn-save-wrap">
                    <a href="<?= Url::to(['site/constructor', 'id' => $id, 'from' => 'preview']) ?>" class="btn-save"><?php echo  \Yii::t('app', 'Сохранить'); ?></a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="load-wrapper">
    <div class="loader"></div>
</div>


<?php
echo $this->render('/site//partials/varieblesTranslate', []);
?>

<script src="/backend/web/js/jquery-ui.js"></script>
<script src="/backend/web/js/jquery.ui.touch-punch.min.js"></script>
<script src="/backend/web/js/bootstrap-datepicker.min.js"></script>
<script src="/backend/web/js/bootstrap-datepicker.ru.min.js"></script>
<script src="/backend/web/js/custom_select.js?5234234"></script>
<script src="/backend/web/js/wavesurfer.min.js"></script>
<script src="/backend/web/js/video-radio-star.js"></script>
<script src="/backend/web/js/intlTelInput.js"></script>
<script src="/backend/web/js/jquery.mask.min.js"></script>
<script src="/backend/web/js/script.js"></script>
<script src="/backend/web/js/preview.js?<?= time(); ?>"></script>