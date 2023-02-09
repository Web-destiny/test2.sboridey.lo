<?php

/**
 * @var \yii\web\View $this
 * @var $elementOrder array
 * @var $groupData array
 * @var $groupNamePrefix string
 */

use common\constructor\BaseElement; ?>

<div class="question-wrap question-free question-new" data-id="<?= $groupNamePrefix; ?>">
    <div class="box-shadow question-content">
        <div class="control-panel">
            <div class="attach-file">
                <div class="attach-file-icon"></div>
                <div class="attach-files-wrap">
                    <div class="files-list">
                        <div class="file-item file-video">
                            <input type="file" accept="video/mp4,video/x-m4v,video/*" name="uploadvideo_<?= $groupNamePrefix; ?>" id="uploadvideo_<?= $groupNamePrefix; ?>">
                            <label for="uploadvideo_<?= $groupNamePrefix; ?>"></label>
                        </div>
                        <div class="file-item file-img">
                            <input type="file" accept="image/png, image/gif, image/jpeg" name="uploadimage_<?= $groupNamePrefix; ?>" id="uploadimage_<?= $groupNamePrefix; ?>" >
                            <label for="uploadimage_<?= $groupNamePrefix; ?>"></label>
                        </div>
                        <div class="file-item file-audio">
                            <input type="file" accept=".mp3,audio/*" name="uploadaudio_<?= $groupNamePrefix; ?>" id="uploadaudio_<?= $groupNamePrefix; ?>">
                            <label for="uploadaudio_<?= $groupNamePrefix; ?>"></label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="show-settings"></div>
            <div class="remove-question"></div>
        </div>
        <input type="hidden" name="type_<?= $groupNamePrefix; ?>" value="free-answer">
        <div class="question-name">
            <textarea name="question_<?= $groupNamePrefix; ?>" rows="1" placeholder="Введите ваш вопрос" data-required="required" style="overflow: hidden; height: 29px;"><?= $question ?></textarea>
        </div>

        <?= $this->renderFile(BaseElement::VIEW_PATH . 'partials/_file.php', ['elementOrder' => $groupNamePrefix, 'hasFile' => $hasFile, 'file' => $file, 'fileType' => $fileType, 'fileOriginalType' => $fileOriginalType]); ?>

        <?php for ($i = 1; $i <= ($amount ?: 1); $i++): ?>
            <div class="free-answers">
                <div class="answer-wrap">
                    <textarea rows="1" placeholder="Введите ваш комментарий" style="overflow: hidden; height: 31px;"></textarea>
                </div>
            </div>
        <?php endfor; ?>
    </div>
    <div class="box-shadow question-settings">
        <div class="select-row">
            <div class="label">
                <?php echo  \Yii::t('app', 'Несколько вариантов ответов'); ?>
            </div>
            <div class="select-input customselect-wrapper">
                <div class="select">
                    <select name="amount_<?= $groupNamePrefix; ?>" class="customselect amount-select select-hidden">
                        <option value="0" <?= 0 == $amount ? 'selected' : ''; ?>><?php echo  \Yii::t('app', 'Автообновление'); ?></option>
                        <?php for ($i = 1; $i <= 10; $i++): ?>
                            <option <?= $i == $amount ? 'selected' : ''; ?> value="<?= $i ?>"><?= $i ?></option>
                        <?php endfor; ?>
                    </select>

                    <div class="select-styled"><?= $amount ?: 'Автообновление'; ?></div>

                    <ul class="select-options" style="display: none;">
                        <li rel="0" class="<?= 0 == $amount ? 'active' : ''; ?>"><?php echo  \Yii::t('app', 'Автообновление'); ?></li>
                        <?php for ($i = 1; $i <= 10; $i++): ?>
                            <li rel="<?= $i ?>" class="<?= $i == $amount ? 'active' : ''; ?>"><?= $i ?></li>
                        <?php endfor; ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="switch-row">
            <div class="label">
                <?php echo  \Yii::t('app', 'ВХОД'); ?><?php echo  \Yii::t('app', 'Обязательность ответа'); ?>
            </div>
            <label class="switch">
                <input type="checkbox" <?= $required ? 'checked' : '' ?> name="required_<?= $groupNamePrefix; ?>">
                <span class="slider round"></span>
            </label>
        </div>
    </div>
</div>