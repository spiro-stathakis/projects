<?php

namespace app\modules\admin\controllers;

use Yii;
use common\components\XController;
use common\components\Types; 
use common\components\LdapComponent; 
use common\models\User;
use yii\widgets\ActiveForm;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Json; 

/**
 * CalendarController implements the CRUD actions for Calendar model.
 */
class AjaxController extends XController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                        'class' => AccessControl::className(),
                        'rules' => [
                                    ['actions' => ['ldapsearchuser',
                                                   'createuser',
                                                ], 

                                                'allow' => true, 'roles' => ['admin_role'],], 
                        ],
            ],
        ];
        
    }



    /* ****************************************************************************************** */ 

    public function actionLdapsearchuser()
    {
       
        yii::$app->AjaxResponse->error = false; 
        $return = ['count'=>0,'data'=>[]];
        $request =yii::$app->request; 
        $search = $request->post('user_name'); 
        $ldap = new LdapComponent; 
        $record = $ldap->search(sprintf('uid=%s',$search)); 
        if ($record['count'] > 0)
        {
                $return['count']  = $record['count']; 
                $return['data']['first_name'] = $record['data'][0]['givenname'][0];
                $return['data']['last_name'] = $record['data'][0]['sn'][0];
                $return['data']['email'] = $record['data'][0]['mail'][0];
                $return['data']['dn'] = $record['data'][0]['dn'];
                $return['data']['uid'] = $record['data'][0]['uidnumber'][0];
                $return['data']['gid'] = $record['data'][0]['gidnumber'][0];

        }
        yii::$app->AjaxResponse->message = $return ; 
        yii::$app->AjaxResponse->sendContent();  

    }
    /* ****************************************************************************************** */ 
    public function actionCreateuser()
    {

       
       
       
       $userModel = User::findOne(['user_name'=>yii::$app->request->post('user_name')]); 
       if ($userModel === null )
       { 

                $userModel  = new User; 
                $userModel->load(yii::$app->request->post()); 
                if ($userModel->save())
                {
                     yii::$app->AjaxResponse->error = false; 
                     yii::$app->AjaxResponse->message = ['User has been created']; 
                }
                else 
                    yii::$app->AjaxResponse->message = array_values($userModel->getErrors());  
       }
       else 

                yii::$app->AjaxResponse->message = ['User already exists']; 
    

        yii::$app->AjaxResponse->sendContent();  
    }

    /* ****************************************************************************************** */ 
   
    /* ****************************************************************************************** */ 
    
    /* ****************************************************************************************** */ 
    /* ****************************************************************************************** */ 
    
    /* ****************************************************************************************** */ 
    
    /* ****************************************************************************************** */ 
   
    /* ****************************************************************************************** */ 
    
    /* ****************************************************************************************** */ 
    private function sendContent($data)
    {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            echo Json::encode($data);
            Yii::$app->end();
    }
    /* ****************************************************************************************** */ 
    
    
}
