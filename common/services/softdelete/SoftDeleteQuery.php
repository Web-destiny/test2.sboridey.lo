<?php


namespace common\services\softdelete;

use yii\db\Expression;

/**
 * This is the ActiveQuery class for [[CourseData]].
 *
 * @see CourseData
 */
class SoftDeleteQuery extends \yii\db\ActiveQuery implements SoftDeleteInterface
{
    /**
     * @var bool $withTrashedIsCalled false
     */
    protected $withTrashedIsCalled = false;

    /**
     * @return SoftDeleteQuery
     */
    public function withNotTrashed()
    {
        return $this->andWhere(['deleted_at' => null]);
    }

    /**
     * @return SoftDeleteQuery
     */
    public function withTrashed()
    {
        $this->withTrashedIsCalled = true;

        return $this->andWhere(['IS NOT', 'deleted_at', null]);
    }

    /**
     * @return bool
     */
    public function softDelete()
    {
        $model = $this->modelOne();
        $model->deleted_at = new Expression('NOW()');
        return $model->save();
    }

    /**
     * @return bool
     */
    public function revertDeleted()
    {
        $model = $this->modelOne();
        $model->deleted_at = null;
        return $model->save();
    }

    /**
     * @param null $db
     * @return array|\yii\db\ActiveRecord[]
     */
    public function all($db = null)
    {
        $this->withTrashedIsCalled === true ? $this->withTrashed() : $this->withNotTrashed();

        return parent::all($db);
    }

    /**
     * @param null $db
     * @return array|\yii\db\ActiveRecord[]
     */
    public function modelAll($db = null)
    {
        return parent::all($db);
    }

    /**
     * @param null $db
     * @return array|\yii\db\ActiveRecord|null
     */
    public function one($db = null)
    {
        $this->withTrashedIsCalled === true ? $this->withTrashed() : $this->withNotTrashed();

        return parent::one($db);
    }

    /**
     * @param null $db
     * @return array|\yii\db\ActiveRecord|null
     */
    public function modelOne($db = null)
    {
        return parent::one($db);
    }
}