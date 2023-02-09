<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "monthly_income_per_member".
 *
 * @property int $id
 * @property string|null $alias
 * @property int|null $size1
 * @property int|null $size2
 */
class MonthlyIncomePerMember extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'monthly_income_per_member';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['size1', 'size2'], 'integer'],
            [['alias'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'alias' => 'Alias',
            'size1' => 'Size1',
            'size2' => 'Size2',
        ];
    }
}
