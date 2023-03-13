<?php

use yii\helpers\Html;

/**
 * @var \yii\web\View $this
 * @var \yii\data\ActiveDataProvider $dataProvider
 */
?>
<link rel="stylesheet" href="/backend/web/css/survey.css">
<div class="inner">
    <?= Html::beginForm('', 'post', ['class' => 'links-form']); ?>
        <div class="form-wrap">
            <div class="form-group">
                <label for="links_amount">Количество ссылок(макс.: <?php echo \common\models\RandUrl::MAX_URL_COUNT; ?>)</label>
                <div class="input-wrap input-number">
                    <button class="decrement">-</button>
                    <input type="number" id="links_amount" name="survey_links_count" placeholder="0" max="<?= \common\models\RandUrl::MAX_URL_COUNT; ?>" />
                    <button class="increment">+</button>
                </div>
            </div>
            <div class="btn-wrap">
                <button type="submit" style="margin-bottom: 15px" class="btn-default btn-submit">Создать</button>
            </div>
        </div>
    <?= Html::endForm(); ?>
    <?= Html::beginForm(); ?>
        <input type="hidden" name="export-survey-links" value="1" />

        <a onclick="$(this).closest('form').submit()" href="#" class="exel-link <?= $dataProvider->getCount() ? 'active' : 'inactive' ?>">
            <div class="link-text">Выгрузить созданые ссылки в Excel</div>
            <div class="icon-exel"></div>
        </a>
    <?= Html::endForm(); ?>
    <div class="links-table-wrap">
        <?= $this->render('_survey-view', ['dataProvider' => $dataProvider]); ?>
    </div>
</div>
<div class="message-overlay">
    <div class="message-popup">
        <div class="closeMessage">+</div>
        <div class="message-text">
            <p>Ссылка сгенерирована. Теперь вы можете скачать ссылки в файле Excel.</p>
        </div>
    </div>
</div>
<div class="kvot-wrap">
    <div class="kvot-box">
        <div class="kvot-title">Квотирование:</div>
        <div class="input-check kvot-switcher">
            <label class="switch">
                <input type="checkbox" name="" class="show-hidden" data-hidden=".link-hidden">
                <span class="slider round"></span>
            </label>
        </div>
    </div>
</div>
<script src="/js/custom_select.js"></script>
<script>
    const [linksAmount, linksBtn] = [$('#links_amount'), $('.links-form .btn-submit')];

    const onLinksSuccess = html => {
        linksBtn.removeClass('btn-loading').removeAttr('disabled');

        if (html) {
            $('.message-overlay').css('display', 'flex');
            $('.exel-link').removeClass('inactive');
            $('.links-table-wrap').html(html);
        } else {
            $('.message-overlay').hide();
            $('.exel-link').addClass('inactive');
        }
    };

    $('.links-form').on('submit', function (e) {
        e.preventDefault();
        let inputLinks = $(this).find('.input-number input');
        if (inputLinks.val() > 0 || linksAmount.val() > linksAmount.attr('max')) {
            const survey_links_count = linksAmount.val();

            linksBtn.addClass('btn-loading').attr('disabled', true);

            linksAmount.val(0);

            //start generate links

            const promiseLinkGenerator = new Promise((resolve, reject) => {
                $.post(location.href, {'_csrf-backend': $('[name=_csrf-backend]').val(), survey_links_count}, response => {
                    if (response === 'validation_fail') {
                        reject(response);
                    } else {
                        setTimeout(() => {
                            resolve(response);
                        }, 1000);
                    }
                });
            });

            promiseLinkGenerator.then(onLinksSuccess, e => {
                alert('Maximum limit reached.');
                onLinksSuccess();
            });
        } else {
            inputLinks.addClass('has-error');
        }

        return false;
    });
    $('.links-form').on('focus', '.input-number input', function (e) {
        $(this).removeClass('has-error');
    });
    $('.content-wrap').on('click', '.input-wrap .decrement', function (e) {
        e.preventDefault();
        let input = $(this).parents('.input-wrap').find('input');
        let value = parseInt(input.val());
        if (value > 0) {
            let newValue = value - 1;
            input.val(newValue);
        }
    });
    $('.content-wrap').on('click', '.input-wrap .increment', function (e) {
        e.preventDefault();
        let input = $(this).parents('.input-wrap').find('input');
        let value = parseInt(input.val());
        if (!value) {
            value = 0;
        }
        let newValue = value + 1;
        input.val(newValue);
    });
    $('.closeMessage').on('click', function (e) {
        $(this).parents('.message-overlay').fadeOut(300);
    });
    $(document).mouseup(function (e) {
        var popup = $('.message-popup');
        if (e.target != popup[0] && popup.has(e.target).length === 0) {
            $('.message-overlay').fadeOut();
        }
    });

    $('.kvot-wrap').on('change', '.kvot-box .kvot-switcher input[type="checkbox"]', function () {
        if($(this).is(':checked')){
            createKvotBlock()
        }else{
            removeKvotBlock()
        }
    });

    $('.kvot-wrap').on('change', '.kvot-hide-content .kvot-set-condition .kvot-conditions-switcher input[type="checkbox"]', function () {
            if($(this).is(':checked')){
                createKvotConditions()
            }else{
                removeKvotConditions()
            }
    })

    function createKvotBlock() {
        let kvotBlock =
            `<div class="kvot-hide-content">
                <div class="input-number-box">
                    <div>Завершить опрос при получении</div>
                    <div class="input-wrap input-number">
                        <button class="decrement">-</button>
                        <input type="number" id="links_amount" name="survey_links_count" placeholder="0" max="" />
                        <button class="increment">+</button>
                    </div>
                    <div>ответов</div>
                </div>
                <div class="kvot-set-condition">
                    <div class="input-check kvot-conditions-switcher">
                        <label class="switch">
                            <input type="checkbox" name="" class="show-hidden" data-hidden=".link-hidden">
                            <span class="slider round"></span>
                        </label>
                    </div>
                    <div class="kvot-set-title">Задать условия квотирования</div>
                </div>
            </div>`;
        $('.kvot-wrap').append(kvotBlock)
    }
    function removeKvotBlock() {
        $('.kvot-hide-content').remove()
    }

    function createKvotConditions() {
        let kvotConditionsBlock =
            `<div class="kvot-set-separately-box">
                    <div class="kvot-set-separately">
                        <div class="input-check">
                        <label class="switch">
                            <input type="checkbox" name="" class="show-hidden" data-hidden=".link-hidden">
                            <span class="slider round"></span>
                        </label>
                        </div>
                        <div class="kvot-set-title">Отдельная квота для каждого вопроса</div>
                    </div>

                    <div class="customselect-wrapper kvot-questions-select"">
                        <div class="select">
                            <select class="customselect single-hide-answer-select select-hidden">
                                <option value="" data-id="" name="">
                                </option>
                            </select>
                            <div class="select-styled">
                              Выберите вопрос
                            </div>
                            <ul class="select-options" style="display: none;">
                                <li rel="" data-id="" name="" class="">
                                </li>
                            </ul>
                            </div>
                    </div>
                </div>
`;
        $('.kvot-wrap .kvot-hide-content').append(kvotConditionsBlock)
        customSelectActive()
    }
    function removeKvotConditions() {
        $('.kvot-set-separately-box').remove()
    }


</script>
