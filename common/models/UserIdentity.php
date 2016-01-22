<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use \common\components\Types;
use \common\components\LdapComponent; 
use \common\behaviours\UserBehaviour; 

/**
 * User model
 *
 * @property integer $id
 * @property string $user_name
 * @property string $password_hash
 * @property string $password_reset_token
* @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class UserIdentity extends ActiveRecord implements IdentityInterface
{
   
     
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%users}}';
    }
/* ************************************************************************************** */ 

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $parent = parent::behaviors(); 
        $child=  [
            TimestampBehavior::className(),
           
        ];
        return array_merge($parent, $child); 
    }
/* ************************************************************************************** */ 

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['status_id', 'default', 'value' => Types::$status['active']['id']],
            ['status_id', 'in', 'range' => [Types::$status['active']['id'], self::STATUS_DELETED]],
        ];
    }
/* ************************************************************************************** */ 

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status_id' => Types::$status['active']['id']]);
    }
/* ************************************************************************************** */ 

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }
/* ************************************************************************************** */ 

    /**
     * Finds user by user_name
     *
     * @param string $user_name
     * @return static|null
     */
    public static function findByusername($user_name)
    {
        return static::findOne(['user_name' => $user_name, 'status_id' => Types::$status['active']['id']]);
    }
/* ************************************************************************************** */ 

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status_id' => Types::$status['active']['id'],
        ]);
    }
/* ************************************************************************************** */ 

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }
/* ************************************************************************************** */ 

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }
/* ************************************************************************************** */ 

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }
/* ************************************************************************************** */ 

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }
/* ************************************************************************************** */ 
/* ************************************************************************************** */ 

    /**
     * Validates LDAP password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validateLdapPassword($password)
    {
        $ldap = new LdapComponent;
        if ($ldap->login($this->user_name, $password))
            return true; 
        else
            return false; 
    }
/* ************************************************************************************** */ 

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }
/* ************************************************************************************** */ 

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }
/* ************************************************************************************** */ 

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }
/* ************************************************************************************** */ 

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }
/* ************************************************************************************** */ 

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
}
