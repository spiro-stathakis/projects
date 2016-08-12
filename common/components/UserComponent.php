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
    public function idFromUsername($username)
    {
        $userModel = User::findOne(['user_name'=>$username]);
        if ($userModel == null)
            return false; 
        else 
            return $userModel->id; 
        

    }
    /* ********************************************************************** */ 
    public function disableOldAccounts()
    {
        $newList = []; 
        $ldap = new LdapComponent;
        $users =  User::findAll(['status_id'=>Types::$status['active']['id']]); 
        foreach($users as $u)
        {
            $search = $ldap->userSearch($u->user_name); 
            if ($search == false)
            {
                $u->status_id = Types::$status['inactive']['id']; 
                $u->save(); 
                yii::$app->LogComponent->deactivateUser($u->user_name,sprintf('Removing user: %s %s',
                $u->first_name,
                $u->last_name)
                 );
                $newList[] = $u;  

            }
        }

        return $newList; 
    }

    /* ********************************************************************** */ 
    
    public function import()
     {
        $newList =[]; 
        
        $ldap = new LdapComponent;
        $members = $ldap->groupSearch('cubric-int'); 
        $email = ''; 
        
        User::updateAll(['status_id'=>Types::$status['inactive']['id']] , 
            'status_id=' . Types::$status['active']['id']);
        
        foreach($members as $dn) 
        {
            $user_name = $this->_parseUserDn($dn);
            $userModel = User::findOne(['user_name'=>$user_name]); 
            $rec = $ldap->search(sprintf('uid=%s',$user_name)); 
            $rec =$rec['data'][0]; 
            if ($userModel === null)
            {
                if (array_key_exists('email', $rec))
                    $email = $rec['mail'][0];
                else 
                    $email = sprintf('%s@cardiff.ac.uk', $user_name); 
                
                $userModel = new User;
                $userModel->user_name = $user_name; 
                $userModel->email = $email; 
                $newList[] = [  'user_name'=>$user_name, 
                                'first_name'=>$rec['givenname'][0] ,
                                'last_name'=>$rec['sn'][0], 
                                'email'=>$email  
                            ]; 
            }
            
            //if (array_key_exists('telephonenumber', $rec))
                //    echo ($rec['telephonenumber'][0]) . "<br/>";

            $userModel->first_name =  $rec['givenname'][0];
            $userModel->last_name =  $rec['sn'][0];
            $userModel->gid = $rec['gidnumber'][0];
            $userModel->uid = $rec['uidnumber'][0];
            $userModel->dn = $dn; 
            $userModel->status_id =Types::$status['active']['id']; 
            $userModel->save(); 
             
        }


        foreach($newList as $u)
        {
            yii::$app->LogComponent->activateUser($u['user_name'],sprintf('Adding user: %s %s',
                $u['first_name'],
                $u['last_name'])
            ); 
            if (array_key_exists('email',$u))
            {
                yii::$app->LogComponent->emailSend($u['user_name'],sprintf('Welcome email sent to %s',
                    $u['email'])
                ); 
            
                $this->sendWelcomeEmail($u['user_name'], $u['email']); 
            }
        } 
        
        return $newList; 
    }
    /* ********************************************************************** */ 
    public function sendWelcomeEmail($firstName, $email, $subject ='Welcome to the projects database.' )
    {

            return Yii::$app->mail->compose([
                                       'html'=>'welcome-html',
                                       'text'=>'welcome-text',  
                                      ],
                                      [
                                        'user_name'=>$firstName
                                      ])
             ->setFrom('noreply@cardiff.ac.uk')
             ->setTo($email)
             ->setSubject($subject)
             ->send();
    }
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