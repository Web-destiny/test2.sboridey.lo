<?php

/**
 * @var \yii\web\View $this
 * @var $elementOrder array
 * @var $groupData array
 * @var $groupNamePrefix string
 */

use common\constructor\BaseElement; ?>

<div class="question-wrap question-scale question-new" data-id="<?= $groupNamePrefix; ?>" draggable="false">
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
        <input type="hidden" name="type_<?= $groupNamePrefix; ?>" value="scale">

        <?php if($this->context->uniqueKey): ?>
<!--            <input type="hidden" name="id_--><?//= $groupNamePrefix; ?><!--" value="--><?php //echo  $this->context->uniqueKey ?><!--">-->
        <?php endif; ?>

        <div class="question-name">
            <textarea name="question_<?= $groupNamePrefix; ?>" rows="1" placeholder="Введите ваш вопрос" data-required="required" style="overflow: hidden; min-height: 29px;"><?= $question ?></textarea>
        </div>

        <?= $this->renderFile(BaseElement::VIEW_PATH . 'partials/_file.php', ['elementOrder' => $groupNamePrefix, 'hasFile' => $hasFile, 'file' => $file, 'fileType' => $fileType, 'fileOriginalType' => $fileOriginalType]); ?>

        <?php if($scaleType == 'diapason'):?>
        <div class="diapason-answer">
            <div class="diapason">
                <div class="label">
                    <div class="value">0</div>
                </div>
                <div class="input-box">
                    <input class="input-range" type="range" min="1" max="<?=$scaleAmount?>" step="1" value="0"/>
                    <div class="bar"></div>
                    <div class="bar-filled"></div>
                </div>
            </div>
        </div>
        <?php else: ?>
        <div class="scale-wrap scale-<?= $scaleType; ?> scale-<?=$scaleAmount?>">
            <?php for ($i = $scaleAmount; $i > 0; $i--): ?>
                <input type="radio" id="scale_<?= $groupNamePrefix; ?>_<?= $i; ?>" name="scale_<?= $groupNamePrefix; ?>" value="<?= $i; ?>">
                <label for="scale_<?= $groupNamePrefix; ?>" title="text"></label>
            <?php endfor; ?>
        </div>
        <?php endif;?>
    </div>
    <div class="box-shadow question-settings">
        <div class="scale-options">
            <div class="scale-row">
                <div class="options-item">
                    <div class="option-label">
                        <?php echo  \Yii::t('app', 'Шкала'); ?>
                    </div>
                    <div class="option-value">
                        <select name="scaleAmount_<?= $groupNamePrefix; ?>" class="customselect scale-amount">
                            <option <?= $scaleAmount == 2 ? 'selected' : '' ?> value="2">2</option>
                            <option <?= $scaleAmount == 3 ? 'selected' : '' ?> value="3">3</option>
                            <option <?= $scaleAmount == 4 ? 'selected' : '' ?> value="4">4</option>
                            <option <?= $scaleAmount == 5 ? 'selected' : '' ?> value="5">5</option>
                            <option <?= $scaleAmount == 6 ? 'selected' : '' ?> value="6">6</option>
                            <option <?= $scaleAmount == 7 ? 'selected' : '' ?> value="7">7</option>
                            <option <?= $scaleAmount == 8 ? 'selected' : '' ?> value="8">8</option>
                            <option <?= $scaleAmount == 9 ? 'selected' : '' ?> value="9">9</option>
                            <option <?= $scaleAmount == 10 ? 'selected' : '' ?> value="10">10</option>
                            <option <?= $scaleAmount == 2 ? 'selected' : '' ?> value="2"><?php echo  \Yii::t('app', 'да'); ?>/<?php echo  \Yii::t('app', 'нет'); ?></option>
                        </select>
                    </div>
                </div>
                <div class="options-item">
                    <div class="option-label">
                        <?php echo  \Yii::t('app', 'Фигура'); ?>
                    </div>
                    <div class="option-value">
                        <select name="scaleType_<?= $groupNamePrefix; ?>" class="customselect scale-type">
                            <option <?= $scaleType == 'star' ? 'selected' : ''; ?> value="star"><?php echo  \Yii::t('app', 'Звездочки'); ?></option>
                            <option <?= $scaleType == 'face' ? 'selected' : ''; ?> value="face"><?php echo  \Yii::t('app', 'Смайлики'); ?></option>
                            <option <?= $scaleType == 'heart' ? 'selected' : ''; ?> value="heart"><?php echo  \Yii::t('app', 'Сердечки'); ?></option>
                            <option <?= $scaleType == 'hand' ? 'selected' : ''; ?> value="hand"><?php echo  \Yii::t('app', 'Палец'); ?></option>
                            <option <?= $scaleType == 'diapason' ? 'selected' : ''; ?> value="diapason"><?php echo  \Yii::t('app', 'Диапазон'); ?></option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="switch-row">
                <div class="label">
                    <?php echo  \Yii::t('app', 'Метки рейтинга'); ?>
                </div>
                <label class="switch">
                    <input type="checkbox" class="add-rateLabels" <?= $rateLabels ? 'checked' : '' ?> name="rateLabels_<?= $groupNamePrefix; ?>" id="rateLabels_<?= $groupNamePrefix; ?>">
                    <span class="slider round"></span>
                </label>
            </div>
            <?php if($rateLabels):?>
            <div class="labels-option">
                <?php for($i = 1; $i<=$scaleAmount; $i++): ?>
                    <div class="label-item">
                        <div class="number"><?= $i; ?></div>
                        <div class="value">
                            <input type="text" name="inputpoint_<?= $groupNamePrefix; ?>_<?= $i; ?>" value="<?= $inputPoint[$i-1]['value'] ?? '' ?>">
                        </div>
                    </div>
                <?php endfor; ?>
            </div>
            <?php endif;?>
        </div>
        <div class="switch-row">
            <div class="label">
                <?php echo  \Yii::t('app', 'Обязательность ответа'); ?>
            </div>
            <label class="switch">
                <input type="checkbox" <?= $required ? 'checked' : '' ?> name="required_<?= $groupNamePrefix; ?>">
                <span class="slider round"></span>
            </label>
        </div>
    </div>
</div>