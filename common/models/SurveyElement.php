<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "survey_element".
 *
 * @property int $id
 * @property int|null $survey_id
 * @property int|null $published
 * @property string|null $type
 * @property int|null $element_order
 * @property string|null $question
 * @property string|null $file
 * @property string|null $unique_key
 * @property string|null $json_data
 *
 * @property SurveyRazdel|null $surveyRazdel
 */
class SurveyElement extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'survey_element';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['survey_id', 'element_order', 'published'],  'integer'],
            [['type'], 'string', 'max' => 50],
            [['json_data'], 'string'],
            [['question', 'file', 'unique_key'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'survey_id' => \Yii::t('app', 'Survey ID'),
            'razdel' => \Yii::t('app', 'Раздел'),
            'type' => \Yii::t('app', 'Type'),
            'element_order' => \Yii::t('app', 'Порядок элементов'),
            'question' => \Yii::t('app', 'Question'),
            'file' => \Yii::t('app', 'File'),
            'unique_key' => \Yii::t('app', 'Unique Key'),
            'published' => \Yii::t('app', 'Published'),
        ];
    }

    public static function getCountOfQuestions($surveys)
    {
        $data = [];

        foreach ($surveys as $survey) {
            $count = self::find()->where(['survey_id' => $survey->id])->count();
            $data[$survey->id] = $count;
        }

        return $data;
    }

    /**
     * Gets query for [[SurveyRazdel]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSurveyRazdel()
    {
        return $this->hasOne(SurveyRazdel::className(), ['survey_element_id' => 'id'])->innerJoinWith(['razdel']);
    }

}
