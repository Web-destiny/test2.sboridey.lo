<div class="question-wrap question-phone" data-id="11">
    <div class="question-name" data-origin="<?= $element['question'] ?>"><?php echo $element['question']; ?></div>

    <?php echo $this->render('/site//partials/fileQuestion', ['element' => $element]) ?>

    <div class="phone-answer">
        <input class="code" type="text" name="q-11-1" value="+7" readonly>
        <input class="phone" type="tel" maxlength="11" name="q-11-2">
    </div>
</div>

