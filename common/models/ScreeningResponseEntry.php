<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "screening_form_response_entry".
 *
 * @property integer $id
 * @property integer $screening_form_id
 * @property integer $subject_id
 * @property integer $researcher_id
 * @property integer $progress_id
 * @property integer $contraindication_id
 * @property integer $sort_order
 * @property integer $status_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property RefStatus $status
 * @property RefBoolean $contraindication
 * @property RefProgress $progress
 * @property Users $researcher
 * @property ScreeningForms $screeningForm
 * @property Subjects $subject
 * @property ScreeningFormResponses[] $screeningFormResponses
 */
class ScreeningEntry extends \common\components\XActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'screening_entry';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['screening_form_id', 'subject_id', 'researcher_id', 'progress_id', 'contraindication_id', 'created_at', 'created_by'], 'required'],
            [['screening_form_id', 'subject_id', 'researcher_id', 'progress_id', 'contraindication_id', 'sort_order', 'status_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefStatus::className(), 'targetAttribute' => ['status_id' => 'id']],
            [['contraindication_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefBoolean::className(), 'targetAttribute' => ['contraindication_id' => 'id']],
            [['progress_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefProgress::className(), 'targetAttribute' => ['progress_id' => 'id']],
            [['researcher_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['researcher_id' => 'id']],
            [['screening_form_id'], 'exist', 'skipOnError' => true, 'targetClass' => ScreeningForms::className(), 'targetAttribute' => ['screening_form_id' => 'id']],
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
            'screening_form_id' => Yii::t('app', 'Screening Form ID'),
            'subject_id' => Yii::t('app', 'Subject ID'),
            'researcher_id' => Yii::t('app', 'Researcher ID'),
            'progress_id' => Yii::t('app', 'Progress ID'),
            'contraindication_id' => Yii::t('app', 'Contraindication ID'),
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
    public function getContraindication()
    {
        return $this->hasOne(RefBoolean::className(), ['id' => 'contraindication_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProgress()
    {
        return $this->hasOne(RefProgress::className(), ['id' => 'progress_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResearcher()
    {
        return $this->hasOne(Users::className(), ['id' => 'researcher_id']);
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
    public function getSubject()
    {
        return $this->hasOne(Subjects::className(), ['id' => 'subject_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getScreeningFormResponses()
    {
        return $this->hasMany(ScreeningFormResponses::className(), ['response_entry_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return ScreeningFormResponseEntryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ScreeningFormResponseEntryQuery(get_called_class());
    }
}
