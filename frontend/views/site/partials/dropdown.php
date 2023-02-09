<div class="question-wrap question-dropdown" data-id="5" data-index="<?= $element['element_order']; ?>">
    <input type="hidden" name="dropdown-question[<?= $element['element_order'] ?>]" value="<?php echo $element['id'] ?>">

    <?php
        $question_name = $element['question'];
        if(!$survey->has_numbering) {
            $pattern = "/^\d+\./iusU";
            $question_name = preg_replace($pattern, '', $question_name);
        }
    ?>

    <div class="question-name" data-origin="<?= $question_name ?>"><?php echo $question_name; ?></div>

    <?php echo $this->render('/site//partials/fileQuestion', ['element' => $element]) ?>

    <?php $elType = ''; ?>
    <?php if(isset($element['elements']) &&  $element['elements']['multiple'] == 'on'): ?>
        <?php $elType = 'multiple' ?>
    <?php endif; ?>

    <?php $elReqired = '' ?>
    <?php if(isset($element['elements']) &&  $element['elements']['required'] == 'on'): ?>
        <?php $elReqired = 'reqired' ?>
    <?php endif; ?>

    <div class="dropdown-wrap">
        <select
            class="customselect"
            name="dropdown[<?= $element['element_order'] ?>][]"
            <?php echo $elType; ?>
            data-reqired="<?php echo $elReqired; ?>"
            data-add-hint-text="<?php echo true; ?>"
        >
            <option value="">Выберите ответ</option>

            <?php if(!empty($element['elements'])):  ?>
                <?php $n=1;  foreach ($element['elements'] as $key => $item):  ?>
                    <?php
                    $pattern = "/inputpoint_\d+/iuUs";
                    $res = preg_match($pattern, $key);
                    if(!$res) continue;
                    if(!trim($item)) continue;

                    $related = $element['elements']["related_$n"] ?? null;

                    if ($related) {
                        $related = json_encode(
                            array_filter(explode(',', $related), 'intval')
                        );
                    }

                    ?>

                    <option
                        data-related='<?= $related; ?>'
                        data-skip="<?= !empty($element['elements']['isSkipAll']) && !empty($element['elements']['skipItem']) && $element['elements']['skipItem'] == $n ?>"
                        value="<?php echo $item; ?>"><?php echo $item; ?></option>
                    <?php $n++; endforeach; ?>
            <?php endif; ?>

        </select>
    </div>

    <?php if(!empty($element['elements']) && !empty($element['elements']['addComment'])): ?>
        <div class="option-comment">
            <textarea name="dropdown-comment[<?= $element['element_order']; ?>]" rows="1" placeholder="Введите ваш комментарий"></textarea>
        </div>
    <?php endif; ?>

</div>
