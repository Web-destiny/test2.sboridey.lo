<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "car_mark".
 *
 * @property int $id_car_mark ID
 * @property string $name
 * @property int|null $date_create
 * @property int|null $date_update
 * @property int $id_car_type
 * @property string|null $name_rus
 */
class CarMark extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'car_mark';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'id_car_type'], 'required'],
            [['date_create', 'date_update', 'id_car_type'], 'integer'],
            [['name', 'name_rus'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_car_mark' => 'Id Car Mark',
            'name' => 'Name',
            'date_create' => 'Date Create',
            'date_update' => 'Date Update',
            'id_car_type' => 'Id Car Type',
            'name_rus' => 'Name Rus',
        ];
    }
}
