<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "survey_question".
 *
 * @property int $id
 * @property string $name
 * @property int $department_id
 * @property string $extra1
 * @property string $param1
 */
class CementSupervisor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cement_supervisor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'department_id'], 'required'],
            [['id', 'department_id'], 'integer'],
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
            'department_id' => 'ID подразделения',
            'name' => 'Название',
            'extra1' => 'Дополнтельный критерий 1',
            'param1' => 'Параметр 1',
        ];
    }

    public function getDepartment()
    {
        return $this->hasOne(CementDepartment::class, ['department_id' => 'id']);
    }

}
