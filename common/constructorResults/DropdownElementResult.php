<?php

namespace common\constructorResults;

use Yii;
use yii\helpers\ArrayHelper;

class DropdownElementResult extends BaseElementResult
{
    public function calculate()
    {
        ArrayHelper::getColumn($this->details, function (array $data) {
            $this->details[$data['question_id']][] = ArrayHelper::merge($data, [
                'percent_passed' => number_format(($data['answer_count'] / $this->surveyPassedCount) * 100, 2)
            ]);
        });
    }

    public function getElementHTML(array $params = []): string
    {
        return Yii::$app->view->render(self::VIEW_PATH . 'dropdown', ArrayHelper::merge($params, [
            'order' => $this->order,
            'surveyPassedCount' => $this->surveyPassedCount,
            'details' => $this->details,
        ]));
    }
}