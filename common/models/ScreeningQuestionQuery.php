<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[ScreeningQuestion]].
 *
 * @see ScreeningQuestion
 */
class ScreeningQuestionQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return ScreeningQuestion[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ScreeningQuestion|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
