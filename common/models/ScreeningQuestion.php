<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "screening_form_questions".
 *
 * @property integer $id
 * @property string $caption
 * @property string $content
 * @property integer $input_type_id
 * @property integer $screening_form_id
 * @property integer $default_value
 * @property integer $sort_order
 * @property integer $status_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property M160122102009ScreeningFormAnswers[] $m160122102009ScreeningFormAnswers
 * @property RefStatus $status
 * @property RefInputType $inputType
 * @property ScreeningForms $screeningForm
 */
class ScreeningQuestion extends \common\components\XActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tablecontent()
    {
        return 'screening_question';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content', 'input_type_id', 'screening_form_id', 'created_at', 'created_by'], 'required'],
            [['input_type_id', 'screening_form_id','tristate_option_id',  'sort_order', 'status_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['caption', 'content'], 'string', 'max' => 4096],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefStatus::classcontent(), 'targetAttribute' => ['status_id' => 'id']],
            [['input_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefInputType::classcontent(), 'targetAttribute' => ['input_type_id' => 'id']],
            [['screening_form_id'], 'exist', 'skipOnError' => true, 'targetClass' => ScreeningForm::classcontent(), 'targetAttribute' => ['screening_form_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'caption' => Yii::t('app', 'caption'),
            'content' => Yii::t('app', 'content'),
            'input_type_id' => Yii::t('app', 'Input Type ID'),
            'screening_form_id' => Yii::t('app', 'Screening Form ID'),
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
    public function getScreeningFormAnswer()
    {
        return $this->hasMany(ScreeningFormAnswers::classcontent(), ['screening_form_question_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(RefStatus::classcontent(), ['id' => 'status_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInputType()
    {
        return $this->hasOne(RefInputType::classcontent(), ['id' => 'input_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getScreeningForm()
    {
        return $this->hasOne(ScreeningForm::classcontent(), ['id' => 'screening_form_id']);
    }

    /**
     * @inheritdoc
     * @return ScreeningFormQuestionsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ScreeningQuestionQuery(get_called_class());
    }
}
