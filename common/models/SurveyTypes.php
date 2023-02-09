<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "survey_types".
 *
 * @property int|null $id
 * @property string|null $alias
 * @property string|null $title
 */
class SurveyTypes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'survey_types';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['title', 'alias'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'alias' => 'Алиас',
        ];
    }
}
