<div class="question-wrap question-ranging" data-id="7">
    <div class="question-name" data-origin="<?= $element['question'] ?>"><?php echo $element['question']; ?></div>

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
                        <input type="hidden" name="q-7-1" value="Ответ">
                        <?php  if($res)  echo $item; ?>
                    </div>
                </div>
                <?php $n++; endforeach; ?>
        <?php endif; ?>
    </div>

    <?php if(!empty($element['elements'])): ?>
        <div class="option-comment">
            <textarea name="single-comment_<?php echo $element['element_order'] . '_' .  1 ?>" rows="1" placeholder="Введите ваш комментарий"></textarea>
        </div>
    <?php endif; ?>

</div>

