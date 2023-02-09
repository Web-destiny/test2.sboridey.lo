<div class="question-wrap question-name" data-id="8">

    <?php
        $question_name = $element['question'];
        if(!$survey->has_numbering) {
            $pattern = "/^\d+\./iusU";
            $question_name = preg_replace($pattern, '', $question_name);
        }
    ?>
    <div class="question-name" data-origin="<?= $question_name ?>"><?php echo $question_name; ?></div>

    <input type="hidden" name="name-question[<?= $element['element_order']; ?>]" value="<?php echo $element['id'] ?>" >

    <?php echo $this->render('/site//partials/fileQuestion', ['element' => $element]) ?>

    <?php $elReqired = '' ?>
    <?php if(isset($element['elements']) &&  $element['elements']['required'] == 'on'): ?>
        <?php $elReqired = 'reqired' ?>
    <?php endif; ?>

    <div class="name-answers   test-class">
        <div class="answer-wrap">
            <textarea rows="1" placeholder="Имя" name="name[<?= $element['element_order']; ?>][1]" data-reqired="<?php echo $elReqired; ?>"></textarea>
        </div>
        <div class="answer-wrap">
            <textarea rows="1" placeholder="Отчество" name="name[<?= $element['element_order']; ?>][2]"></textarea>
        </div>
        <div class="answer-wrap">
            <textarea rows="1" placeholder="Фамилия" name="name[<?= $element['element_order']; ?>][3]" data-reqired="<?php echo $elReqired; ?>"></textarea>
        </div>
    </div>

</div>
