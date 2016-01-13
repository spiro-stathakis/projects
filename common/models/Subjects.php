<?php

namespace common\models;
use common\components\Types; 
use Yii;

/**
 * This is the model class for table "subjects".
 *
 * @property integer $id
 * @property string $cubric_id
 * @property string $first_name
 * @property string $last_name
 * @property string $dob
 * @property string $email
 * @property string $telephone
 * @property string $address
 * @property integer $gp_opt_id
 * @property integer $email_opt_id
 * @property integer $sex_id
 * @property integer $sort_order
 * @property integer $status_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property RefBoolean $emailOpt
 * @property RefBoolean $gpOpt
 * @property RefSex $sex
 * @property RefStatus $status
 */
class Subjects extends \common\components\XActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'subjects';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cubric_id', 'first_name', 'last_name', 'dob', 'gp_opt_id', 'email_opt_id', 'sex_id', 'status_id', 'created_at', 'created_by'], 'required'],
            [['dob'], 'safe'],
            [['gp_opt_id', 'email_opt_id', 'sex_id', 'sort_order', 'status_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['cubric_id', 'first_name', 'last_name', 'email', 'telephone', 'address'], 'string', 'max' => 255],
            [['email_opt_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefBoolean::className(), 'targetAttribute' => ['email_opt_id' => 'id']],
            [['gp_opt_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefBoolean::className(), 'targetAttribute' => ['gp_opt_id' => 'id']],
            [['sex_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefSex::className(), 'targetAttribute' => ['sex_id' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefStatus::className(), 'targetAttribute' => ['status_id' => 'id']],
        ];
    }


    /* ************************************************************************************************************************* */ 
    public function getSexOptions()
    {
        return [
                Types::$sex['n']['id']=>Types::$sex['n']['name'], 
                Types::$sex['f']['id']=>Types::$sex['f']['name'], 
                Types::$sex['m']['id']=>Types::$sex['m']['name'], 
        ]; 

    }
    /* ************************************************************************************************************************* */ 
     public function getBooleanOptions()
    {
        return [
                Types::$boolean['true']['id']=>Types::$boolean['true']['code'], 
                Types::$boolean['false']['id']=>Types::$boolean['false']['code'], 
        ]; 

    }



    /* ************************************************************************************************************************* */ 
    /* ************************************************************************************************************************* */ 
    /* ************************************************************************************************************************* */ 
    /* ************************************************************************************************************************* */ 
    /* ************************************************************************************************************************* */ 
    /* ************************************************************************************************************************* */ 
    
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
            'email' => Yii::t('app', 'Email'),
            'telephone' => Yii::t('app', 'Telephone'),
            'address' => Yii::t('app', 'Address'),
            'gp_opt_id' => Yii::t('app', 'Gp Opt ID'),
            'email_opt_id' => Yii::t('app', 'Email Opt ID'),
            'sex_id' => Yii::t('app', 'Sex ID'),
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
    public function getSex()
    {
        return $this->hasOne(RefSex::className(), ['id' => 'sex_id']);
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
     * @return SubjectsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SubjectsQuery(get_called_class());
    }
}
