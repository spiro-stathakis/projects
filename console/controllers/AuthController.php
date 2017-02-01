<?php 
namespace console\controllers;

use yii\console\Controller;
use yii\helpers\Console;
use \common\models\UserIdentity; 
use \common\components\Types; 
use console\models\User; 

class AuthController extends Controller
{
    public $message;
    
    /* ********************************************************************* */
    public function options($actionID)
    {
        return ['message'];
    }
    /* ********************************************************************* */
    public function optionAliases()
    {
        return ['m' => 'message'];
    }
    /* ********************************************************************* */
    public function actionIndex()
    {
        $users = User::findAll(['auth_type_id'=>Types::$auth_type['ldap']['id']]); 
        
        foreach ($users as $u)
        {
            $u->auth_type_id = Types::$auth_type['db']['id'];
            $u->password_hash = \Yii::$app->security->generatePasswordHash($u->user_name);
            $u->save();        
            $name = $this->ansiFormat($u->user_name, Console::FG_YELLOW);
            $this->stdout("Processing " . $name . "\n", Console::BOLD);
        }

        return Controller::EXIT_CODE_NORMAL; 
    }
    /* ********************************************************************* */
}

