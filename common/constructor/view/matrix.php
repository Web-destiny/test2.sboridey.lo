<?php

/**
 * @var \yii\web\View $this
 * @var $elementOrder array
 * @var $groupData array
 * @var $groupNamePrefix string
 */

use common\constructor\BaseElement; ?>

<div class="question-wrap question-matrix question-new" data-id="<?= $groupNamePrefix; ?>">
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
                            <input type="file" accept="image/png, image/gif, image/jpeg" name="uploadimage_<?= $groupNamePrefix; ?>" id="uploadimage_<?= $groupNamePrefix; ?>">
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
        <input type="hidden" name="type_<?= $groupNamePrefix; ?>" value="matrix">
        <div class="question-name">
            <textarea name="question_<?= $groupNamePrefix; ?>" rows="1" placeholder="Введите ваш вопрос" data-required="required" style="overflow: hidden; height: 29px;"><?= $question; ?></textarea>
        </div>

        <?= $this->renderFile(BaseElement::VIEW_PATH . 'partials/_file.php', ['elementOrder' => $groupNamePrefix, 'hasFile' => $hasFile, 'file' => $file, 'fileType' => $fileType, 'fileOriginalType' => $fileOriginalType]); ?>

        <div class="matrix-table">
            <table>
                <tbody>
                <tr>
                    <td>dsfsd</td>
                </tr>
                <tr>
                    <td>sdfsdfsdf</td>
                </tr>
                </tbody>
            </table>
        </div>

        <?php if ($addComment): ?>
            <div class="option-comment">
                <textarea rows="1" placeholder="Введите ваш комментарий" style="overflow: hidden; height: 22px;"></textarea>
            </div>
        <?php endif; ?>

        <div class="matrix-options">
            <div class="matrix-row-list">
                <div class="matrix-row">
                    <div class="value">
                        <input type="text" name="inputRow_1_1" placeholder="Введите текст строки">
                    </div>
                </div>
                <div class="matrix-row">
                    <div class="value">
                        <input type="text" name="inputRow_1_1" placeholder="Введите текст строки">
                    </div>
                </div>
                <div class="matrix-row">
                    <div class="value">
                        <input type="text" name="inputRow_1_2" placeholder="Введите текст строки">
                    </div>
                </div>
            </div>
            <div class="matrix-col-list">
                <div class="matrix-col">
                    <div class="value">
                        <input type="text" name="inputCol_1_1" placeholder="Введите текст столбца">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="box-shadow question-settings">
        <div class="switch-row">
            <div class="label">
                <?php echo  \Yii::t('app', 'Разрешить несколько ответов на строку'); ?>
            </div>
            <label class="switch">
                <input type="checkbox" <?= $multiple ? 'checked' : '' ?> name="multiple_1" class="add-multipleChoice">
                <span class="slider round"></span>
            </label>
        </div>
        <div class="switch-row">
            <div class="label">
                <?php echo  \Yii::t('app', 'Добавить поле комментария'); ?>
            </div>
            <label class="switch">
                <input type="checkbox" <?= $addComment ? 'checked' : '' ?> name="addComment_1" class="add-comment">
                <span class="slider round"></span>
            </label>
        </div>
        <div class="switch-row">
            <div class="label">
                <?php echo  \Yii::t('app', 'Обязательность ответа'); ?>
            </div>
            <label class="switch">
                <input type="checkbox" <?= $required ? 'checked' : '' ?> name="required_1">
                <span class="slider round"></span>
            </label>
        </div>
    </div>
</div>