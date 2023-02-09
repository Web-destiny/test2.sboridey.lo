<div class="question-wrap question-name" data-id="8">
    <div class="question-name" data-origin="<?= $element['question'] ?>"><?php echo $element['question']; ?></div>

    <?php echo $this->render('/site//partials/fileQuestion', ['element' => $element]) ?>

    <?php $elReqired = '' ?>
    <?php if(isset($element['elements']) &&  $element['elements']['required'] == 'on'): ?>
        <?php $elReqired = 'reqired' ?>
    <?php endif; ?>

    <div class="name-answers   test-class">
        <div class="answer-wrap">
            <textarea rows="1" placeholder="Имя" name="q-8-1" data-reqired="<?php echo $elReqired; ?>" ></textarea>
        </div>
        <div class="answer-wrap">
            <textarea rows="1" placeholder="Отчество" name="q-8-1"></textarea>
        </div>
        <div class="answer-wrap">
            <textarea rows="1" placeholder="Фамилия" name="q-8-1" data-reqired="<?php echo $elReqired; ?>"></textarea>
        </div>
    </div>

    <?php if(!empty($element['elements'])): ?>
        <div class="option-comment">
            <textarea name="single-comment_<?php echo $element['element_order'] . '_' .  1 ?>" rows="1" placeholder="Введите ваш комментарий"></textarea>
        </div>
    <?php endif; ?>

</div>
