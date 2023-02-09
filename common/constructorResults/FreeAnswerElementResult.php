<?php

namespace common\constructorResults;

use Yii;
use yii\helpers\ArrayHelper;

class FreeAnswerElementResult extends BaseElementResult
{
    public function calculate()
    {
        //
    }

    public function getElementHTML(array $params = []): string
    {
        return Yii::$app->view->render(self::VIEW_PATH . 'free-answer', ArrayHelper::merge($params, [
            'order' => $this->order,
            'surveyPassedCount' => $this->surveyPassedCount,
            'details' => $this->details,
        ]));
    }
}