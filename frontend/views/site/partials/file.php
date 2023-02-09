<div class="question-wrap question-file" data-id="12">

    <?php
        $question_name = $element['question'];
        if(!$survey->has_numbering) {
            $pattern = "/^\d+\./iusU";
            $question_name = preg_replace($pattern, '', $question_name);
        }
    ?>
    <div class="question-name" data-origin="<?= $question_name ?>"><?php echo $question_name; ?></div>

    <input type="hidden" name="file-question[<?= $element['element_order']; ?>]" value="<?php echo $element['id'] ?>" >

    <?php echo $this->render('/site//partials/fileQuestion', ['element' => $element]) ?>

    <div class="file-answer">
        <label for="q-12">
            <input type="file" multiple name="q-12" id="q-12">
        </label>
    </div>
</div>