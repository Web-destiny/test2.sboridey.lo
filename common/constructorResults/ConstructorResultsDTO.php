<?php

namespace common\constructorResults;

use common\models\Answers;
use common\models\SurveyElement;
use Yii;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;

class ConstructorResultsDTO
{
    /**
     * @var int $id
     */
    public int $id;
    /**
     * @var array|Answers[] $answers
     */
    public array $answers = [];
    /**
     * @var array|SurveyElement[] $surveyElements
     */
    public array $surveyElements = [];
    /**
     * @var array|BaseElementResult[]
     */
    public array $factories = [];

    /**
     * ConstructorResultsDTO constructor.
     * @param int $id
     * @param array $types
     * @param array $options
     */
    public function __construct(int $id, array $types, array $options = [])
    {
        $this->id = $id;

        $order = 0;

        ArrayHelper::getColumn($types, function (string $type) use (&$order, $options) {
            $order++;

            $surveyPassedQuery = Answers::find();

            if (!empty($options['param1'])) {
                $surveyPassedQuery->andWhere(['param1' => $options['param1']]);
            }

            if (!empty($options['param2'])) {
                $surveyPassedQuery->andWhere(['param2' => $options['param2']]);
            }

            if (!empty($options['param3'])) {
                $surveyPassedQuery->andWhere(['param3' => $options['param3']]);
            }

            $surveyPassedCount = (clone $surveyPassedQuery)
                ->andWhere(['survey_id' => $this->id, 'type' => $type])
                ->select('session_token')
                ->distinct()
                ->count();

            $query = (clone $surveyPassedQuery)
                ->select([
                    Answers::tableName() . '.*',
                    'question' => SurveyElement::tableName() . '.question',
                ])
                ->innerJoin(SurveyElement::tableName(), SurveyElement::tableName() . '.id=' . Answers::tableName() . '.question_id')
                ->andWhere([Answers::tableName() . '.survey_id' => $this->id, Answers::tableName(). '.type' => $type])
                ->orderBy([Answers::tableName() . '.id' => SORT_DESC]);

            $this->additionalQueries($query, $type);

            $answers = $query->asArray()->all();

            $surveyElements = SurveyElement::find()
                ->where(['survey_id' => $this->id, 'type' => $type])
                ->orderBy(['element_order' => SORT_ASC])
                ->all();

            $this->answers = ArrayHelper::merge($this->answers, $answers);
            $this->surveyElements = ArrayHelper::merge($this->surveyElements, $surveyElements);

            if ($surveyElements && $answers) {
                $factory = ConstructorResultsFactory::instance()->make($type, [
                    'surveyId' => $this->id,
                    'order' => $order,
                    'surveyPassedCount' => $surveyPassedCount,
                    'details' => $answers,
                    'surveyElements' => $surveyElements,
                ]);

                $this->factories[$type] = $factory;
            }

            return true;
        });
    }

    protected function additionalQueries(ActiveQuery $query, string $type) : void
    {
        if (method_exists($this, $method = Inflector::camel2id($type) . 'Query')) {
            $this->$method($query);
        } else {
            $query
                ->addSelect([
                    'answer_count' => 'COUNT(' . Answers::tableName() . '.answer)',
                ])
                ->groupBy([Answers::tableName() . '.question_id', Answers::tableName() . '.answer']);
        }
    }

    protected function scaleQuery(ActiveQuery $query)
    {
        // todo we do not need to group items for scale
    }

    protected function singleQuery(ActiveQuery $query) : void
    {
        $query
            ->addSelect([
                'answer_count' => 'COUNT(' . Answers::tableName() . '.answer)',
            ])
            ->groupBy([Answers::tableName() . '.question_id', Answers::tableName() . '.answer', Answers::tableName() . '.position']);
    }

    protected function npsQuery(ActiveQuery $query) : void
    {
        $answersTable = Answers::tableName();

        $query
            ->addSelect([
                'answer_count' => 'COUNT(' . Answers::tableName() . '.answer)',
                'nps_activity_type_detractors' => "IF($answersTable.answer <= 6, 1, 0)",
                'nps_activity_type_passives' => "IF($answersTable.answer >= 7 and $answersTable.answer <= 8, 1, 0)",
                'nps_activity_type_promoters' => "IF($answersTable.answer >= 9 and $answersTable.answer <= 10, 1, 0)",
            ])
            ->having(['>', 'answer_count', 0])
            ->groupBy([Answers::tableName() . '.question_id', Answers::tableName() . '.answer']);
    }
}