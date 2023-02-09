<div class="question-wrap question-date" data-id="9">
    <div class="question-name" data-origin="<?= $element['question'] ?>"><?php echo $element['question']; ?> </div>

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
                        <input type="text" class="date-input" maxlength="10" name="q-9" data-reqired="<?php echo $elReqired; ?>" >
                        <div class="icon-date"></div>
                    </div>
           <?php endfor; ?>
        </div>
    <?php endif; ?>

    <?php if(!empty($element['elements'])): ?>
        <div class="option-comment">
            <textarea name="single-comment_<?php echo $element['element_order'] . '_' .  1 ?>" rows="1" placeholder="Введите ваш комментарий"></textarea>
        </div>
    <?php endif; ?>

</div>
