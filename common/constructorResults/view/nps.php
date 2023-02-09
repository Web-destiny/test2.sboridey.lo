<?php
/**
 * @var \yii\web\View $this
 * @var int $surveyPassedCount
 * @var int $order
 * @var array $questions
 * @var \common\models\SurveyElement $surveyElement
 */

use yii\helpers\ArrayHelper;

?>

<section class="nps-results-section box-wrapper nps-row">
    <p class="question-type-details">
        <span class="question-type">NPS</span>
        <span class="question-count">
                <?= $surveyElement->answersCountSum; ?> ответов
            </span>
    </p>
    <p class="question-txt-block"><span class="question-number"><?= $order; ?>/<?= $key + 1; ?></span> <span class="question-txt"><?= $surveyElement->question; ?></span>
    </p>
    <div class="main-nps">
        <div>
            <table class="block-table table-striped" id="faceectable">
                <tbody>
                <tr>
                    <td class="cntr_num" colspan="7">
                        DETRACTORS
                    </td>
                    <td class="cntr_num" colspan="2">
                        PASSIVES
                    </td>
                    <td class="cntr_num" colspan="2">
                        PROMOTERS
                    </td>
                </tr>
                <tr>
                    <td class="cntr_num" colspan="7">
                        <div class="planka-long"></div>
                    </td>
                    <td class="cntr_num" colspan="2">
                        <div class="planka-long"></div>
                    </td>
                    <td class="cntr_num" colspan="2">
                        <div class="planka-long"></div>
                    </td>
                </tr>
                <tr class="rate-th">
                    <?php for ($i = 0; $i <= 10; $i++): ?>
                        <td>
                            <div class="rate-item"><?= $i; ?></div>
                        </td>
                    <?php endfor; ?>
                </tr>
                <tr class="dig-td">
                    <?php for ($i = 0; $i <= 10; $i++): ?>
                        <td>
                            <p class="sum-bot"><?= ArrayHelper::getValue($surveyElement->answersCountArr, $i, 0); ?></p>
                        </td>
                    <?php endfor; ?>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="left-block">
            <div class="promot-wrap">
                <div class="label-promot">
                    <div class="table-txt11-sp"><?= $key = array_key_first($surveyElement->statistics['promoters']); ?></div>
                    <div class="table-txt12-sp">Promoters</div>
                    <div class="table-txt13-sp"><?= $a = ($surveyElement->statistics['promoters'][$key] ?? 0) ?>%</div>
                </div>
                <div class="label-promot">
                    <div class="table-txt11-sp"><?= $key = array_key_first($surveyElement->statistics['passives']); ?></div>
                    <div class="table-txt12-sp">Passives</div>
                    <div class="table-txt13-sp"><?= $surveyElement->statistics['passives'][$key] ?? 0 ?>%</div>
                </div>
                <div class="label-promot">
                    <div class="table-txt11-sp"><?= $key = array_key_first($surveyElement->statistics['detractors']); ?></div>
                    <div class="table-txt12-sp">Detractors</div>
                    <div class="table-txt13-sp"><?= $b = ($surveyElement->statistics['detractors'][$key] ?? 0) ?>%</div>
                </div>
            </div>
            <div class="block-circle">
                <div class="circle">
                    <span>Total</span>
                    <span><?= number_format($a - $b, 2); ?></span>
                </div>
            </div>
        </div>
    </div>
    <div class="comments-container w-100">
        <?php if($questions[$surveyElement->id]):  ?>

            <?php $json = json_decode($surveyElement->json_data, true); ?>
            <?php if(!empty($json['npsAction_' . $surveyElement->element_order])):  ?>
                <div class="cpmments-header">
                    <span>Оценка</span>
                    <span>Комментарий</span>
                </div>

                <?php foreach ($questions[$surveyElement->id] ?? [] as $question):
                    if (empty($question['comment'])) continue;
                    ?>
                    <div class="comment-item-box">
                    <span class="comment-point">
                        <?= htmlspecialchars($question['answer']) ?>
                    </span>
                        <span class="comment-txt">
                        <?= htmlspecialchars($question['comment']) ?>
                    </span>
                    </div>
                <?php endforeach; ?>

            <?php endif; ?>
        <?php endif;  ?>

    </div>
</section>


