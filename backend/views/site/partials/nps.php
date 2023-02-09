<div class="question-wrap question-scale nps-question-scale" npsDiapasoneStart="0" npsDiapasoneEnd="3" finishSurveyStart="9" finishSurveyEnd="10" data-id="<?php echo $element['element_order']  ?>">

    <?php
    $json = '';
    if (!empty($element['elements']) && isset($element['elements']['npsAction_' . $element['element_order']])) {
        $json = is_array($element['elements']['npsAction_' . $element['element_order']]) ? $element['elements']['npsAction_' . $element['element_order']] : '';
    }

    $npsAction = [];
    if(isset($element['elements']['npsAction_' . $element['element_order']])) {
        $npsActions = $element['elements']['npsAction_' . $element['element_order']];
    }

    ?>
    <input type="hidden" class="nps_diapasons_json" value="<?php echo htmlspecialchars(json_encode($json)); ?>">
    <input type="hidden" id="nps_diapasons_<?php echo $element['element_order'] ?> " value="<?php echo  json_encode($json); ?>">


    <?php if(isset($pageName)): ?>
        <input type="hidden" class="is-page-preview" value="preview" >
    <?php endif; ?>


    <div class="question-name" data-origin="<?= $element['question'] ?>">
        <?php echo $element['question']; ?>
    </div>
    <input type="hidden" name="question_<?php echo $element['element_order'] ?>" value="<?php echo $element['question'] ?>" >

    <?php echo $this->render('/site//partials/fileQuestion', ['element' => $element]) ?>

    <?php
    $npsType = 'star';
    $npsAmount = 0;
    $npsTypes = ['star', 'face', 'heart', 'hand', 'diapason'];
    if (!empty($element['elements'])) {
        foreach ($element['elements'] as $key => $item) {
            if (in_array($item, $npsTypes))  $npsType = $item;

            if ($key == 'npsAmount') {
                $npsAmount = intval($item);
            }
        }
    }
    ?>

    <?php if ($npsType == 'diapason') : ?>
        <div class="diapason-answer">
            <div class="diapason">
                <div class="label">
                    <div class="value">0</div>
                </div>
                <div class="input-box">
                    <input class="input-range" type="range" min="1" max="<?= $npsAmount ?>" step="1" name="nps_<?php echo $element['element_order']  ?>" value="0" />
                    <div class="bar"></div>
                    <div class="bar-filled"></div>
                </div>
            </div>
        </div>
    <?php else : ?>
        <div class="scale-wrap scale-<?php echo $npsType ?> scale-10">
            <?php $elType = 'radio' ?>
            <?php if (!empty($element['elements'])) :  ?>
                <?php for ($i = $npsAmount; $i >= 1; $i--) :  ?>
                    <input type="radio" id="nps-scale_<?php echo $element['element_order'] ?>_<?php echo $i ?>" name="nps_<?php echo $element['element_order'] ?>" value="<?php echo $i ?>" />
                    <label for="nps-scale_<?php echo $element['element_order'] ?>_<?php echo $i ?>" title="text"></label>
                <?php endfor; ?>
            <?php endif; ?>

        </div>
        <div class="scale-labels-wrap scale-11">
            <?php if (!empty($element['elements'])) :  ?>
                <?php $n = 0;
                //dd($element['elements']);
                foreach ($element['elements'] as $key => $item) :  ?>
                    <?php
                    $pattern = "/inputpoint_\d+/iuUs";
                    $res = '';
                    $res = preg_match($pattern, $key);
                    if (!$res) continue;
                    ?>
                    <?php $elType = 'radio' ?>
                    <?php if (isset($element['elements']) && isset($element['elements']['addComment']) && $element['elements']['multiple'] == 'on') : ?>
                        <?php $elType = 'checkbox' ?>
                    <?php endif; ?>


                    <div class="label-item"><?php if ($res)  echo $item  ?></div>
                    <?php $n++;
                endforeach; ?>
            <?php endif; ?>
        </div>
        <div class="free-answers">
            <div class="answer-wrap">
                <textarea name="npsAction_<?php echo $element['element_order']. '_' . $key ?>" rows="1" placeholder="Введите ваш комментарий"></textarea>

            </div>
        </div>
    <?php endif; ?>
    <div class="thx-popup-wrap">
        <div class="thx-popup__body">
            <p class="thx-popup__text popup-txt">Благодарим за прохождение опроса!</p>
            <p class="thx-popup__sub-text popup-txt">Вы помогаете нам стать лучше</p>
            <i class="thx-popup__close"></i>
        </div>
    </div>
</div>
