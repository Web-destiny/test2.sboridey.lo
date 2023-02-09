<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "survey_question".
 *
 * @property int $id
 * @property string $name
 * @property string $extra1
 */
class CementLocation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cement_location';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['id'], 'integer'],
            [['name'], 'string', 'min' => 1, 'max' => 255],
            [['extra1'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'extra1' => 'Дополнительный параметр 1',
        ];
    }

    public function getDepartment()
    {
        return $this->hasMany(CementDepartment::class, ['location_id' => 'id']);
    }

}
