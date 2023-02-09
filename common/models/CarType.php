<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "car_type".
 *
 * @property int $id_car_type
 * @property string $name
 */
class CarType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'car_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_car_type' => 'Id Car Type',
            'name' => 'Name',
        ];
    }
}
