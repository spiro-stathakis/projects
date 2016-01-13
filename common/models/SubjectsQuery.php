<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Subjects]].
 *
 * @see Subjects
 */
class SubjectsQuery extends \common\components\XActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Subjects[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Subjects|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}