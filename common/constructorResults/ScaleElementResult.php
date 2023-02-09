<?php

namespace common\constructorResults;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

class ScaleElementResult extends BaseElementResult
{
    public const CHART_BG_COLOR = ['#7FA1F8'];

    public array $chartData = [];

    public array $results = [];

    public function addChartData(array $labels, array $data)
    {
        $this->chartData[] = [
            'labels' => $labels,
            'datasets' => [
                [
                    'data' => $data,
                    'backgroundColor' => self::CHART_BG_COLOR,
                ],
            ],
        ];
    }

    public function addChartDataMultiple(array $labelsArr, array $dataArr) : void
    {
        foreach ($labelsArr as $key => $labels) {
            $this->addChartData($labels, $dataArr[$key]);
        }
    }

    public function calculateFinalResult(array $labelsArr, array $dataArr) : void
    {
        foreach ($dataArr as $key => $items) {
            $result = $number = 0;

            for ($i = 0; $i < count($items); $i++) {
                $number += $items[$i];
                $result += ($items[$i] * $labelsArr[$key][$i]);
            }

            $result = $number ? $result / $number : $result;

            $this->results[] = number_format($result, 2);
        }
    }

    public function calculate() : void
    {
        $dataArr = [];
        $labelsArr = [];

        $num = 0;

        ArrayHelper::getColumn($this->surveyElements, function ($element) use (&$items, &$labelsArr, &$dataArr, &$num) {
            $elementData = Json::decode($element['json_data']);
            $scaleAmount = $elementData['scaleAmount'];

            $labels = $chartData = [];
            for ($i = 1; $i <= $scaleAmount; $i++) {
                $labels[] = $i;
                $chartData[$i] = 0;
            }

            $labelsArr[$num] = $labels;
            $dataArr[$num] = $chartData;

            $items = array_filter($this->details, function ($data) use ($element) {
                return $data['question_id'] == $element['id'];
            });

            $items = ArrayHelper::map($items, 'id', 'answer');

            foreach ($items as $item) {
                $dataArr[$num][$item] += 1;
            }

            $dataArr[$num] = array_values($dataArr[$num]);

            $num++;
        });

        $this->addChartDataMultiple($labelsArr, $dataArr);
        $this->calculateFinalResult($labelsArr, $dataArr);
    }

    public function getElementHTML(array $params = []): string
    {
        return Yii::$app->view->render(self::VIEW_PATH . 'scale', ArrayHelper::merge($params, [
            'chartData' => Json::encode($this->chartData),
            'results' => $this->results,
            'order' => $this->order,
            'surveyPassedCount' => $this->surveyPassedCount,
            'details' => $this->details,
        ]));
    }
}