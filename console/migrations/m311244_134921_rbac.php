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
        $lab_manager = $auth->createRole('lab_manager');
        $auth->add($lab_manager);
        
        $tech_manager = $auth->createRole('tech_manager');
        $auth->add($tech_manager);
       

        $super_manager = $auth->createRole('super_manager');
        $auth->add($super_manager);

        $auth->addChild($super_manager, $lab_manager);
        $auth->addChild($super_manager, $tech_manager);

        $user = $this->_getUserId('sapss8'); 
        if ($user)
            $auth->assign($tech_manager, $user);

        $user = $this->_getUserId('scmcc2'); 
        if ($user)
            $auth->assign($tech_manager, $user);

        $user = $this->_getUserId('sapje1'); 
        if ($user)
            $auth->assign($lab_manager, $user);


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
