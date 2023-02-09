<?php


namespace common\services\softdelete;


use yii\db\Expression;

/**
 * Trait SoftDelete
 * @package common\services\softdelete
 */
trait SoftDelete
{
    /**
     * {@inheritdoc}
     * @return SoftDeleteQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SoftDeleteQuery(get_called_class());
    }

    /**
     * {@inheritdoc}
     * @return mixed
     */
    public function delete()
    {
        $this->deleted_at = new Expression('NOW()');

        return $this->save();
    }

    /**
     * {@inheritdoc}
     * @param null $condition
     * @param array $params
     * @return int
     */
    public static function deleteAll($condition = null, $params = [])
    {
        return self::updateAll(['deleted_at' => new Expression('NOW()')], $condition);
    }

    /**
     * @param array $condition
     * @return mixed
     */
    public function forceDelete($condition = [])
    {
        return parent::deleteAll($condition ?: ['id' => $this->id]);
    }
}