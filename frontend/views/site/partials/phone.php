<div class="question-wrap question-phone" data-id="11">

    <?php
        $question_name = $element['question'];
        if(!$survey->has_numbering) {
            $pattern = "/^\d+\./iusU";
            $question_name = preg_replace($pattern, '', $question_name);
        }
    ?>
    <div class="question-name" data-origin="<?= $question_name ?>"><?php echo $question_name; ?></div>

    <input type="hidden" name="date-question[<?= $element['element_order'] ?>]" value="<?php echo $element['id'] ?>">

    <?php echo $this->render('/site//partials/fileQuestion', ['element' => $element]) ?>

    <div class="phone-answer">
        <input class="code" type="text" name="q-11-1" value="+7" readonly>
        <input class="phone" type="tel" maxlength="11" name="q-11-2">
    </div>
</div>

