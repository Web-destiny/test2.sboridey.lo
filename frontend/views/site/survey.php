<!DOCTYPE html>
<html lang="en" id="survey-page">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $survey->name ?></title>

    <link rel="icon" type="image/svg+xml" href="/frontend/web/img/favicon/favicon.svg">
    <link rel="apple-touch-icon" sizes="180x180" href="/frontend/web/img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/frontend/web/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/frontend/web/img/favicon/favicon-16x16.png">
    <link rel="manifest" href="/frontend/web/img/favicon/site.webmanifest">

    <link rel="stylesheet" href="/font/Gilroy/stylesheet.css">
    <link rel="stylesheet" href="/css/jquery-ui.css">
    <link rel="stylesheet" href="/css/custom-select.css">
    <link rel="stylesheet" href="/css/bootstrap-datepicker3.standalone.css">
    <link rel="stylesheet" href="/css/intlTelInput.css">
    <link rel="stylesheet" href="/css/style.css?<?= time(); ?>">

    <script src="/js/jquery-3.5.1.min.js"></script>
</head>

<body>
    <div class="page-wrap">
        <?php
        $background = ($survey->background) ? '/frontend/web/img/survey/' . $survey->background : '';
        ?>

        <div class="content-wrap survey-page">
            <div class="pool-wrap">
                <div class="pool-bg" style="background-image: url('<?php echo $background; ?>');"></div>
                <div class="progress-bar">
                    <div class="progress-wrap">
                        <div class="proggres">
                        </div>
                    </div>
                </div>
                <input type="hidden" id="extra1", value="<?php echo $extra1; ?>" >
                <input type="hidden" id="param1", value="<?php echo $param1; ?>" >

                <div class="question-list __overflow_auto">


                    <h1 class="survey-name">
                        <?php echo $survey->name  ?>
                    </h1>
                    <p class="survey-descr">
                        <?php echo $survey->description;  ?>
                    <form action="#" class="form-valid" method="post">
                        <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>" value="<?= Yii::$app->request->csrfToken; ?>" />
                        <input type="hidden" name="survey_name" value="<?php echo $survey->name  ?>">
                        <input type="hidden" name="survey_id" value="<?php echo $survey->id  ?>">


                        <div class="constr-wrap">
                            <?php if($survey->extra == 'cement' && $survey->id != 171):  ?>
                            <div class="filter-wrap cement-block mb-10 pd-20">
                                <div class="filter-item-cement mb-20">
                                    <div data-id="1" class="cement-select-label mb-10" style="color: rgb(255, 0, 0);">Выберите пожалуйста, свое местоположение</div>
                                    <select name="param1" class="customselect city-select">
                                        <option selected disabled>Город</option>
                                        <?php foreach ($locations as $location): ?>
                                            <option value="<?= $location->id; ?>"><?= $location->name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="filter-item-cement mb-20">
                                    <div data-id="2" class="cement-select-label mb-10" style="color: rgb(255, 0, 0);">Укажите Ваше подразделение</div>
                                    <select name="param2" class="customselect department-select">
                                        <option selected disabled>Подразделение</option>
                                    </select>
                                </div>

                                <div class="filter-item-cement">
                                    <div data-id="3" class="cement-select-label mb-10" style="color: rgb(255, 0, 0);">Выберите имя Вашего руководителя</div>
                                    <select name="param3" class="customselect supervisor-select">
                                        <option selected disabled>ФИО руководителя</option>
                                    </select>
                                </div>
                            </div>
                         <?php endif; ?>

                            <div class="question-element" style="<?php echo ($survey->extra == 'cement') ? 'display: none;' : ''; ?>">

                            <?php foreach ($data as $element) : ?>
                                <?php echo \yii\helpers\Html::hiddenInput('types[' . ($element['element_order'] ?? 0) . ']', $element['type'] ?? null); ?>

                                <?php if ($element['type'] == $constructor::SINGLE) :  ?>
                                    <?php echo  $this->render('/site/partials/single', ['element' => $element, 'survey' => $survey]) ?>
                                <?php elseif ($element['type'] == $constructor::FREE_ANSWER) : ?>
                                    <?php echo  $this->render('/site/partials/free-answer', ['element' => $element, 'survey' => $survey]) ?>
                                <?php elseif ($element['type'] == $constructor::SCALE) : ?>
                                    <?php echo  $this->render('/site/partials/scale', ['element' => $element, 'survey' => $survey]) ?>
                                <?php elseif ($element['type'] == $constructor::NPS) : ?>
                                    <?php echo  $this->render('/site/partials/nps', ['element' => $element, 'survey' => $survey]) ?>
                                <?php elseif ($element['type'] == $constructor::DROPDOWN) : ?>
                                    <?php echo  $this->render('/site/partials/dropdown', ['element' => $element, 'survey' => $survey]) ?>
                                <?php elseif ($element['type'] == $constructor::RANGING) : ?>
                                    <?php echo  $this->render('/site/partials/ranging', ['element' => $element, 'survey' => $survey]) ?>
                                <?php elseif ($element['type'] == $constructor::NAME) : ?>
                                    <?php echo  $this->render('/site/partials/name', ['element' => $element, 'survey' => $survey]) ?>
                                <?php elseif ($element['type'] == $constructor::DATE) : ?>
                                    <?php echo  $this->render('/site/partials/date', ['element' => $element, 'survey' => $survey]) ?>
                                <?php elseif ($element['type'] == $constructor::EMAIL) : ?>
                                    <?php echo  $this->render('/site/partials/email', ['element' => $element, 'survey' => $survey]) ?>
                                <?php endif; ?>

                            <?php endforeach; ?>
                        </div>


                        <div class="btn-wrap" style="<?php echo ($survey->extra == 'cement' ) ? 'visibility: hidden;' : '' ;  ?>">
                            <button class="valid-form-send btn-default">Отправить</button>
                        </div>
                    </form>
                </div>
                <div class="survey-footer">
                    <div class="logo">
                        <img src="/img/idea-logo.png" alt="sboridey">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="load-wrapper">
        <div class="loader"></div>
    </div>
    <script src="/js/jquery-ui.js"></script>
    <script src="/js/jquery.ui.touch-punch.min.js"></script>
    <script src="/js/bootstrap-datepicker.min.js"></script>
    <script src="/js/bootstrap-datepicker.ru.min.js"></script>
    <script src="/js/custom_select.js"></script>
    <script src="/js/wavesurfer.min.js"></script>
    <script src="/js/video-radio-star.js"></script>
    <script src="/js/intlTelInput.js"></script>
    <script src="/js/jquery.mask.min.js"></script>
    <script src="/js/script.js?56786687"></script>
    <script src="/js/survey.js?345234234"></script>
    <script src="/js/nps.js?<?= time(); ?>"></script>
    <?php if($previewButtonName):  ?>
        <script src="/backend/web/js/cement.js?<?= time(); ?>"></script>
   <?php endif; ?>
</body>

</html>