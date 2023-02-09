<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "car_model".
 *
 * @property int $id_car_model ID
 * @property int $id_car_mark
 * @property string $name
 * @property int|null $date_create
 * @property int|null $date_update
 * @property int $id_car_type
 * @property string|null $name_rus
 */
class CarModel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'car_model';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_car_mark', 'name', 'id_car_type'], 'required'],
            [['id_car_mark', 'date_create', 'date_update', 'id_car_type'], 'integer'],
            [['name', 'name_rus'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_car_model' => 'Id Car Model',
            'id_car_mark' => 'Id Car Mark',
            'name' => 'Name',
            'date_create' => 'Date Create',
            'date_update' => 'Date Update',
            'id_car_type' => 'Id Car Type',
            'name_rus' => 'Name Rus',
        ];
    }
}
