<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[ScreeningForm]].
 *
 * @see ScreeningForm
 */
class ScreeningFormQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return ScreeningForm[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ScreeningForm|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
