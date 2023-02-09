<div class="question-wrap question-file" data-id="12">
    <div class="question-name" data-origin="<?= $element['question'] ?>"><?php echo $element['question']; ?></div>

    <?php echo $this->render('/site//partials/fileQuestion', ['element' => $element]) ?>

    <div class="file-answer">
        <label for="q-12">
            <input type="file" multiple name="q-12" id="q-12">
        </label>
    </div>
</div>