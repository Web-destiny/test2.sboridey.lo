<?php

namespace common\models\forms;

use common\models\Answers;
use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class SurveyForm extends Model
{
    /**
     * @var string $unique
     */
    public $unique;
    /**
     * @var string $answers
     */
    public $answer;
    /**
     * @var string $question
     */
    public $question;
    /**
     * @var string $comment
     */
    public $comment;
    /**
     * @var string $comment
     */

    public $param1;
    /**
     * @var string $param1
     */

    public $param2;
    /**
     * @var string $param2
     */

    public $param3;
    /**
     * @var string $param3
     */

    public $type;

    public function rules() : array
    {
        return [
            [['answer', 'question', 'type', 'unique'], 'required'],
            [['answer', 'question', 'comment', 'type', 'unique', 'param1', 'param2', 'param3'], 'string'],
        ];
    }

    public function saveSurvey(string $unique, array $data, array $elementNames)
    {
        $token = Yii::$app->security->generateRandomString();

        foreach (array_unique($elementNames) as $elementName) {
            if (!empty($answersData = ArrayHelper::getValue($data, $elementName, [])) && is_array($answersData) && is_string($elementName)) {
                (new self())->save([
                    'unique' => $unique,
                    'type' => $elementName,
                    'token' => $token,
                    'data' => $answersData,
                    'questions' => ArrayHelper::getValue($data, "$elementName-question", []),
                    'comments' => ArrayHelper::getValue($data, "$elementName-comment", []),
                    'param1' => Yii::$app->request->post('param1', ''),
                    'param2' => Yii::$app->request->post('param2', ''),
                    'param3' => Yii::$app->request->post('param3', ''),
                ]);
            }
        }
        return true;
    }

    public function save(array $attributes)
    {
        $emptyData = empty($attributes['data']) || !is_array($attributes['data']);
        $emptyQuestions = empty($attributes['questions']) || !is_array($attributes['questions']);

        if (!isset($attributes['comments']) && (empty($attributes['comments']) || !is_array($attributes['comments']))) {
            return false;
        }

        if ($emptyData || $emptyQuestions) {
            return false;
        }

        foreach ($attributes['data'] as $key => $answers) {
            foreach ($answers as $position => $answer) {
                $transaction = Yii::$app->db->beginTransaction();

                $question = ArrayHelper::getValue($attributes, "questions.$key");
                $comment = ArrayHelper::getValue($attributes, "comments.$key");

                ($form = new self())->setAttributes([
                    'answer' => $answer,
                    'question' => $question,
                    'comment' => $comment ?: null,
                    'type' => ArrayHelper::getValue($attributes, 'type'),
                    'unique' => ArrayHelper::getValue($attributes, 'unique'),
                ]);

                if (!$form->validate()) {
                    $transaction->rollBack();

                    continue;
                }

                $this->answerModelFilled(ArrayHelper::getValue($attributes, 'token'), ArrayHelper::merge($form->attributes, [
                    'type' => $form->type,
                    'unique' => $form->unique,
                    'question_id' => $form->question,
                    'position' => $position,
                ]))->save();

                $transaction->commit();
            }
        }

        return true;
    }

    public function answerModelFilled(string $token, array $data, bool $validated = false) : Answers
    {
        ($answersModel = new Answers())->setAttributes([
            'survey_id' => Yii::$app->request->post('survey_id'),
            'type' => ArrayHelper::getValue($data, 'type', $this->type),
            'unique' => ArrayHelper::getValue($data, 'unique'),
            'session_token' => $token,
            'question_id' => ArrayHelper::getValue($data, 'question_id'),
            'position' => ArrayHelper::getValue($data, 'position'),
            'answer' => ArrayHelper::getValue($data, 'answer', $this->answer),
            'comment' => ArrayHelper::getValue($data, 'comment', $this->comment),
            'param1' => Yii::$app->request->post('param1', ''),
            'param2' => Yii::$app->request->post('param2', ''),
            'param3' => Yii::$app->request->post('param3', ''),
        ]);

        if ($validated) {
            $answersModel->validate();
        }

        return $answersModel;
    }
}