<?php

/**
 * @var string $html
 * @var array $data
 */

?>

<div class="chapter-wrapper" data-index="<?= $numberOfGroup; ?>">
    <div class="chapter-head">
        <div class="chapter-desciption-wrapper">
            <span class="chapter-number"><?= $data['number'] ?>.</span>
            <textarea
                    name="chapter-name-<?= $data['number'] ?>"
                    class="chapter-name-textarea"
                    rows="1"
                    style="overflow: hidden; height: 29px;"><?= $data['title']; ?></textarea>
        </div>
        <div class="chapter-control-panel">
            <div class="remove-chapter"></div>
            <div class="show-chapter-setting show-settings"></div>
        </div>
    </div>
    <div class="chapter-settings">
        <div class="chapter-settings-row">
            <span class="chapter-settings-name"><?php echo  \Yii::t('app', 'После раздела'); ?> <span class="chapter-settings-number"><?= $data['number'] ?>:</span></span>
            <div class="option-value customselect-wrapper">
                <div class="select">
                    <select name="chapter-select-<?= $data['number'] ?>" class="customselect">
                        <option selected="" value="select-action"><?php echo  \Yii::t('app', 'Выберите действие'); ?></option>
                        <option value="go-to-nextChapter"><?php echo  \Yii::t('app', 'Перейти к следующему разделу'); ?></option>
                        <option value="go-to-chapter-<?= $data['number'] + 1 ?>"><?php echo  \Yii::t('app', 'Перейти к разделу'); ?> <?= $data['number'] + 1 ?>: "<?php echo  \Yii::t('app', 'Название раздела'); ?>"</option>
                        <option value="to-submit-survey"><?php echo  \Yii::t('app', 'Отправить анкету'); ?></option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="chapter-questions-list">
        <?= $html; ?>
    </div>
</div>