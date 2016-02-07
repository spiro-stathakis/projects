<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "subject".
 *
 * @property integer $id
 * @property string $cubric_id
 * @property string $first_name
 * @property string $last_name
 * @property string $dob
 * @property string $hash
 * @property string $email
 * @property string $telephone
 * @property string $address
 * @property integer $gp_opt_id
 * @property integer $email_opt_id
 * @property integer $sex_id
 * @property integer $old_id
 * @property integer $sort_order
 * @property integer $status_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property ScreeningEntry[] $screeningEntries
 * @property ScreeningResponse[] $screeningResponses
 * @property RefSex $sex
 * @property RefBoolean $emailOpt
 * @property RefBoolean $gpOpt
 * @property RefStatus $status
 */
class Subject extends \common\components\XActiveRecord
{
    /**
     * @inheritdoc
     */
    
    public $screening_form_id; 
    public $project_id; 

    public static function tableName()
    {
        return 'subject';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cubric_id', 'first_name', 'last_name', 'dob', 'hash', 'gp_opt_id', 'email_opt_id', 'sex_id', 'old_id', 'status_id', 'created_at', 'created_by'], 'required'],
            [['dob','screening_form_id','project_id'], 'safe'],
            [['gp_opt_id', 'email_opt_id', 'sex_id', 'old_id', 'sort_order', 'status_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['cubric_id', 'first_name', 'last_name', 'email', 'telephone', 'address'], 'string', 'max' => 255],
            [['hash'], 'string', 'max' => 32],
            [['hash'], 'unique'],
            [['sex_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefSex::className(), 'targetAttribute' => ['sex_id' => 'id']],
            [['email_opt_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefBoolean::className(), 'targetAttribute' => ['email_opt_id' => 'id']],
            [['gp_opt_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefBoolean::className(), 'targetAttribute' => ['gp_opt_id' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefStatus::className(), 'targetAttribute' => ['status_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'cubric_id' => Yii::t('app', 'Cubric ID'),
            'first_name' => Yii::t('app', 'First Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'dob' => Yii::t('app', 'Dob'),
            'hash' => Yii::t('app', 'Hash'),
            'email' => Yii::t('app', 'Email'),
            'telephone' => Yii::t('app', 'Telephone'),
            'address' => Yii::t('app', 'Address'),
            'gp_opt_id' => Yii::t('app', 'Gp Opt ID'),
            'email_opt_id' => Yii::t('app', 'Email Opt ID'),
            'sex_id' => Yii::t('app', 'Sex ID'),
            'old_id' => Yii::t('app', 'Old ID'),
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
    public function getScreeningEntries()
    {
        return $this->hasMany(ScreeningEntry::className(), ['subject_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getScreeningResponses()
    {
        return $this->hasMany(ScreeningResponse::className(), ['subject_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSex()
    {
        return $this->hasOne(RefSex::className(), ['id' => 'sex_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmailOpt()
    {
        return $this->hasOne(RefBoolean::className(), ['id' => 'email_opt_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGpOpt()
    {
        return $this->hasOne(RefBoolean::className(), ['id' => 'gp_opt_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(RefStatus::className(), ['id' => 'status_id']);
    }

    /**
     * @inheritdoc
     * @return SubjectQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SubjectQuery(get_called_class());
    }
}
