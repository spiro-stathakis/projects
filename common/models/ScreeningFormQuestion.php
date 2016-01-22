<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "screening_form_questions".
 *
 * @property integer $id
 * @property string $title
 * @property string $name
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
class ScreeningFormQuestion extends \common\components\XActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'screening_form_questions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'input_type_id', 'screening_form_id', 'created_at', 'created_by'], 'required'],
            [['input_type_id', 'screening_form_id', 'default_value', 'sort_order', 'status_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['title', 'name'], 'string', 'max' => 4096],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefStatus::className(), 'targetAttribute' => ['status_id' => 'id']],
            [['input_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefInputType::className(), 'targetAttribute' => ['input_type_id' => 'id']],
            [['screening_form_id'], 'exist', 'skipOnError' => true, 'targetClass' => ScreeningForm::className(), 'targetAttribute' => ['screening_form_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'name' => Yii::t('app', 'Name'),
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
        return $this->hasMany(ScreeningFormAnswers::className(), ['screening_form_question_id' => 'id']);
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
    public function getInputType()
    {
        return $this->hasOne(RefInputType::className(), ['id' => 'input_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getScreeningForm()
    {
        return $this->hasOne(ScreeningForm::className(), ['id' => 'screening_form_id']);
    }

    /**
     * @inheritdoc
     * @return ScreeningFormQuestionsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ScreeningFormQuestionQuery(get_called_class());
    }
}
