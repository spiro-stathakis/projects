<?php

namespace common\models;

use Yii;
use common\components\Types; 

/**
 * This is the model class for table "screening_entry".
 *
 * @property integer $id
 * @property integer $screening_form_id
 * @property integer $subject_id
 * @property integer $researcher_id
 * @property integer $project_id
 * @property integer $resource_id
 * @property integer $progress_id
 * @property integer $contraindication_id
 * @property string $hash
 * @property string $screening_form_title
 * @property string $screening_form_description
 * @property string $resource_title
 * @property string $subject_signature
 * @property string $researcher_signature
 * @property integer $time_in
 * @property integer $time_out
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
 * @property Project $project
 * @property User $researcher
 * @property Resource $resource
 * @property ScreeningForm $screeningForm
 * @property Subject $subject
 * @property ScreeningResponse[] $screeningResponses
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
            [['screening_form_id', 'subject_id', 'researcher_id', 'project_id', 'resource_id', 'progress_id', 'contraindication_id', 'hash', 'screening_form_title'], 'required'],
            [['screening_form_id', 'subject_id', 'researcher_id', 'project_id', 'resource_id', 'progress_id', 'contraindication_id', 'time_in', 'time_out', 'sort_order', 'status_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['subject_signature', 'researcher_signature'], 'string'],
            [['hash'], 'string', 'max' => 255],
            [['screening_form_title', 'screening_form_description', 'resource_title'], 'string', 'max' => 4096],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefStatus::className(), 'targetAttribute' => ['status_id' => 'id']],
            [['contraindication_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefBoolean::className(), 'targetAttribute' => ['contraindication_id' => 'id']],
            [['progress_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefProgress::className(), 'targetAttribute' => ['progress_id' => 'id']],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 'targetAttribute' => ['project_id' => 'id']],
            [['researcher_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['researcher_id' => 'id']],
            [['resource_id'], 'exist', 'skipOnError' => true, 'targetClass' => Resource::className(), 'targetAttribute' => ['resource_id' => 'id']],
            [['screening_form_id'], 'exist', 'skipOnError' => true, 'targetClass' => ScreeningForm::className(), 'targetAttribute' => ['screening_form_id' => 'id']],
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
            'screening_form_id' => Yii::t('app', 'Screening Form ID'),
            'subject_id' => Yii::t('app', 'Subject ID'),
            'researcher_id' => Yii::t('app', 'Researcher ID'),
            'project_id' => Yii::t('app', 'Project ID'),
            'resource_id' => Yii::t('app', 'Resource ID'),
            'progress_id' => Yii::t('app', 'Progress ID'),
            'contraindication_id' => Yii::t('app', 'Contraindication ID'),
            'hash' => Yii::t('app', 'Hash'),
            'screening_form_title' => Yii::t('app', 'Screening Form Title'),
            'screening_form_description' => Yii::t('app', 'Screening Form Description'),
            'resource_title' => Yii::t('app', 'Resource Title'),
            'subject_signature' => Yii::t('app', 'Subject Signature'),
            'researcher_signature' => Yii::t('app', 'Researcher Signature'),
            'time_in' => Yii::t('app', 'Time In'),
            'time_out' => Yii::t('app', 'Time Out'),
            'sort_order' => Yii::t('app', 'Sort Order'),
            'status_id' => Yii::t('app', 'Status ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }
/* ******************************************************************************************************* */  
       /* ******************************************************************************************************* */  
               
           public function init()  
             {  
                     if ($this->isNewRecord)  
                     {  
                         $this->progress_id = Types::$progress['in_progress']['id'];  
                         $this->contraindication_id = Types::$boolean['null']['id'];  
                     }  
                 return parent::init();  
             }  
       /* ******************************************************************************************************* */  
       /* ******************************************************************************************************* */  
                        
         public function beforeValidate()  
         {  
             if ($this->isNewRecord)  
                 $this->hash = Yii::$app->security->generateRandomString();  
        
             return parent::beforeValidate();  
         }  
       /* ******************************************************************************************************* */  
        
    
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
    public function getProject()
    {
        return $this->hasOne(Project::className(), ['id' => 'project_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResearcher()
    {
        return $this->hasOne(User::className(), ['id' => 'researcher_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResource()
    {
        return $this->hasOne(Resource::className(), ['id' => 'resource_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getScreeningForm()
    {
        return $this->hasOne(ScreeningForm::className(), ['id' => 'screening_form_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubject()
    {
        return $this->hasOne(Subject::className(), ['id' => 'subject_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getScreeningResponses()
    {
        return $this->hasMany(ScreeningResponse::className(), ['screening_entry_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return ScreeningEntryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ScreeningEntryQuery(get_called_class());
    }
}
