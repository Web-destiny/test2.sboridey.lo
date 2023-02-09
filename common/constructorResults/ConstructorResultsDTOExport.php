<?php

namespace common\constructorResults;

use common\models\Answers;
use common\models\SurveyElement;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

class ConstructorResultsDTOExport
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
     * @var array $questions
     */
    public array $questions = [];

    /**
     * @var array $questionData
     */
    public array $questionData = [];

    public function __construct(int $id)
    {
        $this->id = $id;

        $surveyElementTbl = SurveyElement::tableName();

        $answerQuery = Answers::find()
            ->select([
                Answers::tableName() . '.*',
                'question' => SurveyElement::tableName() . '.question',
            ])
            ->innerJoin(SurveyElement::tableName(), SurveyElement::tableName() . '.id=' . Answers::tableName() . '.question_id')
            ->where([Answers::tableName() . '.survey_id' => $this->id])
            ->orderBy([Answers::tableName() . '.id' => SORT_DESC]);

        $this->answers = (clone $answerQuery)
            ->with(['param1', 'param2', 'param3'])
            ->andWhere([SurveyElement::tableName() . '.deleted_at' => null])
            ->asArray()
            ->all();

        $deletedAnswers = (clone $answerQuery)
            ->andWhere(['IS NOT', "$surveyElementTbl.deleted_at", null])
            ->asArray()
            ->all();

        $this->answers = array_merge($this->answers, $deletedAnswers);

        $tquestions = SurveyElement::find()
            ->select(['question', 'json_data'])
            ->orderBy([new Expression("if($surveyElementTbl.deleted_at is null, $surveyElementTbl.element_order, $surveyElementTbl.element_order + 100000) ASC")])
            ->where([SurveyElement::tableName() . '.survey_id' => $this->id])
            ->asArray()
            ->modelAll();

        $this->questions = ArrayHelper::getColumn($tquestions, function ($item) {
            return trim(preg_replace('/^[\d+]./', '', $item['question']));
        });

        $this->questionData = array_map('json_decode', ArrayHelper::getColumn($tquestions, 'json_data'));

        $this->questionData = array_combine($this->questions, $this->questionData);
    }
}