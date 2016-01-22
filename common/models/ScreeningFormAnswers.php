<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "screening_form_answers".
 *
 * @property integer $id
 * @property integer $screening_form_question_id
 * @property integer $screening_form_id
 * @property integer $subject_id
 * @property string $answer
 * @property string $name
 * @property integer $input_type_id
 * @property integer $default_value
 * @property integer $sort_order
 * @property integer $status_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property RefStatus $status
 * @property ScreeningForms $screeningForm
 * @property ScreeningFormQuestions $screeningFormQuestion
 * @property Subjects $subject
 */
class ScreeningFormAnswers extends \common\components\XActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'screening_form_answers';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['screening_form_question_id', 'screening_form_id', 'subject_id', 'name', 'input_type_id', 'created_at', 'created_by'], 'required'],
            [['screening_form_question_id', 'screening_form_id', 'subject_id', 'input_type_id', 'default_value', 'sort_order', 'status_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['answer', 'name'], 'string', 'max' => 4096],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefStatus::className(), 'targetAttribute' => ['status_id' => 'id']],
            [['screening_form_id'], 'exist', 'skipOnError' => true, 'targetClass' => ScreeningForms::className(), 'targetAttribute' => ['screening_form_id' => 'id']],
            [['screening_form_question_id'], 'exist', 'skipOnError' => true, 'targetClass' => ScreeningFormQuestions::className(), 'targetAttribute' => ['screening_form_question_id' => 'id']],
            [['subject_id'], 'exist', 'skipOnError' => true, 'targetClass' => Subjects::className(), 'targetAttribute' => ['subject_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'screening_form_question_id' => Yii::t('app', 'Screening Form Question ID'),
            'screening_form_id' => Yii::t('app', 'Screening Form ID'),
            'subject_id' => Yii::t('app', 'Subject ID'),
            'answer' => Yii::t('app', 'Answer'),
            'name' => Yii::t('app', 'Name'),
            'input_type_id' => Yii::t('app', 'Input Type ID'),
            'default_value' => Yii::t('app', 'Default Value'),
            'sort_order' => Yii::t('app', 'Sort Order'),
            'status_id' => Yii::t('app', 'Status ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(RefStatus::className(), ['id' => 'status_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getScreeningForm()
    {
        return $this->hasOne(ScreeningForms::className(), ['id' => 'screening_form_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getScreeningFormQuestion()
    {
        return $this->hasOne(ScreeningFormQuestions::className(), ['id' => 'screening_form_question_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubject()
    {
        return $this->hasOne(Subjects::className(), ['id' => 'subject_id']);
    }

    /**
     * @inheritdoc
     * @return ScreeningFormAnswersQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ScreeningFormAnswersQuery(get_called_class());
    }
}
