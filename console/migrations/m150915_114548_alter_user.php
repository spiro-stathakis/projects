<?php

use yii\db\Migration;

class m150915_114548_alter_user extends Migration
{
    public function up()
    {

        
        $this->addColumn('user', 'first_name', 'VARCHAR(255) AFTER username'); 
        $this->addColumn('user', 'last_name', 'VARCHAR(255) AFTER first_name'); 
        //$this->renameColumn('user', 'status', 'status_id'); 
        $this->addForeignKey('fk_user_status_id' , 'user' , 'status_id' , 'ref_status' , 'id' , 'NO ACTION' , 'NO ACTION'); 



    }

    public function down()
    {

        $this->dropColumn('user', 'first_name'); 
        $this->dropColumn('user', 'last_name');
        //$this->renameColumn('user', 'status_id' , 'status');  
        $this->dropForeignKey('fk_user_status_id' ,'user'); 


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
