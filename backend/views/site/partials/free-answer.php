<div class="question-wrap question-free" data-id="1">
    <div class="question-name" data-origin="<?= $element['question'] ?>"> <?php echo $element['question']; ?> </div>

    <?php echo $this->render('/site//partials/fileQuestion', ['element' => $element]) ?>
    <div class="free-answers">
        <?php if(!empty($element['elements'])):  ?>
            <?php $n=1;  foreach ($element['elements'] as $key => $item):  ?>
                <?php
                $pattern = "/\bamount\b/iuUs";
                $res = preg_match($pattern, $key);
                if(!$res) continue;
                if(!trim($item)) continue;
                ?>
                <?php for($i = 0; $i < intval($item); $i++):  ?>
                    <div class="answer-wrap">
                        <textarea rows="1" placeholder="Введите ваш комментарий"></textarea>
                    </div>
                <?php endfor; ?>
                <?php $n++; endforeach; ?>
        <?php endif; ?>
    </div>
</div>