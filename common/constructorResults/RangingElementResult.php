<?php

namespace common\constructorResults;

use common\constructor\Constructor;
use common\models\Answers;
use Yii;
use yii\helpers\ArrayHelper;

class RangingElementResult extends BaseElementResult
{
    protected array $data = [];

    public function calculate()
    {
        $this->data = [];
        foreach ($this->details as $detail) {
            $data = Answers::find()
                ->select([
                    'position',
                    'count' => 'COUNT(position)',
                    'percent' => '100 * (COUNT(position) / ' . $this->surveyPassedCount . ')',
                ])
                ->where(['answer' => $detail['answer'], 'survey_id' => $this->surveyId, 'type' => Constructor::RANGING])
                ->groupBy(['position'])
                ->orderBy(['percent' => SORT_DESC])
                ->asArray()
                ->one();

            $this->data[$detail['answer']] = $data['percent'];
        }

        krsort($this->data);
    }

    public function getElementHTML(array $params = []): string
    {
        return Yii::$app->view->render(self::VIEW_PATH . 'ranging', ArrayHelper::merge($params, [
            'order' => $this->order,
            'data' => $this->data,
            'surveyPassedCount' => $this->surveyPassedCount,
            'details' => $this->details,
        ]));
    }
}