<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%survey_razdel}}".
 *
 * @property int $id
 * @property int|null $razdel_id
 * @property int|null $survey_element_id
 *
 * @property Razdel $razdel
 * @property SurveyElement $surveyElement
 */
class SurveyRazdel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%survey_razdel}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['razdel_id', 'survey_element_id'], 'required'],
            [['razdel_id', 'survey_element_id'], 'integer'],
            [['razdel_id'], 'exist', 'skipOnError' => true, 'targetClass' => Razdel::className(), 'targetAttribute' => ['razdel_id' => 'id']],
            [['survey_element_id'], 'exist', 'skipOnError' => true, 'targetClass' => SurveyElement::className(), 'targetAttribute' => ['survey_element_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'razdel_id' => Yii::t('app', 'Razdel ID'),
            'survey_element_id' => Yii::t('app', 'Survey Element ID'),
        ];
    }

    /**
     * Gets query for [[Razdel]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRazdel()
    {
        return $this->hasOne(Razdel::className(), ['id' => 'razdel_id']);
    }

    /**
     * Gets query for [[SurveyElement]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSurveyElement()
    {
        return $this->hasOne(SurveyElement::className(), ['id' => 'survey_element_id']);
    }
}