<?php use common\constructor\BaseElement;

if(isset($element['file']) && trim($element['file'])): ?>
    <?php
    $fileData = json_decode($element['file'], true);
    $fileType = $fileData['fileType'] ?? '';
    $file = $fileData['file'] ?? '';
    ?>

    <?php if(trim($file)): ?>
        <?php if($fileType == 'image'): ?>
            <div class="added-file-wrap">
                <div class="img-wrap">
                    <img  src="<?php echo '/backend/web/constructor' . '/' . $file ; ?>"  >
<!--                    <img  src="--><?php //echo \yii\helpers\Url::to(['constructor/'.$file]) ; ?><!--"  >-->
                </div>
            </div>

        <?php elseif($fileType == 'video'): ?>
            <div class="added-file-wrap">
                <div class="video-wrap">
                    <video-radio-star class="radiostar-enhanced radiostar-paused">
                        <video controls>
                            <source src="<?php echo '/backend/web/constructor' . '/' . $file ; ?>">
<!--                            <source src="--><?php //echo \yii\helpers\Url::to(['constructor/'.$file]) ; ?><!--">-->
                            Your browser does not support HTML5 video.
                        </video>
                        <button type="button" class="video-play" data-play=""></button>
                    </video-radio-star>
                </div>
            </div>
        <?php elseif($fileType == 'audio'): ?>
            <div class="added-file-wrap">
                <div class="audio-wrap">
                    <div class="audio-control"></div>
                    <div class="audiowave" data-audiopath="<?php echo '/backend/web/constructor' . '/' . $file ; ?>"></div>
<!--                    <div class="audiowave" data-audiopath="--><?php //echo \yii\helpers\Url::to(['constructor/'.$file]) ; ?><!--"></div>-->
                    <div class="audio-duration"></div>
                </div>
            </div>
        <?php endif; ?>
    <?php endif; ?>

<?php endif;  ?>