<?php 
namespace common\components; 
use Yii; 
use yii\base\Object;
use common\components\Types; 
use common\models\Log; 

class LogComponent extends Object
{

	
    
	
	/* ******************************************************************************************************* */ 
    /* ******************************************************************************************************* */ 
    /* ******************************************************************************************************* */ 
    
    /* ******************************************************************************************************* */ 
    public function init()
    {
        
        return parent::init(); 
    }
    /* ********************************************************************** */ 
    public function newUser($user , $description = null)
    {
        if (($id = yii::$app->UserComponent->idFromUsername($user)) === false) 
                 throw new \yii\web\HttpException(500, sprintf('User not found %s', $user));

        $logModel = new Log; 
        $logModel->user_id = $id; 
        $logModel->sys_event_id  = Types::$systemEvent['user_activated']['id']; 
        $logModel->description = $description; 
        $logModel->save(); 

        
    }
    /* ********************************************************************** */ 
    public function loginFail($user)
    {
        $request = yii::$app->request; 
        $description = sprintf(
                                'username=%s||ip address=%s||agent=%s', 
                                $user, 
                                ($request->userIp == null)? '' : $request->userIp, 
                                ($request->userAgent == null) ? '' : $request->userAgent
                                ); 
       

        $logModel = new Log; 
        $logModel->user_id = 1; 

        $logModel->sys_event_id  = Types::$systemEvent['login_fail']['id']; 
        $logModel->description = $description; 
        $logModel->save(); 
    }
    /* ********************************************************************** */ 
    
    public function loginSuccess($user)
    {
        if (($id = yii::$app->UserComponent->idFromUsername($user)) === false) 
                 throw new \yii\web\HttpException(500, sprintf('User not found %s', $user));

        $request = yii::$app->request; 
        $description = sprintf(
                                'username=%s||ip address=%s||agent=%s', 
                                $user, 
                                ($request->userIp == null)? 'N/A' : $request->userIp, 
                                ($request->userAgent == null) ? 'N/A' : $request->userAgent
                                ); 
        $logModel = new Log; 
        $logModel->user_id = $id; 
        $logModel->sys_event_id  = Types::$systemEvent['login_success']['id']; 
        $logModel->description = $description; 
        $logModel->save(); 

    }
    /* ********************************************************************** */ 
    public function emailSend($user , $description = null)
    {
        if (($id = yii::$app->UserComponent->idFromUsername($user)) === false) 
                 throw new \yii\web\HttpException(500, sprintf('User not found %s', $user));

        $logModel = new Log; 
        $logModel->user_id = $id; 
        $logModel->sys_event_id  = Types::$systemEvent['email_send']['id']; 
        $logModel->description = $description; 
        $logModel->save(); 

        
    }
    /* ******************************************************************************************************* */ 

}