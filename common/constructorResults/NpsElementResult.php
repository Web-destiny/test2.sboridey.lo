<?php

namespace common\constructorResults;

use Yii;
use yii\helpers\ArrayHelper;

class NpsElementResult extends BaseElementResult
{
    protected array $questions = [];

    public function calculate() : void
    {
        ArrayHelper::getColumn($this->details, function (array $data) {
            $this->questions[$data['question_id']][] = $data;
        });

        $this->surveyElements = ArrayHelper::getColumn(ArrayHelper::toArray($this->surveyElements), function ($data) {
            $data['npsList'] = $this->questions[$data['id']] ?? [];
            $data['answersCountArr'] = ArrayHelper::map($data['npsList'], 'answer', 'answer_count');
            $data['answersCountSum'] = array_sum(array_column($data['npsList'], 'answer_count'));

            $percentages = ['detractors' => [], 'passives' => [], 'promoters' => []];
            foreach ($data['answersCountArr'] as $answer => $answerCount) {
                if ($answer <= 6) {
                    $percentages['detractors'][$answer] = $answerCount;
                } elseif ($answer >= 7 && $answer <= 8) {
                    $percentages['passives'][$answer] = $answerCount;
                } elseif ($answer >= 9 && $answer <= 10) {
                    $percentages['promoters'][$answer] = $answerCount;
                }
            }

            $detractorsCount = array_sum(array_values($percentages['detractors']));
            $passivesCount = array_sum(array_values($percentages['passives']));
            $promotersCount = array_sum(array_values($percentages['promoters']));

            if (!empty($percentages['detractors'])) {
                $percentages['detractors'] = 100 * (
                        // $detractorsCount / (array_sum(array_keys($percentages['detractors'])) ?: 1)
                        $detractorsCount / $this->surveyPassedCount
                    );
            } else {
                $percentages['detractors'] = 0;
            }

            if (!empty($percentages['passives'])) {
                $percentages['passives'] = 100 * (
                        // $passivesCount / (array_sum(array_keys($percentages['passives'])) ?: 1)
                        $passivesCount / $this->surveyPassedCount
                    );
            } else {
                $percentages['passives'] = 0;
            }

            if (!empty($percentages['promoters'])) {
                $percentages['promoters'] = 100 * (
                        // $promotersCount / (array_sum(array_keys($percentages['promoters'])) ?: 1)
                        $promotersCount / $this->surveyPassedCount
                    );
            } else {
                $percentages['promoters'] = 0;
            }

            $data['statistics'] = [
                'detractors' => [$detractorsCount => number_format($percentages['detractors'], 2)],
                'passives' => [$passivesCount => number_format($percentages['passives'], 2)],
                'promoters' => [$promotersCount => number_format($percentages['promoters'], 2)],
            ];

            return (object) $data;
        });
    }

    protected function getElementHTML(array $params = []): string
    {
        return Yii::$app->view->render(self::VIEW_PATH . 'nps', ArrayHelper::merge($params, [
            'order' => $this->order,
            'surveyPassedCount' => $this->surveyPassedCount,
            'questions' => $this->questions,
            'details' => $this->details
        ]));
    }
}