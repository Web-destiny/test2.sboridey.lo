<div class="question-wrap question-single" data-id="1">
    <?php
        $question_name = $element['question'];
        if(!$survey->has_numbering) {
            $pattern = "/^\d+\./iusU";
            $question_name = preg_replace($pattern, '', $question_name);
        }

    ?>
    <div class="question-name" data-origin="<?= $question_name ?>" > <?php echo $question_name; ?> </div>
    <?php echo $this->render('/site//partials/fileQuestion', ['element' => $element]) ?>

    <input type="hidden" name="single-question[<?= $element['element_order']; ?>]" value="<?php echo $element['id'] ?>" >

    <div data-reqired="reqired" class="__single-item radio-btns-wrapper">
        <?php $n = 1; ?>
        <?php if(!empty($element['elements'])): ?>
            <?php   foreach ($element['elements'] as $key => $item):  ?>
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

                <input type="hidden" class="el-type" value="<?= $elType; ?>">

                <div class="radio-item">
                    <?php if($elType == 'radio'):?>
                        <input type="<?php echo $elType; ?>" name="single[<?= $element['element_order']; ?>][1]" id="q-<?php echo $element['element_order']  ?>-<?php echo $n; ?>" value="<?php echo $item ?>">
                    <?php else:?>
                        <input type="<?php echo $elType; ?>" name="single[<?= $element['element_order']; ?>][<?= $n; ?>]>" id="q-<?php echo $element['element_order']  ?>-<?php echo $n; ?>" value="<?php echo $item ?>" data-reqired="reqired">
                    <?php endif;?>
                    <label for="q-<?php echo $element['element_order']  ?>-<?php echo $n; ?>">
                        <?php  if($res)  echo $item; ?>
                    </label>
                </div>

                <?php $n++; endforeach; ?>
        <?php endif; ?>
    </div>

    <?php if(!empty($element['elements']) && !empty($element['elements']['addComment'])): ?>
        <div class="option-comment">
            <textarea name="single-comment[<?= $element['element_order']; ?>]" rows="1" placeholder="Введите ваш комментарий" style="overflow: hidden; min-height: 30px;" ></textarea>
        </div>
    <?php endif; ?>
</div>
