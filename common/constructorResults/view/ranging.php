<?php
/**
 * @var int $surveyPassedCount
 * @var int $order
 * @var array $details
 * @var array $data
 * @var \common\models\SurveyElement[] $surveyElement
 */
//dd($data);
use yii\helpers\ArrayHelper; ?>

<section class="ranging-results-section box-wrapper">
    <p class="question-type-details">
        <span class="question-type">Ранжирование</span>
        <span class="question-count"><?= $surveyPassedCount; ?> ответов</span>
    </p>
    <p class="question-txt-block"><span class="question-number"><?= $order; ?>/<?= $key + 1; ?></span> <span class="question-txt"><?php echo $surveyElement->question; ?></span>
    <div class="renging-results-overwrap">
        <div class="ranging-results-data-box">
            <?php foreach ($data as $question => $percent):  ?>
                <div class="ranging-item-box">
                    <div class="ranging-item-answer">
                        <?= $question; ?>
                    </div>
                    <div class="ranging-item-percentage">
                        <div class="progress-percentage-wrapper">
                            <div class="progress-loader-grey">
                                <div class="progress-loader-color">
                                            <span class="ranging-percentage-box"><span
                                                        class="ranging-percentage-value"><?=  number_format($percent, 2); ?></span>%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>