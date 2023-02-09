<?php
/**
 * @var int $surveyPassedCount
 * @var int $order
 * @var array $details
 * @var \common\models\SurveyElement $surveyElement
 */
?>

<section class="dropdown box-wrapper">
    <p class="question-type-details">
        <span class="question-count"><?= $surveyPassedCount; ?> ответов</span>
    </p>
    <p class="question-txt-block"><span class="question-number"><?= $order; ?>/<?= $key + 1; ?></span> <span class="question-txt"><?= $surveyElement->question; ?></span></p>

    <div class="chart-container">
        <div class="progress-chart-container">
            <?php foreach ($details[$surveyElement->id] ?? [] as $question):  ?>
                <div class="progress-wrapper">
                    <div class="progress-percentage-wrapper">
                        <div class="progress-question-wrapper">
                            <div class="progress-question"><?php echo $question['answer'] ?? ''; ?></div>
                            <div class="progress-count">
                                <div class="percentage-count"><span><?= $question['percent_passed']; ?></span>%</div>
                                <div class="count"><span><?= $question['answer_count']; ?></span> ответов</div>
                            </div>
                        </div>
                        <div class="progress-loader-grey">
                            <div class="progress-loader-color"></div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="comments-container">
            <?php
            $array = [];
            foreach ($details[$surveyElement->id] ?? [] as $question):
                if(!in_array($question['session_token'], $array)) {
                    $array[] = $question['session_token'];
            ?>
                    <div class="comment-item-box">
                        <?php echo $question['comment'] ?: '<i>-- Без комментариев --</i>' ?>
                    </div>
            <?php } endforeach; ?>
        </div>
    </div>
</section>
