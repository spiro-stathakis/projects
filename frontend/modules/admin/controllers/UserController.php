<?php

namespace app\modules\admin\controllers;
use Yii;
use common\components\XController;
use common\components\Types; 
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use common\components\LdapComponent; 
use common\models\User;
use yii\filters\VerbFilter;
use yii\helpers\Url; 
use yii\helpers\Json; 

class UserController extends XController
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
                                    ['actions' => ['create','import'
                                                 ], 
                                        'allow' => true, 'roles' => ['admin_role'],], 
                        ],
            ],
        ];
        
    }

 /* ********************************************************************** */ 
 public function init()
 {
    if (! Yii::$app->user->isGuest){
            yii::$app->jsconfig->addData('allCalendars', yii::$app->CalendarComponent->allCalendars);
            yii::$app->jsconfig->addData('ldapSearchUserUri', Url::to('/admin/ajax/ldapsearchuser') );
            yii::$app->jsconfig->addData('createUserUri', Url::to('/admin/ajax/createuser') );
            
    }
    return parent::init(); 
 }
 /* ********************************************************************** */ 
 public function actionImport()
 {
        $ldap = new LdapComponent;
        $members = $ldap->groupSearch('cubric-int'); 
        $newList =[]; 
        User::updateAll(['status_id'=>Types::$status['inactive']['id']] , 
            'status_id=' . Types::$status['inactive']['id']);
        echo "<p>&nbsp;</p>"; 
        echo "<p>&nbsp;</p>"; 
        echo "<p>&nbsp;</p>"; 
        print_r($members); 
        foreach($members as $dn) {
            $user_name = $this->_parseUserDn($dn);
            //echo sprintf('%s <br/>',  $user_name);
            $userModel = User::findOne(['user_name'=>$user_name]); 
            $rec = $ldap->search(sprintf('uid=%s',$user_name)); 
            $rec =$rec['data'][0]; 
            if ($userModel === null){
                $userModel = new User;
                $userModel->user_name = $user_name; 
                $newList[] = sprintf('%s %s <br />',$userModel->first_name,$userModel->last_name); 
            }
            
            //if (array_key_exists('telephonenumber', $rec))
                //    echo ($rec['telephonenumber'][0]) . "<br/>";
            if (array_key_exists('mail', $rec))
                    $userModel->email = $rec['mail'][0];

            $userModel->first_name =  $rec['givenname'][0];
            $userModel->last_name =  $rec['sn'][0];
            $userModel->gid = $rec['gidnumber'][0];
            $userModel->uid = $rec['uidnumber'][0];
            $userModel->dn = $dn; 
            $userModel->status_id =Types::$status['active']['id']; 
            $userModel->save(); 



        }


        return $this->render('import', ['newList'=>$newList]);
}
/* ********************************************************************** */ 
private function _parseUserDn($dn)
    {
            $arr = explode(",", $dn); 
            return (substr($arr[0],3,strlen($arr[0])));

    }
 /* ********************************************************************** */ 

 public function actionCreate()
 {
        return $this->render('create'); 
 }
 /* ********************************************************************** */ 
    public function actionIndex()
    {
        return $this->render('index');
    }

}
