<?php

/**
 * @var \yii\web\View $this
 * @var $elementOrder array
 * @var $groupData array
 * @var $groupNamePrefix string
 */

use common\constructor\BaseElement; ?>

<div class="question-wrap question-single question-new" data-id="<?= $groupNamePrefix; ?>" draggable="false">
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
        <input type="hidden" name="type_<?= $groupNamePrefix; ?>" value="single">

<!--        --><?php //if($uniqueKey): ?>
<!--            <input type="hidden" name="id_--><?//= $groupNamePrefix ?><!--" value="--><?//= $uniqueKey ?><!--">-->
<!--        --><?php //endif; ?>


        <input type="hidden" name="id_1" value="kxpyog0yvi2h80oqigf">

        <div class="question-name">
            <textarea name="question_<?= $groupNamePrefix; ?>" rows="1" placeholder="Введите ваш вопрос" data-required="required" style="overflow: hidden; min-height: 29px;"><?= $question ?></textarea>
        </div>

        <?= $this->renderFile(BaseElement::VIEW_PATH . 'partials/_file.php', ['elementOrder' => $groupNamePrefix, 'hasFile' => $hasFile, 'file' => $file, 'fileType' => $fileType, 'fileOriginalType' => $fileOriginalType]); ?>

        <div class="radio-btns-wrapper ui-sortable">
            <?php foreach ($inputPoint as $key => $item): ?>
                <div class="radio-item">
                    <div class="remove-item"></div>
                    <textarea name="<?= $item['name'] ?>" rows="1" placeholder="Вариант ответа" style="overflow: hidden; min-height: 41px;"><?= $item['value'] ?></textarea>


                    <div>
                        <div class="option-item" style="width: 300px; position: absolute; left: -40px; top: 30px;">
                            <div class="value">
                            <input placeholder="Скрыть элемент No:"
                                      class="__textarea" type="text"
                                      name="<?= $inputPointRelated[$key]['nameRelated'] ?>"><?= $inputPointRelated[$key]['valueRelated'] ?>
                            </div>
                        </div>
                    </div>

                </div>

            <?php endforeach; ?>
        </div>
        <?php if ($addComment): ?>
            <div class="option-comment">
                <textarea rows="1" placeholder="Введите ваш комментарий" style="overflow: hidden; height: 22px;"></textarea>
            </div>
        <?php endif; ?>
        <div class="input-new-item-wrap">
            <input type="text" class="input-single-item" placeholder="Введите вариант ответа">
        </div>
    </div>
    <div class="box-shadow question-settings">
        <div class="switch-row">
            <div class="label">
                <?php echo  \Yii::t('app', 'Добавить вариант ответа «Другое»'); ?>
            </div>
            <label class="switch">
                <input type="checkbox" <?= $addOther ? 'checked' : '' ?> class="add-other" name="addOther_<?= $groupNamePrefix; ?>">
                <span class="slider round"></span>
            </label>
        </div>
        <div class="switch-row">
            <div class="label">
                <?php echo  \Yii::t('app', 'Добавить вариант ответа «Ничего из вышеперечисленного»'); ?>
            </div>
            <label class="switch">
                <input type="checkbox" <?= $addNeither ? 'checked' : '' ?> class="add-neither" name="addNeither_<?= $groupNamePrefix; ?>">
                <span class="slider round"></span>
            </label>
        </div>
        <div class="switch-row">
            <div class="label">
                <?php echo  \Yii::t('app', 'Поле комментария'); ?>
            </div>
            <label class="switch">
                <input type="checkbox" <?= $addComment ? 'checked' : '' ?> class="add-comment" name="addComment_<?= $groupNamePrefix; ?>">
                <span class="slider round"></span>
            </label>
        </div>
        <div class="switch-row">
            <div class="label">
                <?php echo  \Yii::t('app', 'Несколько вариантов ответов'); ?>
            </div>
            <label class="switch">
                <input type="checkbox" <?= $multiple ? 'checked' : '' ?> name="multiple_<?= $groupNamePrefix; ?>">
                <span class="slider round"></span>
            </label>
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


        <div class="switch-row">
            <div class="label">
                Пропустить все элементы после текущего
            </div>
            <label class="switch">
                <input onchange="$(this).closest('.switch-row').next('.switch-row').slideToggle();" type="checkbox" <?= $isSkipAll ? 'checked' : '' ?> name="isSkipAll_<?= $elementOrder ?>">
                <span class="slider round"></span>
            </label>
        </div>

        <div class="switch-row" style="justify-content: flex-start; column-gap: 50px;display: <?= $isSkipAll ? 'flex;' : 'none'; ?>;">
            <div class="label">
                Введите элемент для пропуска
            </div>
            <div>
                <input type="number" name="skipItem_<?= $elementOrder ?>" value="<?= $skipItem; ?>">
            </div>
        </div>

    </div>
</div>
