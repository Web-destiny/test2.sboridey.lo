<div class="question-wrap question-email" data-id="10">

    <?php
        $question_name = $element['question'];
        if(!$survey->has_numbering) {
            $pattern = "/^\d+\./iusU";
            $question_name = preg_replace($pattern, '', $question_name);
        }
    ?>
    <div class="question-name" data-origin="<?= $question_name ?>"><?php echo $question_name; ?></div>

    <input type="hidden" name="email-question[<?= $element['element_order']; ?>]" value="<?php echo $element['id'] ?>" >

    <?php echo $this->render('/site//partials/fileQuestion', ['element' => $element]) ?>

    <?php $elReqired = '' ?>
    <?php if(isset($element['elements']) &&  $element['elements']['required'] == 'on'): ?>
        <?php $elReqired = 'reqired' ?>
    <?php endif; ?>

    <div class="email-answer">
        <input type="email" placeholder="Email" name="email[<?= $element['element_order']; ?>][]" data-reqired="<?php echo $elReqired; ?>">
    </div>
</div>
