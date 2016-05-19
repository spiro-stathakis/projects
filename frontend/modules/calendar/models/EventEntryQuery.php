<?php

namespace frontend\modules\calendar\models;

/**
 * This is the ActiveQuery class for [[EventEntry]].
 *
 * @see EventEntry
 */
class EventEntryQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return EventEntry[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return EventEntry|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
