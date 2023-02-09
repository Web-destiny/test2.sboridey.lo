<div class="question-wrap question-free" data-id="1">

    <?php
        $question_name = $element['question'];
        if(!$survey->has_numbering) {
            $pattern = "/^\d+\./iusU";
            $question_name = preg_replace($pattern, '', $question_name);
        }
    ?>
    <div class="question-name " data-origin="<?= $question_name ?>"> <?php echo $question_name; ?> </div>

    <?php echo $this->render('/site//partials/fileQuestion', ['element' => $element]) ?>

    <input type="hidden" name="free-answer-question[<?= $element['element_order']; ?>]" value="<?php echo $element['id'] ?>" >

    <div class="free-answers">
        <?php if(!empty($element['elements'])):  ?>
            <?php $n=1;  foreach ($element['elements'] as $key => $item):  ?>
                <?php
                $pattern = "/\bamount\b/iuUs";
                $res = preg_match($pattern, $key);
                if(!$res) continue;
                if(!trim($item)) continue;
                ?>
                <?php for($i = 0; $i < intval($item); $i++):  ?>
                    <div class="answer-wrap">
                        <textarea style="min-height: 30px;" name="free-answer[<?= $element['element_order']; ?>][<?= $n; ?>]"  rows="1" placeholder="Введите ваш комментарий" data-reqired="reqired"></textarea>
                    </div>
                <?php endfor; ?>
                <?php $n++; endforeach; ?>
        <?php endif; ?>
    </div>
</div>