<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[ScreeningFormQuestions]].
 *
 * @see ScreeningFormQuestions
 */
class ScreeningFormQuestionQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return ScreeningFormQuestions[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ScreeningFormQuestions|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
