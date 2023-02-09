<?php

/**
 * @var \yii\web\View $this
 * @var $elementOrder array
 * @var $groupData array
 * @var $groupNamePrefix string
 */

use common\constructor\BaseElement; ?>


<div class="question-wrap question-scale nps-question-scale __focus question-new" data-id="<?= $groupNamePrefix; ?>">

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
        <input type="hidden" name="type_<?= $groupNamePrefix; ?>" value="nps">

        <?php if($this->context->uniqueKey): ?>
            <!--            <input type="hidden" name="id_--><?//= <?= $groupNamePrefix; ?> <!--" value="--><?php //echo  $this->context->uniqueKey ?><!--">-->
        <?php endif; ?>

        <div class="question-name">
            <textarea name="question_<?= $groupNamePrefix; ?>" rows="1" placeholder="Введите ваш вопрос" data-required="required" style="overflow: hidden; min-height: 29px;"><?= $question ?></textarea>
        </div>

        <?= $this->renderFile(BaseElement::VIEW_PATH . 'partials/_file.php', ['elementOrder' => $groupNamePrefix, 'hasFile' => $hasFile, 'file' => $file, 'fileType' => $fileType, 'fileOriginalType' => $fileOriginalType]); ?>

        <?php if($npsType == 'diapason'):?>
            <div class="diapason-answer">
                <div class="diapason">
                    <div class="label">
                        <div class="value">0</div>
                    </div>
                    <div class="input-box">
                        <input class="input-range" type="range" min="1" max="<?=$npsAmount?>" step="1" value="0"/>
                        <div class="bar"></div>
                        <div class="bar-filled"></div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="scale-wrap scale-<?= $npsType; ?> scale-<?=$npsAmount?>">
                <?php for ($i = $npsAmount; $i > 0; $i--): ?>
                    <input type="radio" id="nps_<?= $groupNamePrefix; ?>_<?= $i; ?>" name="nps_<?= $groupNamePrefix; ?>" value="<?= $i; ?>">
                    <label for="nps_<?= $groupNamePrefix . '_' . $i; ?>" title="text"></label>
                <?php endfor; ?>
            </div>
        <?php endif;?>

        <div class="free-answers">
<!--                <div class="answer-wrap">-->
<!--                    <textarea name="nps1" rows="1" placeholder="Введите ваш комментарий" style="overflow: hidden; height: 31px;"></textarea>-->
<!--                </div>-->
        </div>


    </div>
    <div class="box-shadow question-settings">
        <div class="scale-options">
            <div class="scale-row">
                <div class="options-item">
                    <div class="option-label">
                        <?php echo  \Yii::t('app', 'Шкала'); ?>
                    </div>
                    <div class="option-value">
                        <select name="npsAmount_<?= $groupNamePrefix; ?>" class="customselect scale-amount">
                            <?php for($i = 2; $i<11; $i++): ?>
                                <option <?php if($npsAmount == $i) echo 'selected' ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php endfor;?>
                            <option <?= $npsAmount == 2 ? 'selected' : '' ?> value="2"><?php echo  \Yii::t('app', 'да'); ?>/<?php echo  \Yii::t('app', 'нет'); ?></option>
                        </select>
                    </div>
                </div>
                <div class="options-item">
                    <div class="option-label">
                        <?php echo  \Yii::t('app', 'Фигура'); ?>
                    </div>
                    <div class="option-value">
                        <select name="npsType_<?= $groupNamePrefix; ?>" class="customselect scale-type">
                            <option <?= $npsType == 'star' ? 'selected' : ''; ?> value="star"><?php echo  \Yii::t('app', 'Звездочки'); ?></option>
                            <option <?= $npsType == 'face' ? 'selected' : ''; ?> value="face"><?php echo  \Yii::t('app', 'Смайлики'); ?></option>
                            <option <?= $npsType == 'heart' ? 'selected' : ''; ?> value="heart"><?php echo  \Yii::t('app', 'Сердечки'); ?></option>
                            <option <?= $npsType == 'hand' ? 'selected' : ''; ?> value="hand"><?php echo  \Yii::t('app', 'Палец'); ?></option>
                            <option <?= $npsType == 'diapason' ? 'selected' : ''; ?> value="diapason"><?php echo  \Yii::t('app', 'Диапазон'); ?></option>
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
                    <?php for($i = 0; $i<=$npsAmount; $i++): ?>
                        <div class="label-item">
                            <div class="number"><?= $i; ?></div>
                            <div class="value">
                                <input type="text" name="inputpoint_<?= $groupNamePrefix; ?>_<?= $i; ?>" value="<?= $inputPoint[$i]['value'] ?? '' ?>">
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

        <div class="switch-row nps-option-row">
            <div class="label">
                <?php echo  \Yii::t('app', 'Добавить опцию'); ?>
            </div>
            <label class="switch">
                <input type="checkbox"  <?php if($addNpsOption) echo 'checked';  ?>  class="addNpsOption" name="addNpsOption_<?= $groupNamePrefix; ?>" id="npsOptionLabels_<?= $groupNamePrefix; ?>">
                <span class="slider round"></span>
            </label>
        </div>

        <?php if(!empty($npsAction)): ?>
            <div class="nps-options-box">
                <?php foreach ($npsAction as $npsActionItems): ?>
                    <?php $m = 0; ?>
                    <?php foreach ($npsActionItems as $key => $npsActionItem): ?>
                        <?php if(!empty($npsActionItem) && $key == "value" ): ?>
                            <?php $numItem = 1; ?>
                            <?php foreach($npsActionItem as $k => $item): ?>

                                <div class="nps-option">
                                    <div class="scale-property-row">
                                        <span class="scale-property-name"><?php echo  \Yii::t('app', 'Показатели шкалы'); ?></span>
                                        <div class="nps-diapason-start nps-diapason-box">
                                            <span><?php echo  \Yii::t('app', 'От'); ?></span>
                                            <div class="option-value customselect-wrapper">
                                                <div class="select"><select name="npsDiapasoneStart_<?= $groupNamePrefix . '_' . $numItem ?>" class="customselect select-hidden">
                                                        <?php for($i = 0; $i < 11; $i++):  ?>
                                                            <option <?php if($i == $item['npsDiapasoneStart']) echo 'selected'; ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                        <?php endfor;; ?>
                                                    </select><div class="select-styled"><?php echo $item['npsDiapasoneStart']; ?></div>
                                                    <ul class="select-options" style="display: none;">
                                                        <?php for($i = 0; $i < 11; $i++):  ?>
                                                            <li rel="<?php echo $i; ?>" class="<?php if($i == $item['npsDiapasoneStart']) echo 'active'; ?>"><?php echo $i; ?></li>
                                                        <?php endfor;; ?>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="nps-diapason-end nps-diapason-box">
                                            <span><?php echo  \Yii::t('app', 'До'); ?></span>
                                            <div class="option-value customselect-wrapper">
                                                <div class="select"><select name="npsDiapasoneEnd_<?= $groupNamePrefix . '_' . $numItem ?>" class="customselect select-hidden">
                                                        <?php for($i = 0; $i < 11; $i++):  ?>
                                                            <option <?php if($i == $item['npsDiapasoneEnd']) echo 'selected'; ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                        <?php endfor;; ?>
                                                    </select>
                                                    <div class="select-styled"><?php echo $item['npsDiapasoneEnd']; ?></div>
                                                    <ul class="select-options" style="display: none;">
                                                        <?php for($i = 0; $i < 11; $i++):  ?>
                                                            <li rel="<?php echo $i; ?>" class="<?php if($i == $item['npsDiapasoneEnd']) echo 'active'; ?>"><?php echo $i; ?></li>
                                                        <?php endfor;; ?>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="scale-property-row">
                                        <span class="scale-property-name"><?php echo  \Yii::t('app', 'ВХОД'); ?></span>
                                        <div class="nps-action-box">
                                            <div class="option-value customselect-wrapper">
                                                <div class="select">
                                                    <select name="npsAction_<?= $groupNamePrefix . '_' . $numItem ?>" class="customselect select-nps-action select-hidden">
                                                        <option value=""><?php echo  \Yii::t('app', 'Выбрать действие'); ?></option>
                                                        <option value="add_free_answer" <?php if('add_free_answer' == $item['npsTypeValue']) echo 'selected'; ?>><?php echo  \Yii::t('app', 'Добавить открытый вопрос'); ?></option>
                                                        <option value="finish_survey" <?php if('finish_survey' == $item['npsTypeValue']) echo 'selected'; ?>><?php echo  \Yii::t('app', 'Закончить опрос'); ?></option>
                                                    </select>

                                                    <div class="select-styled">
                                                        <?php
                                                        if($item['npsTypeValue'] == 'add_free_answer') {
                                                            echo 'Добавить открытый вопрос';
                                                        } elseif($item['npsTypeValue'] == 'finish_survey') {
                                                            echo 'Закончить опрос';
                                                        } else {
                                                            echo 'Выбрать действие';
                                                        }
                                                        ?>
                                                    </div>
                                                    <ul class="select-options" style="display: none;">
                                                        <li rel="" class=""><?php echo  \Yii::t('app', 'Выбрать действие'); ?></li>
                                                        <li rel="add_free_answer" class="<?php if('finish_survey' == $item['npsTypeValue']) echo 'active'; ?>"><?php echo  \Yii::t('app', 'Добавить открытый вопрос'); ?></li>
                                                        <li rel="finish_survey" class="<?php if('finish_survey' == $item['npsTypeValue']) echo 'active'; ?>"><?php echo  \Yii::t('app', 'Закончить опрос'); ?></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="remove-nps-option"></div>
                                    <p class="add-new-option"><?php echo  \Yii::t('app', 'Добавить опцию'); ?></p>
                                </div>


                                <?php $numItem++; ?>
                            <?php endforeach;  ?>

                        <?php endif; ?>
                        <?php $m++; ?>
                    <?php endforeach; ?>

                <?php endforeach; ?>
            </div>

        <?php else:  ?>
            <div class="switch-row nps-option-row">
                <div class="label">
                    <?php echo  \Yii::t('app', 'Добавить опцию'); ?>
                </div>
                <label class="switch">
                    <input type="checkbox"  <?php //if($addNpsOption) echo 'checked';  ?>  class="addNpsOption" name="addNpsOption_<?= $groupNamePrefix; ?>" id="npsOptionLabels_3">
                    <span class="slider round"></span>
                </label>
            </div>
        <?php endif;  ?>



    </div>

</div>
