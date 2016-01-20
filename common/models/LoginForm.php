<?php
namespace common\models;

use Yii;
use yii\base\Model;
use \common\components\Types;
use \common\models\Users;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    private $_user;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) 
        {
            $user = $this->getUser();
            if (! $user)
            {
                $this->addError($attribute, 'Incorrect username or password.');
                return false; 
            }

            

            if ($user->auth_type_id == Types::$auth_type['ldap']['id'])
            {
                    if (!$user->validateLdapPassword($this->password)) 
                    {
                            $this->addError($attribute, 'Incorrect username or password.');
                    }

            }
            else 
            {
                if (!$user->validatePassword($this->password)) 
                {
                    $this->addError($attribute, 'Incorrect username or password.');
                }
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        } else {
            return false;
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = UserIdentity::findByUsername($this->username);
        }
        return $this->_user;
    }
}
