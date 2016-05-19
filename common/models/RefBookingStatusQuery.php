<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[RefBookingStatus]].
 *
 * @see RefBookingStatus
 */
class RefBookingStatusQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return RefBookingStatus[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return RefBookingStatus|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
