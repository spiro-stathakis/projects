<?php
use common\components\XMigration;



class m160810_133108_new_sys_event extends XMigration
{
    
    public function init()
    {
       $this->tableName = '{{%ref_sys_event}}'; 
       return parent::init();  
    }


    public function up()
    {

         $this->init(); 
          $this->insert($this->tableName,['code'=>'login_succeed','name'=>'Login suceeded','description'=>'A successful login has occured', 'sort_order'=>100,'status_id'=>2,'created_at'=>time(),'created_by'=>1 ]);
          $this->insert($this->tableName,['code'=>'login_failed','name'=>'Login failed','description'=>'A login has failed', 'sort_order'=>100,'status_id'=>2,'created_at'=>time(),'created_by'=>1 ]);


    }

    public function down()
    {
        
        echo "m160810_133108_new_sys_event cannot be reverted.\n";

        return false;
       

    }

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

