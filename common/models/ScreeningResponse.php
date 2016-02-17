<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "screening_response".
 *
 * @property integer $id
 * @property integer $screening_question_id
 * @property integer $screening_entry_id
 * @property integer $subject_id
 * @property string $response
 * @property integer $sort_order
 * @property integer $status_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property RefStatus $status
 * @property ScreeningEntry $screeningEntry
 * @property ScreeningQuestion $screeningQuestion
 * @property Subject $subject
 */
class ScreeningResponse extends \common\components\XActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'screening_response';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['screening_question_id', 'screening_entry_id', 'subject_id'], 'required'],
            [['screening_question_id', 'screening_entry_id', 'subject_id', 'sort_order', 'status_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['response'], 'string', 'max' => 4096],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefStatus::className(), 'targetAttribute' => ['status_id' => 'id']],
            [['screening_entry_id'], 'exist', 'skipOnError' => true, 'targetClass' => ScreeningEntry::className(), 'targetAttribute' => ['screening_entry_id' => 'id']],
            [['screening_question_id'], 'exist', 'skipOnError' => true, 'targetClass' => ScreeningQuestion::className(), 'targetAttribute' => ['screening_question_id' => 'id']],
            [['subject_id'], 'exist', 'skipOnError' => true, 'targetClass' => Subject::className(), 'targetAttribute' => ['subject_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'screening_question_id' => Yii::t('app', 'Screening Question ID'),
            'screening_entry_id' => Yii::t('app', 'Screening Entry ID'),
            'subject_id' => Yii::t('app', 'Subject ID'),
            'response' => Yii::t('app', 'Response'),
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
    public function getScreeningEntry()
    {
        return $this->hasOne(ScreeningEntry::className(), ['id' => 'screening_entry_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getScreeningQuestion()
    {
        return $this->hasOne(ScreeningQuestion::className(), ['id' => 'screening_question_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubject()
    {
        return $this->hasOne(Subject::className(), ['id' => 'subject_id']);
    }

    /**
     * @inheritdoc
     * @return ScreeningResponseQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ScreeningResponseQuery(get_called_class());
    }
}
