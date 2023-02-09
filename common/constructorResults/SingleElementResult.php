<?php

namespace common\constructorResults;

use Yii;
use yii\helpers\ArrayHelper;

class SingleElementResult extends BaseElementResult
{
    protected array $questions = [];

    public function calculate()
    {
        ArrayHelper::getColumn($this->details, function (array $data) {
            $this->questions[$data['question_id']][] = ArrayHelper::merge($data, [
                'percent_passed' => number_format(($data['answer_count'] / $this->surveyPassedCount) * 100, 2)
            ]);
        });
    }

    public function getElementHTML(array $params = []): string
    {
        return Yii::$app->view->render(self::VIEW_PATH . 'single', ArrayHelper::merge($params, [
            'order' => $this->order,
            'surveyPassedCount' => $this->surveyPassedCount,
            'questions' => $this->questions,
        ]));
    }
}