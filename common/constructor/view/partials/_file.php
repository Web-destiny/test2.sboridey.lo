<?php

use yii\helpers\Url;
use common\constructor\BaseElement;

if (is_string($file) && strpos($file, DIRECTORY_SEPARATOR) !== false) {
    $file = explode(DIRECTORY_SEPARATOR, $file);
    $fileName = end($file);
    $file = '/backend/web/' . BaseElement::PUBLIC_STORAGE_URL . '/' . end($file);
} elseif (is_string($file)) {
    $fileName = $file;
    $file = '/backend/web/' . BaseElement::PUBLIC_STORAGE_URL . '/' . $file;
}
?>
<?php if ($file): ?>
    <div class="added-file-wrap">
        <?php if ($fileType == 'image'): ?>
            <div class="img-wrap">
                <?php $randNumber =  Yii::$app->security->generateRandomString(8);  ?>
                <img src="<?= $file . "?v=" . $randNumber; ?>">
                <div class="img-remove" onclick="$(this).next('.has-file-input').val(0);"></div>
                <input type="hidden" class="has-file-input" name="hasFile_<?= $elementOrder ?>" value="<?= $hasFile ? 1 : 0; ?>">
                <textarea hidden name="fileObject_<?= $elementOrder ?>"><?= json_encode([
                        'file' => $fileName,
                        'fileType' => $fileType,
                        'fileOriginalType' => $fileOriginalType,
                    ]); ?></textarea>
            </div>
        <?php endif; ?>

        <?php if ($fileType == 'video'): ?>
            <div class="video-wrap">
                <video-radio-star class="radiostar-enhanced radiostar-paused">
                    <video>
                        <source src="<?= $file ?>">
                        <?php echo  \Yii::t('app', 'Your browser does not support HTML5 video'); ?>.
                    </video>
                    <button type="button" class="video-play" data-play=""></button>
                </video-radio-star>
                <div class="video-remove" onclick="$(this).next('.has-file-input').val(0);"></div>
                <input type="hidden" class="has-file-input" name="hasFile_<?= $elementOrder ?>" value="<?= $hasFile ? 1 : 0; ?>">
                <textarea hidden name="fileObject_<?= $elementOrder ?>"><?= json_encode([
                        'file' => $fileName,
                        'fileType' => $fileType,
                        'fileOriginalType' => $fileOriginalType,
                    ]); ?></textarea>
            </div>
        <?php endif; ?>

        <?php if ($fileType == 'audio'): ?>
            <div class="audio-wrap">
                <div class="audio-control"></div>
                <div class="audiowave" data-audiopath="<?= $file ?>"></div>
                <div class="audio-duration">0:00</div>
                <div class="audio-remove" onclick="$(this).next('.has-file-input').val(0);"></div>
                <input type="hidden" class="has-file-input" name="hasFile_<?= $elementOrder ?>" value="<?= $hasFile ? 1 : 0; ?>">
                <textarea hidden name="fileObject_<?= $elementOrder ?>"><?= json_encode([
                        'file' => $fileName,
                        'fileType' => $fileType,
                        'fileOriginalType' => $fileOriginalType,
                    ]); ?></textarea>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>