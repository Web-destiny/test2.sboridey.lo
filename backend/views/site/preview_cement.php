<?php

use  yii\helpers\Url;
?>

<div class="page-wrap">
    <div class="top-panel">
        <div class="logo">
            <img src="/backend/web/img/idea-logo-white.png" alt="">
        </div>
        <div class="notification-wrap">
            <a href="#">
                <div class="icon active">
                    <img src="/backend/web/img/notification-icon.png" alt="notification">
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
                        Вопросы
                    </a>
                </div>
                <div class="menu-item">
                    <a href="#">
                        Дизайн
                    </a>
                </div>
            </div>
        </div>

        <?php
        $banner = ($survey->banner) ? '/frontend/web/img/survey/' . $survey->banner : '';
        ?>
        <div class="preview-bg" style="background-image: url('<?php echo $banner; ?>');"></div>

        <div class="pool-wrap">
            <div class="constr-wrap">
                <div class="filter-wrap" style="margin-bottom: 10px;">
                    <div class="filter-item">
                        <select name="" class="customselect city-select">
                            <option selected disabled>Город</option>
                            <?php foreach ($locations as $location): ?>
                                <option value="<?= $location->id; ?>"><?= $location->name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="filter-item">
                        <select name="" class="customselect department-select">
                            <option selected disabled>подразделение</option>
                        </select>
                    </div>

                    <div class="filter-item">
                        <select name="" class="customselect supervisor-select">
                            <option selected disabled>руководитель</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="question-list" style="display: none;">
                <!--  ------------------start elements------------------------------------------------------------   -->

                <div class="question-element">
                    <?php foreach ($elements as $element) : ?>
                        <?php if (!isset($element['type'])) continue;  ?>
                        <?php echo $this->render('/site/partials/' . $element['type'], ['element' => $element, 'pageName' => $pageName]) ?>
                    <?php endforeach;  ?>
                </div>

                <!--  ------------------end elements--------------------------------------------------------------   -->
            </div>
        </div>


        <div class="preview-footer">
            <div class="proggres">
            </div>


            <div class="footer-row">
                <div class="link-back-wrap">
                    <a href="<?= Url::to(['site/constructor', 'id' => $id]) ?>" class="link-back">Назад</a>
                </div>
                <div class="btn-save-wrap">
                    <a href="<?= Url::to(['site/constructor', 'id' => $id, 'from' => 'preview']) ?>" class="btn-save">Сохранить</a>
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
<script src="/backend/web/js/cement.js?<?= time(); ?>"></script>