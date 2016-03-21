<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[UserCollection]].
 *
 * @see UserCollection
 */
class UserCollectionQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return UserCollection[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return UserCollection|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
