<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "answers".
 *
 * @property int $id
 * @property int|null $survey_id
 * @property string|null $type
 * @property int $question_id
 * @property int $position
 * @property string|null $answer
 * @property string|null $comment
 * @property string|null $unique
 * @property string|null $session_token
 * @property int|null $created_at
 * @property int|string $param1
 * @property int|string $param2
 * @property int|string $param3
 */
class Answers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'answers';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['survey_id', 'question_id', 'type', 'answer'], 'required'],
            [['survey_id', 'question_id', 'position', 'created_at'], 'integer'],
            [['type'], 'string', 'max' => 60],
            [['comment', 'param1', 'param2', 'param3'], 'string'],
            [['answer', 'comment', 'unique', 'session_token'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'survey_id' => 'Идентификатор опроса',
            'unique' => 'Уникальный ключ',
            'type' => 'Type',
            'question_id' => 'Вопрос',
            'question' => 'Вопрос',
            'answer' => 'Ответ',
            'comment' => 'Комментарий',
            'created_at' => 'Дата',
            'param1' => 'Параметр 1',
            'param2' => 'Параметр 2',
            'param3' => 'Параметр 3',
        ];
    }

    public function getParam1()
    {
        return $this->hasOne(CementLocation::class, ['id' => 'param1']);
    }

    public function getParam2()
    {
        return $this->hasOne(CementDepartment::class, ['id' => 'param2']);
    }

    public function getParam3()
    {
        return $this->hasOne(CementSupervisor::class, ['id' => 'param3']);
    }

    public static function sortDataByUniqueKey($array, $questionData, $appendExcelInfo = false) : array
    {
        $questions = array_keys($questionData);

        $data = $headerData = $widths = [];

        $newArray = [];
        foreach ($array as $item) {
            $newArray[$item['session_token']][] = $item;
        }

        $surveyId = $array[0]['survey_id'] ?? null;

        foreach ($newArray as $items) {
            foreach ($items as $n => $item) {
                $item['question'] = trim(preg_replace('/^[\d+]./', '', $item['question']));
                $data[$item['session_token']][$item['question']][] = $item['answer'];
                $data[$item['session_token']]['date'][] = date('Y-m-d H:i:00', $item['created_at']);

                if (ArrayHelper::isIn($surveyId, [165, 170, 171, 174])) {
                    $data[$item['session_token']]['param1'][] = $item['param1']['name'] ?? '';
                    $data[$item['session_token']]['param2'][] = $item['param2']['name'] ?? '';
                    $data[$item['session_token']]['param3'][] = $item['param3']['name'] ?? '';
                }

                $data[$item['session_token']][$item['question'] . '-comment'][] = $item['comment'];
            }
        }

        $key = 0;
        foreach ($data as &$_items) {
            $n = $i = 0;
            foreach ($_items as $question => &$item) {
                $item = implode(', ', array_unique($item, SORT_REGULAR));
                $n++;
            }

            $key++;
        }

        $data = array_values($data);

        $newData = [];

        $i = 0;
        
        array_map(function ($items) use (&$newData, $data, &$i, $questions, $questionData, $surveyId) {
            array_filter($questions, function ($question) use ($i, $data, $questionData, $items, &$newData, $surveyId) {
                $addCommentOption = strtolower($questionData[$question]->addComment ?? '');

                $newData[$i]['Дата и время'] = $data[$i]['date'] ?? '';

                if (ArrayHelper::isIn($surveyId, [165, 170, 171, 174])) {
                    $newData[$i]['Город'] = $data[$i]['param1'] ?? '';
                    $newData[$i]['Подразделение'] = $data[$i]['param2'] ?? '';
                    $newData[$i]['ФИО руководителя'] = $data[$i]['param3'] ?? '';
                }

                $newData[$i][$question] = ArrayHelper::getValue($items, $question, '');

                if ($addCommentOption === 'on') {
                    $newData[$i][$question . '-comment'] = $data[$i][$question . '-comment'] ?? '';
                }
            });

            $i++;
        }, $data);

        $data = $newData;

        $i = 0;

        foreach ($questions as $n => $question) {
            $addCommentOption = strtolower($questionData[$question]->addComment ?? '');

            $widths[] = 50;

            $headerData['Дата и время'] = 'string';

            if (ArrayHelper::isIn($surveyId, [165, 170, 171, 174])) {
                $headerData['Город'] = 'string';
                $headerData['Подразделение'] = 'string';
                $headerData['ФИО руководителя'] = 'string';
            }

            $headerData[$question] = 'string';

            if ($addCommentOption === 'on') {
                $headerData['Comment ' . ($i + 1)] = 'string';

                $i++;
            }
        }

        return $appendExcelInfo ? [
            'array' => $data,
            'Sheet1Header' => $headerData,
            'widths' => $widths,
        ] : $data;
    }
}
