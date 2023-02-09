<div class="question-wrap question-date" data-id="9">

    <?php
        $question_name = $element['question'];
        if(!$survey->has_numbering) {
            $pattern = "/^\d+\./iusU";
            $question_name = preg_replace($pattern, '', $question_name);
        }
    ?>
    <div class="question-name" data-origin="<?= $question_name ?>"><?php echo $question_name; ?> </div>

    <input type="hidden" name="date-question[<?= $element['element_order'] ?>]" value="<?php echo $element['id'] ?>">

    <?php echo $this->render('/site//partials/fileQuestion', ['element' => $element]) ?>

    <?php $elReqired = '' ?>
    <?php if(isset($element['elements']) &&  $element['elements']['required'] == 'on'): ?>
        <?php $elReqired = 'reqired' ?>
    <?php endif; ?>


    <?php if(isset($element['elements']) && isset($element['elements']['amount'])): ?>
       <?php $amount = intval($element['elements']['amount']);  ?>
        <div class="data-list">
           <?php for($i = 0; $i < $amount; $i++): ?>
                    <div class="date-answer">
                        <input type="text" class="date-input" maxlength="10" name="date[<?= $element['element_order']; ?>][]" data-reqired="<?php echo $elReqired; ?>">
                        <div class="icon-date"></div>
                    </div>
           <?php endfor; ?>
        </div>
    <?php endif; ?>

</div>
