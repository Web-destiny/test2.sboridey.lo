<?php

namespace common\constructorResults;

use Yii;
use yii\helpers\ArrayHelper;

class DateElementResult extends BaseElementResult
{
    public function calculate()
    {
        //
    }

    public function getElementHTML(array $params = []): string
    {
        $answers = [];
        foreach ($this->details as $detail) {
            if(isset($detail['session_token'])) {
                $answers[$detail['session_token']][]= $detail;
            }
        }
//        dd($answers);
        return Yii::$app->view->render(self::VIEW_PATH . 'date', ArrayHelper::merge($params, [
            'order' => $this->order,
            'surveyPassedCount' => $this->surveyPassedCount,
            'details' => $this->details,
            'answers' => $answers,
        ]));
    }
}