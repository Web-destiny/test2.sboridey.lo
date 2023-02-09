<div class="question-wrap question-scale" data-id="1">
    <div class="question-name" data-origin="<?= $element['question'] ?>"> <?php echo $element['question']; ?> </div>

    <?php echo $this->render('/site//partials/fileQuestion', ['element' => $element]) ?>

    <?php
        $scaleType = 'star';
        $scaleAmount = 0;
        $scaleTypes = ['star', 'face', 'heart', 'hand', 'diapason'];
        if (!empty($element['elements'])) {
            foreach ($element['elements'] as $key => $item) {
                if(in_array($item, $scaleTypes))  $scaleType = $item;

                if($key == 'scaleAmount') {
                    $scaleAmount = intval($item);
                }
            }
        }
    ?>

    <?php
//    echo '<pre>';
//    print_r($scaleType);
//    die;
    echo '</pre>';
    
    ?>
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
    <div class="scale-wrap scale-<?php echo $scaleType; ?> scale-<?=$scaleAmount?>">
        <?php $elType = 'radio' ?>
        <?php if(!empty($element['elements']) ):  ?>
            <?php for($i = 0; $i < $scaleAmount; $i++):  ?>
                <input type="radio" id="q-<?php echo $element['element_order']  ?>-<?php echo $i?>" name="q-<?php echo $element['element_order']  ?>" value="10" />
                <label for="q-<?php echo $element['element_order']  ?>-<?php echo $i?>" title="text"></label>
            <?php endfor; ?>
        <?php endif; ?>
    </div>
    <?php endif;?>

    <div class="scale-labels-wrap scale-<?=$scaleAmount?>">
        <?php if(!empty($element['elements']) ):  ?>
            <?php $n=1;  foreach ($element['elements'] as $key => $item):  ?>
                <?php
                $pattern = "/inputpoint_\d+/iuUs";
                $res = preg_match($pattern, $key);
                if(!$res) continue;
                if(!trim($item)) continue;
                ?>
                <?php $elType = 'radio' ?>
                <?php if(isset($element['elements']) && isset($element['elements']['addComment']) && $element['elements']['multiple'] == 'on'): ?>
                    <?php $elType = 'checkbox' ?>
                <?php endif; ?>


                <div class="label-item"><?php if($res)  echo $item; ?></div>
                <?php $n++; endforeach; ?>
        <?php endif; ?>

    </div>
</div>
