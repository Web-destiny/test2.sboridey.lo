<?php


namespace common\services\softdelete;

/**
 * Interface SoftDeleteInterface
 * @package common\services
 */
interface SoftDeleteInterface
{
    public function withNotTrashed();

    public function withTrashed();

    public function softDelete();

    public function revertDeleted();

    public function modelAll($db = null);

    public function modelOne($db = null);
}