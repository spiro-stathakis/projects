<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[ScreeningFormAnswers]].
 *
 * @see ScreeningFormAnswers
 */
class ScreeningFormAnswersQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return ScreeningFormAnswers[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ScreeningFormAnswers|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
