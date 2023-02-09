<div class="question-wrap question-scale" data-id="<?=$element['element_order']?>">
    <?php
        $question = $element['question'];

        $question_name = $element['question'];
        if(!$survey->has_numbering) {
            $pattern = "/^\d+\./iusU";
            $question_name = preg_replace($pattern, '', $question_name);
        }
    ?>
    <div class="question-name" data-origin="<? echo $question_name ?>"> <?php echo $question_name; ?> </div>

    <input type="hidden" name="scale-question[<?= $element['element_order']; ?>]" value="<?php echo $element['id'] ?>" >

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

    <?php if($scaleType == 'diapason'):?>
        <div class="diapason-answer">
            <div class="diapason">
                <div class="label">
                    <div class="value">0</div>
                </div>
                <div class="input-box">
                    <input class="input-range" name="scale[<?= $element['element_order']; ?>][1]" type="range" min="1" max="<?=$scaleAmount?>" step="1" value="0" data-reqired="reqired"/>
                    <div class="bar"></div>
                    <div class="bar-filled"></div>
                </div>
            </div>
        </div>
    <?php else: ?>
    <div data-reqired="reqired" class="__scale-item scale-wrap scale-<?php echo $scaleType; ?> scale-<?=$scaleAmount?>">
        <?php $elType = 'radio' ?>
        <?php if(!empty($element['elements']) ):  ?>
        <?php $number = 1; ?>
            <?php for($i = $scaleAmount; $i > 0; $i--):  ?>
            <?php
            /*
                $element_yes_no = '';
                if($element['element_order'] == 11) {
                    $element_yes_no = $i + 11;
                    $number = $element_yes_no;
                } else {
                    $number = $i;
                }
            */
                $number = $i;
            ?>
                <input
                    type="radio" id="q-<?php echo $element['element_order']  ?>-<?php echo $i?>"
                    name="scale[<?= $element['element_order']; ?>][1]" value="<?php echo $number;  ?>"
                />
                <label for="q-<?php echo $element['element_order']  ?>-<?php echo $i?>"></label>
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
                <div class="label-item"><?php if($res)  echo $item; ?></div>
                <?php $n++; endforeach; ?>
        <?php endif; ?>
    </div>
</div>
