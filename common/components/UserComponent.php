<?php 
namespace common\components; 
use Yii; 
use yii\base\Object;
use common\components\LdapComponent; 
use common\models\User;
use common\components\Types; 


class UserComponent extends Object
{

	
    private $_allUsers; 
    private $_searchUsers;
	
	/* ******************************************************************************************************* */ 
    /* ******************************************************************************************************* */ 
    /* ******************************************************************************************************* */ 
   
    /* ******************************************************************************************************* */ 
    public function init()
    {
      
        return parent::init(); 
    }
 /* ********************************************************************** */ 
  /* ********************************************************************** */ 
    public function import()
     {
        $newList =[]; 
        /*
        $ldap = new LdapComponent;
        $members = $ldap->groupSearch('cubric-int'); 
        
        
        User::updateAll(['status_id'=>Types::$status['inactive']['id']] , 
            'status_id=' . Types::$status['active']['id']);
        
        foreach($members as $dn) {
            $user_name = $this->_parseUserDn($dn);
            //echo sprintf('%s <br/>',  $user_name);
            $userModel = User::findOne(['user_name'=>$user_name]); 
            $rec = $ldap->search(sprintf('uid=%s',$user_name)); 
            $rec =$rec['data'][0]; 
            if ($userModel === null)
            {
                $userModel = new User;
                $userModel->user_name = $user_name; 
                $newList[] = [  'user_name'=>$user_name, 
                                'first_name'=>$rec['givenname'][0] ,
                                'last_name'=>$rec['sn'][0] 
                            ]; 
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

*/ 
     Yii::$app->mail->compose()
     ->setFrom('noreply@cardiff.ac.uk')
     ->setTo('spiro@cardiff.ac.uk')
     ->setHtmlBody('welcome-html', ['user_name'=>'Spiro'])
     ->setSubject('Advanced email from Yii2-SwiftMailer')
     ->send();
        return $newList; 
    }
    /* ********************************************************************** */ 
    private function _processNewUser()
    {

    }
    /* ********************************************************************** */ 
    private function _parseUserDn($dn)
    {
        $arr = explode(",", $dn); 
        return (substr($arr[0],3,strlen($arr[0])));

    }
   /* ********************************************************************** */ 
   /* ********************************************************************** */ 
   /* ********************************************************************** */ 
   /* ********************************************************************** */ 
   /* ********************************************************************** */ 
    public function getAllUsers()
    {
            if ($this->_allUsers == null) 
                    $this->_allUsers = $this->_getAllUsers(); 
            
            return $this->_allUsers; 
    }
    /* ******************************************************************************************************* */ 
    public function getActiveUsers()
    {
        $out = []; 
        if ($this->_allUsers == null) 
            $this->_allUsers = $this->_getAllUsers(); 
        
        foreach($this->_allUsers as $u)
            if ($u['status_id'] == Types::$status['active']['id'])
                $out =  $this->_allUsers();
        return $out; 

    }  
	/* ******************************************************************************************************* */ 
    public function ajaxSearchActiveUsers($q)
    {

       
        $out = ['results' => ['id' => '', 'text' => '']];
        $arr = []; 
        $users = $this->_searchUsers($q); 
        foreach ($users as $u)
            if ($u['status_id'] == Types::$status['active']['id'])
            $arr[] = [
                        'id'=>$u['user_id'] , 
                        'text'=>sprintf('%s %s (%s)',$u['first_name'], $u['last_name'], $u['user_name'] )
                    ]; 

        $out['results'] = $arr; 
        return $out; 



    
    }
	/* ******************************************************************************************************* */ 
    
public function getAjaxUsers()
    {
        $out = ['results' => ['id' => '', 'text' => '']];
        $arr = []; 
        foreach ($this->allUsers as $u)

            $arr[] = [
                        'id'=>$u['user_id'] , 
                        'text'=>sprintf('%s %s (%s)',$u['first_name'], $u['last_name'], $u['user_name'] )
                    ]; 

        $out['results'] = $arr; 
        return $out; 




    }
   /* ******************************************************************************************************* */ 
    /* ******************************************************************************************************* */ 
    
    private function _searchUsers($q)
    {

            $q = sprintf('%s%%', $q); 
            $this->_searchUsers   = (new \yii\db\Query())
                    ->select( $this->_getSelectFields())
                    ->from('user u')
                    ->where('u.user_name LIKE :user_name OR u.first_name LIKE :first_name OR u.last_name LIKE :last_name')
                    ->addParams([':user_name'=>$q, 
                                 ':first_name'=>$q, 
                                 ':last_name'=>$q, 
                        ])
                    ->orderBy('u.first_name', 'u.last_name')
                    ->all();

         return  $this->_searchUsers ; 

    }
    /* ******************************************************************************************************* */ 
    private function _getAllUsers()
    {
            $this->_allUsers   = (new \yii\db\Query())
                    ->select( $this->_getSelectFields())
                    ->from('user u')
                    ->all();

         return  $this->_allUsers ; 

    }
    /* ******************************************************************************************************* */ 
   
/*
        $query = new Query;
        $query->select('id, name AS text')
            ->from('city')
            ->where(['like', 'name', $q])
            ->limit(20);
        $command = $query->createCommand();

        $data = $command->queryAll();
*/ 
    /* ******************************************************************************************************* */ 
   
   
    /* ******************************************************************************************************* */ 
        private function _getSelectFields()
        {
            return [
                    'u.id as user_id' , 'u.user_name' ,'u.first_name', 
                    'u.last_name', 'u.email' ,'u.auth_type_id', 'u.auth_key' ,'u.status_id'   
            ];
        }
    /* ******************************************************************************************************* */ 

}