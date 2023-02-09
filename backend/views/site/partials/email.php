<div class="question-wrap question-email" data-id="10">
    <div class="question-name"  data-origin="<?= $element['question'] ?>"><?php echo $element['question']; ?></div>

    <?php echo $this->render('/site//partials/fileQuestion', ['element' => $element]) ?>

    <div class="email-answer">
        <input type="email" placeholder="Email" name="q-10">
    </div>
</div>
