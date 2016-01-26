<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[ScreeningFormResponse]].
 *
 * @see ScreeningFormResponse
 */
class ScreeningResponseEntryQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return ScreeningFormResponse[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ScreeningFormResponse|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
