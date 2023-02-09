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
            <?php foreach ($details as $detail):  ?>
                <?php if($surveyElement['id'] == $detail['question_id']): ?>
                    <div class="comment-item-box">
                        <?php echo $detail['answer'] ?? ''; ?>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>