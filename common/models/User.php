<?php

namespace common\models;
use \common\components\Types;
use Yii;

/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property integer $auth_id
 * @property string $user_name
 * @property string $email
 * @property string $first_name
 * @property string $last_name
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property integer $old_id
 * @property integer $reg_date
 * @property integer $status_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property LnkProjectAssoc[] $lnkProjectAssocs
 * @property RefAuthType $auth
 * @property RefStatus $status
 */
class User extends \common\components\XActiveRecord
{
    
   
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['auth_id', 'old_id', 'reg_date', 'status_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['user_name', 'email', 'first_name', 'last_name', 'auth_key', 'password_hash', 'reg_date', 'created_at', 'created_by'], 'required'],
            [['user_name', 'email', 'first_name', 'last_name', 'password_hash', 'password_reset_token'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['user_name'], 'unique'],
            [['email'], 'unique'],
            [['password_reset_token'], 'unique'],
            [['auth_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefAuthType::className(), 'targetAttribute' => ['auth_id' => 'id']],
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
            'auth_id' => Yii::t('app', 'Auth ID'),
            'user_name' => Yii::t('app', 'User Name'),
            'email' => Yii::t('app', 'Email'),
            'first_name' => Yii::t('app', 'First Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'auth_key' => Yii::t('app', 'Auth Key'),
            'password_hash' => Yii::t('app', 'Password Hash'),
            'password_reset_token' => Yii::t('app', 'Password Reset Token'),
            'old_id' => Yii::t('app', 'Old ID'),
            'reg_date' => Yii::t('app', 'Reg Date'),
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
    public function getLnkProjectAssocs()
    {
        return $this->hasMany(LnkProjectAssoc::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuth()
    {
        return $this->hasOne(RefAuthType::className(), ['id' => 'auth_id']);
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
     * @return UsersQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UsersQuery(get_called_class());
    }
}
