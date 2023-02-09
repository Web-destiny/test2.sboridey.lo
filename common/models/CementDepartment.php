<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "survey_question".
 *
 * @property int $id
 * @property string $name
 * @property int $location_id
 * @property string $extra1
 * @property string $param1
 */
class CementDepartment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cement_department';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'location_id'], 'required'],
            [['id', 'location_id'], 'integer'],
            [['extra1', 'param1'], 'string'],
            [['name'], 'string', 'min' => 1, 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'location_id' => 'ID местоположения',
            'name' => 'Название',
            'extra1' => 'Дополнтельный критерий 1',
            'param1' => 'Параметр 1',
        ];
    }

    public function getLocation()
    {
        return $this->hasOne(CementLocation::class, ['id' => 'location_id']);
    }

    public function getSupervisor()
    {
        return $this->hasMany(CementSupervisor::class, ['id' => 'department_id']);
    }

}
