<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "elements".
 *
 * @property int|null $id
 * @property string|null $element_id
 * @property string|null $key
 * @property string|null $value
 * @property int|null $order
 * @property string|null $extra
 */
class Elements extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'elements';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'order', 'element_id'], 'integer'],
            [['key', 'value', 'extra'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'key' => 'Key',
            'value' => 'Value',
            'order' => 'Order',
            'extra' => 'Extra',
            'element_id' => 'ElementId',
        ];
    }
}
