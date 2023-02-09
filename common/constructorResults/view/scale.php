<?php
/**
 * @var \yii\web\View $this
 * @var int $surveyPassedCount
 * @var int $order
 * @var array $questions
 * @var array $results
 * @var \common\models\SurveyElement] $surveyElement
 */

use yii\helpers\ArrayHelper;

?>

<section class="scale-results-section box-wrapper">
    <p class="question-type-details">
        <span class="question-count"><?= $surveyPassedCount; ?> ответов</span>
    </p>
    <p class="question-txt-block"><span class="question-number"><?= $order; ?>/<?= $key + 1; ?></span> <span class="question-txt"><?php echo $surveyElement->question; ?></span>
    </p>
    <div class="scale-graf-container">
        <div class="scale-barChart-container">
            <div class="canvas-bar-chartBox">
                <canvas class="scale-barChart"></canvas>
            </div>
        </div>
        <div class="barChart-progress-box">
            <div class="barChart-progress-line-bg">
                <div class="barChart-progress-colored" data-progress="70">
                    <span class="progress-average-point"><?= ArrayHelper::getValue($results, $key, 0); ?></span>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
if ($key === 0) {
    $this->registerJs(<<<JS
    let data = $chartData;
JS, \yii\web\View::POS_BEGIN);
}

?>