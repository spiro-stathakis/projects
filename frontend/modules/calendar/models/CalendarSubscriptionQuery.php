<?php

namespace frontend\modules\calendar\models;

/**
 * This is the ActiveQuery class for [[CalendarSubscription]].
 *
 * @see CalendarSubscription
 */
class CalendarSubscriptionQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return CalendarSubscription[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return CalendarSubscription|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
