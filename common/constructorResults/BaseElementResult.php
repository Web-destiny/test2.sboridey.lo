<?php

namespace common\constructorResults;

use common\models\SurveyElement;
use Yii;
use yii\base\BaseObject;
use yii\helpers\ArrayHelper;

abstract class BaseElementResult extends BaseObject
{
    public const VIEW_PATH = '@common/constructorResults/view/';

    public int $surveyPassedCount = 0;
    public int $surveyId;
    public int $order;
    /**
     * @var array|SurveyElement[]
     */
    public array $surveyElements;
    public array $details;

    abstract public function calculate();
    abstract protected function getElementHTML(array $params = []) : string;

    public function renderData() : array
    {
        $key = 0;
        return ArrayHelper::getColumn($this->surveyElements, function ($surveyElement) use (&$key) {
            return [
                'order' => $surveyElement->element_order,
                'key' => ++$key,
                'html' => $this->getElementHTML(['key' => $key - 1, 'surveyElement' => $surveyElement]),
            ];
        });
    }
}