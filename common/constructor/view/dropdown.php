<?php

/**
 * @var \yii\web\View $this
 * @var $elementOrder array
 * @var $groupData array
 * @var $groupNamePrefix string
 */

use common\constructor\BaseElement; ?>

<div class="question-wrap question-dropdown question-new" data-id="<?= $groupNamePrefix; ?>">
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
        <input type="hidden" name="type_<?= $groupNamePrefix; ?>" value="dropdown">
        <div class="question-name">
            <textarea name="question_<?= $groupNamePrefix; ?>" rows="1" placeholder="Введите ваш вопрос" data-required="required" style="overflow: hidden; height: 29px;"><?= $question; ?></textarea>
        </div>

        <?= $this->renderFile(BaseElement::VIEW_PATH . 'partials/_file.php', ['elementOrder' => $groupNamePrefix, 'hasFile' => $hasFile, 'file' => $file, 'fileType' => $fileType, 'fileOriginalType' => $fileOriginalType]); ?>

        <div class="dropdown-wrap customselect-wrapper">
            <div class="select">
                <select class="customselect select-hidden">
                    <?php $n = 0; foreach ($inputPoint as $item): ?>
                        <option <?= $n==0 ? 'selected' : '' ?> value="<?= $item['value'] ?>"><?= $item['value'] ?></option>
                    <?php $n++; endforeach; ?>
                </select>
                <div class="select-styled">
                    <div class="default"><?= $inputPoint[0]['value'] ?? null ?></div>
                </div>
                <ul class="select-options" style="display: none;">
                    <?php $n = 0; foreach ($inputPoint as $item): ?>
                        <li rel="<?= $item['value'] ?>" class="<?= $n==0 ? 'active' : '' ?>"><?= $item['value'] ?></li>
                    <?php $n++; endforeach; ?>
                </ul>
            </div>
        </div>

        <?php if ($addComment): ?>
            <div class="option-comment">
                <textarea rows="1" placeholder="Введите ваш комментарий" style="overflow: hidden; height: 22px;"></textarea>
            </div>
        <?php endif; ?>

        <div class="optins-list">
            <?php $n = 1; foreach ($inputPoint as $key => $item): ?>
                <section style="display: flex;justify-content: space-between;flex-wrap: wrap;">
                    <div class="option-item" style="width: 50%;">
                        <div class="inputpoint-body">
                            <div class="number"><?= $n; ?>.</div>
                            <div class="value">
                                <input type="text" name="<?= $item['name'] ?>" value="<?= $item['value'] ?>">
                            </div>
                        </div>
                    </div>
                    <div class="option-item" style="width: 300px">
                        <div class="value">
                            <textarea placeholder="Скрыть элемент No: только цифры и запятая"
                                    class="__textarea" type="text"
                                    name="<?= $inputPointRelated[$key]['nameRelated'] ?>"><?= $inputPointRelated[$key]['valueRelated'] ?></textarea>
                        </div>
                    </div>
                </section>
            <?php $n++; endforeach; ?>
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
                <?php echo  \Yii::t('app', 'Добавить поле для комментария'); ?>
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
    </div>
</div>

<style>
    .__textarea {
        overflow: hidden;
        border: none;
        outline: none;
        padding-bottom: 8px;
        border-bottom: 1px solid #E5E5E5;
        font-family: "Gilroy", Verdana, Tahoma, sans-serif;
        font-style: normal;
        font-weight: normal;
        font-size: 13px;
        line-height: 15px;
        color: #000000;
        width: 100%;
        max-width: 500px;
        height: 25px;
    }
</style>
