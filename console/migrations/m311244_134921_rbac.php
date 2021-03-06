<?php

use yii\db\Migration;

class m311244_134921_rbac extends Migration
{
    /* ****************************************************************************************************************** */ 
   
    public function up()
    {

        $auth = \yii::$app->authManager;
        // $authorRole = $auth->getRole('author');
        // add "author" role and give this role the "createPost" permission
        

        // add "createPost" permission
        $createCalendar = $auth->createPermission('createCalendar');
        $createCalendar->description = 'Create a calendar';
        $auth->add($createCalendar);

        $editCalendar = $auth->createPermission('editCalendar');
        $editCalendar->description = 'Edit a calendar';
        $auth->add($editCalendar);


        $core_staff_role = $auth->createRole('core_staff_role');
        $auth->add($core_staff_role);
        


        $director_role = $auth->createRole('director_role');
        $auth->add($director_role);



        $lab_manager_role = $auth->createRole('lab_manager_role');
        $auth->add($lab_manager_role);
        
        $tech_role = $auth->createRole('tech_role');
        $auth->add($tech_role);
       

        $admin_role  = $auth->createRole('admin_role');
        $auth->add($admin_role); 




        $auth->addChild($lab_manager_role, $core_staff_role);
        $auth->addChild($tech_role, $core_staff_role);
        $auth->addChild($admin_role, $core_staff_role);
        $auth->addChild($director_role, $core_staff_role);


        $auth->addChild($lab_manager_role, $createCalendar);
        $auth->addChild($lab_manager_role, $editCalendar);

        $auth->addChild($tech_role, $createCalendar);
        $auth->addChild($tech_role, $editCalendar);

        $auth->addChild($admin_role, $createCalendar);
        $auth->addChild($admin_role, $editCalendar);

        $super_manager = $auth->createRole('super_manager');
        $auth->add($super_manager);

        $auth->addChild($super_manager, $lab_manager_role);
        $auth->addChild($super_manager, $tech_role);
        $auth->addChild($super_manager, $admin_role);


        $user = $this->_getUserId('sapar1'); 
        if ($user)
            $auth->assign($admin_role, $user);

        $user = $this->_getUserId('sapiv'); 
        if ($user)
            $auth->assign($admin_role, $user);


        $user = $this->_getUserId('sapam10'); 
        if ($user)
            $auth->assign($admin_role, $user);


        $user = $this->_getUserId('sapss8'); 
        if ($user)
            $auth->assign($tech_role, $user);

        $user = $this->_getUserId('scmcc2'); 
        if ($user)
            $auth->assign($tech_role, $user);

        

        $user = $this->_getUserId('sapje1'); 
        if ($user)
            $auth->assign($lab_manager_role, $user);

        $user = $this->_getUserId('sapjs12'); 
        if ($user)
            $auth->assign($lab_manager_role, $user);




        $user = $this->_getUserId('sapcb6'); 
        if ($user)
        {
            $auth->assign($admin_manager_role, $user);
            $auth->assign($director_role, $user);
        }

        //$auth->assign($admin, 1);
         //   $auth->assign($authorRole, $user->getId());


    }
    /* ****************************************************************************************************************** */ 
   

   private function _getUserId($user_name)
   {
    $query = new \yii\db\Query;
    // compose the query
    $data = $query->select('id')
        ->from('user u')
        ->where('u.user_name=:user_name')
        ->addParams(['user_name'=>$user_name])
        ->all();

    if (count($data) == 1)
        return $data[0]['id']; 
    else 
        return false;   

   }
   /* ****************************************************************************************************************** */ 
   
   /* ****************************************************************************************************************** */ 
   
   /* ****************************************************************************************************************** */ 
   
    public function down()
    {
         $this->delete('auth_item');
         
         $this->delete('auth_assignment' );
         $this->delete('auth_item_child');
         $this->delete('auth_rule');

         
        return true;
    }
    /* ****************************************************************************************************************** */ 
   
    /* ****************************************************************************************************************** */ 
   
    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
