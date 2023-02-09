<?php
/**
 * @var int $surveyPassedCount
 * @var int $order
 * @var array $details
 * @var \common\models\SurveyElement[] $surveyElement
 */
?>

<section class="free-answer box-wrapper">
    <p class="question-txt-block"><span class="question-number"><?= $order; ?>/<?= $key + 1; ?></span> <span class="question-txt"><?php echo $surveyElement->question; ?></span>

    <p class="question-type-details">
        <span class="question-count"><?= $surveyPassedCount; ?> ответов</span>
    </p>
    </p>

    <div class="chart-container">
        <div class="comments-container w-100">
            <?php foreach ($answers as $answer):  ?>
                <?php $text = ''; ?>
                <?php $n = 0; foreach ($answer as $a): ?>
                    <?php if($surveyElement['id'] == $a['question_id']): ?>
                        <?php $text .= ($n == 0) ? ($a['answer'] ?? '') :  ' - ' .  ($a['answer'] ?? '') ?>
                    <?php endif; ?>
                <?php $n++; endforeach; ?>
                <div class="comment-item-box">
                    <?php echo $text; ?>
                </div>
            <?php  endforeach; ?>

        </div>
    </div>
</section>