<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[RefMemberType]].
 *
 * @see RefMemberType
 */
class RefMemberTypeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return RefMemberType[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return RefMemberType|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
