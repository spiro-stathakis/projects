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