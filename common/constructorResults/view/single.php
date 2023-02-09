<?php
/**
 * @var int $surveyPassedCount
 * @var int $order
 * @var array $questions
 * @var \common\models\SurveyElement $surveyElement
 */
?>

<section class="single-results-section box-wrapper">
    <p class="question-type-details">
        <span class="question-type">Выбор из списка</span>
        <span class="question-count">
            <?= $surveyPassedCount; ?> ответов
        </span>
    </p>

    <p class="question-txt-block"><span class="question-number"><?= $order; ?>/<?= $key + 1; ?></span> <span class="question-txt"><?php echo $surveyElement->question; ?></span>
    </p>
    <div class="chart-container">
        <div class="progress-chart-container">
            <?php if (empty($questions[$surveyElement->id])): ?>
                <div class="progress-wrapper">
                    <div class="progress-percentage-wrapper">
                        <div class="progress-question-wrapper">
                            <div class="progress-question">   </div>
                            <div class="progress-count">
                                <div class="percentage-count"><span>0</span>%</div>
                                <div class="count"><span>0</span> ответов</div>
                            </div>
                        </div>
                        <div class="progress-loader-grey">
                            <div class="progress-loader-color"></div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php foreach ($questions[$surveyElement->id] ?? [] as $question): ?>
                <div class="progress-wrapper">
                    <div class="progress-percentage-wrapper">
                        <div class="progress-question-wrapper">
                            <div class="progress-question"><?= $question['answer']; ?></div>
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
            <?php $array = []; ?>
            <?php foreach ($questions[$surveyElement->id] ?? [] as $question): ?>
                <?php  if(!in_array($question['session_token'], $array)): ?>
                    <?php $array[] = $question['session_token'];  ?>
                    <div class="comment-item-box">
                        <?= $question['comment'] ?: '<i>-- Без комментариев --</i>'; ?>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>