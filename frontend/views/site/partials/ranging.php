<div class="question-wrap question-ranging" data-id="7">

    <?php
        $question_name = $element['question'];
        if(!$survey->has_numbering) {
            $pattern = "/^\d+\./iusU";
            $question_name = preg_replace($pattern, '', $question_name);
        }
    ?>
    <div class="question-name" data-origin="<?= $question_name ?>"><?= $question_name; ?></div>
    <input type="hidden" name="ranging-question[<?= $element['element_order']; ?>]" value="<?php echo $element['id'] ?>" >

    <?php echo $this->render('/site//partials/fileQuestion', ['element' => $element]) ?>

    <?php $elReqired = '' ?>
    <?php if(isset($element['elements']) &&  $element['elements']['required'] == 'on'): ?>
        <?php $elReqired = 'reqired' ?>
    <?php endif; ?>

    <div class="ranging-list">

        <?php if(!empty($element['elements'])):  ?>
            <?php $n=1;  foreach ($element['elements'] as $key => $item):  ?>
                <?php
                $pattern = "/inputpoint_\d+/iuUs";
                $res = preg_match($pattern, $key);
                if(!$res) continue;
                if(!trim($item)) continue;
                ?>

                <div class="ranging-item">
                    <div class="grab-icon"></div>
                    <div class="ranging-name">
                        <input type="hidden" name="ranging[<?= $element['element_order']; ?>][]" value="<?= $item; ?>">
                        <?= $item; ?>
                    </div>
                </div>
            <?php $n++; endforeach; ?>
        <?php endif; ?>

    </div>

</div>

