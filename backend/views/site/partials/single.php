<div class="question-wrap question-single" data-id="1">
    <div class="question-name" data-origin="<?= $element['question'] ?>"> <?php echo $element['question']; ?> </div>

    <?php echo $this->render('/site//partials/fileQuestion', ['element' => $element]) ?>



    <div class="radio-btns-wrapper">
        <?php if(!empty($element['elements'])):  ?>
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

                <div class="radio-item">
                    <input type="<?php echo $elType; ?>" name="q-<?php echo $element['element_order']  ?>-1" id="q-<?php echo $element['element_order']  ?>-<?php echo $n; ?>" value="Вариант ответа">
                    <label for="q-<?php echo $element['element_order']  ?>-<?php echo $n; ?>">
                        <?php  if($res)  echo $item; ?>
                    </label>
                </div>
                <?php $n++; endforeach; ?>
        <?php endif; ?>
    </div>
    <?php echo $this->render('/site//partials/comment', ['element' => $element]) ?>
</div>