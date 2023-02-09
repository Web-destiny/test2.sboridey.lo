<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%razdel}}".
 *
 * @property int $id
 * @property int|null $survey_id
 * @property int|null $number
 * @property string|null $title
 *
 * @property Survey $survey
 * @property SurveyRazdel[] $surveyRazdels
 */
class Razdel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%razdel}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['survey_id', 'number'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['survey_id'], 'exist', 'skipOnError' => true, 'targetClass' => Survey::className(), 'targetAttribute' => ['survey_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'survey_id' => Yii::t('app', 'Survey ID'),
            'number' => Yii::t('app', 'Number'),
            'title' => Yii::t('app', 'Title'),
        ];
    }

    /**
     * Gets query for [[Survey]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSurvey()
    {
        return $this->hasOne(Survey::className(), ['id' => 'survey_id']);
    }

    /**
     * Gets query for [[SurveyRazdels]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSurveyRazdels()
    {
        return $this->hasMany(SurveyRazdel::className(), ['razdel_id' => 'id']);
    }
}
