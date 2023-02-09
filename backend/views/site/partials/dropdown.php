<div class="question-wrap question-dropdown" data-id="5">
    <div class="question-name"  data-origin="<?= $element['question'] ?>"><?php echo $element['question']; ?></div>

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
        <select class="customselect" name="q-5" <?php  echo $elType; ?> data-reqired="<?php echo $elReqired; ?>" >

            <?php if(!empty($element['elements'])):  ?>
                <?php $n=1;  foreach ($element['elements'] as $key => $item):  ?>
                    <?php
                    $pattern = "/inputpoint_\d+/iuUs";
                    $res = preg_match($pattern, $key);
                    if(!$res) continue;
                    if(!trim($item)) continue;
                    ?>

                    <option value="Ответ 1"><?php echo $item;  ?></option>
                    <?php $n++; endforeach; ?>
            <?php endif; ?>

        </select>
    </div>

    <?php if(!empty($element['elements'])): ?>
        <div class="option-comment">
            <textarea name="single-comment_<?php echo $element['element_order'] . '_' .  1 ?>" rows="1" placeholder="Введите ваш комментарий"></textarea>
        </div>
    <?php endif; ?>

</div>
