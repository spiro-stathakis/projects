<?php
 
use common\components\XMigration;


class m150915_114548_user extends XMigration
{

    

/* ************************************************************************************** */ 

    public function init()
    {
       $this->tableName = '{{%user}}'; 
       return parent::init(); 
    }
/* ************************************************************************************** */ 

    public function up()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'auth_type_id' => $this->integer()->notNull()->defaultValue(2),
            'user_name' => $this->string()->notNull()->unique(),
            'email' => $this->string()->notNull()->unique(),
            'first_name' => $this->string(255)->notNull(),
            'last_name' => $this->string(255)->notNull(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'old_id' => $this->integer()->notNull()->defaultValue(0),
            'expiry_date' => $this->integer()->notNull()->defaultValue(0),
            'reg_date' => $this->integer()->notNull(),
            'status_id' => $this->integer()->notNull()->defaultValue(2),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer()->notNull(),
            'updated_by' => $this->integer(),
        ], $this->mysqlOptions);
        //$this->renameColumn('user', 'status', 'status_id'); 
        $this->addForeignKey('fk_users_status_id' , 'user' , 'status_id' , 'ref_status' , 'id' , 'NO ACTION' , 'NO ACTION'); 
        $this->addForeignKey('fk_users_auth_type_id' , 'user' , 'auth_type_id' , 'ref_auth_type' , 'id' , 'NO ACTION' , 'NO ACTION'); 

       $this->execute('CALL sp_import_users();');
        
    }

    public function down()
    {

        $this->init(); 
        $this->dropForeignKey('fk_users_status_id' ,'user'); 
        $this->dropForeignKey('fk_users_auth_type_id' ,'user'); 
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
