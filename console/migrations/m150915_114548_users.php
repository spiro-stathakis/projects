<?php

use common\components\XMigration;


class m150915_114548_users extends XMigration
{

    

/* ************************************************************************************** */ 

    public function init()
    {
       $this->tableName = '{{%users}}'; 
       return parent::init(); 
    }
/* ************************************************************************************** */ 

    public function up()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'first_name' => $this->string(255)->notNull(),
            'last_name' => $this->string(255)->notNull(),
            'uid'=>$this->integer()->notNull(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),
            'status_id' => $this->integer()->notNull()->defaultValue(2),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer()->notNull(),
            'updated_by' => $this->integer(),
        ], $mysqlOptions);
        //$this->renameColumn('user', 'status', 'status_id'); 
        $this->addForeignKey('fk_users_status_id' , 'users' , 'status_id' , 'ref_status' , 'id' , 'NO ACTION' , 'NO ACTION'); 



    }

    public function down()
    {

        $this->init(); 
        $this->dropForeignKey('fk_users_status_id' ,'users'); 
        $this->dropTable($this->tableName);
        //$this->renameColumn('user', 'status_id' , 'status');  
        


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
