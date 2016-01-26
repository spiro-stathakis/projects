<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[ScreeningResponse]].
 *
 * @see ScreeningResponse
 */
class ScreeningResponseQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return ScreeningResponse[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ScreeningResponse|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
