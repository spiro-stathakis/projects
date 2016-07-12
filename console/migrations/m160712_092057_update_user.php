<?php

use common\components\XMigration;

class m160712_092057_update_user extends XMigration
{
   
    public function init()
    {
       $this->tableName = '{{%user}}'; 
       return parent::init();  
    }
    /* ************************************************************************************** */ 
    public function up()
    {

        $this->init(); 
        $this->addColumn(
                $this->tableName, 
                'dn', 
                'VARCHAR(255) AFTER `last_name` ',
                $this->mysqlOptions 
            );

         $this->addColumn(
                $this->tableName, 
                'gid', 
                'INT UNSIGNED  AFTER `dn` ',
                $this->mysqlOptions 
            );

         $this->addColumn(
                $this->tableName, 
                'uid', 
                'INT UNSIGNED  AFTER `gid` ',
                $this->mysqlOptions 
            );

         $this->addColumn(
                $this->tableName, 
                'delete_at', 
                'INT UNSIGNED  AFTER `status_id` ',
                $this->mysqlOptions 
            );
    }

    public function down()
    {
         $this->dropColumn($this->tableName,'dn');
         $this->dropColumn($this->tableName,'gid');
         $this->dropColumn($this->tableName,'uid');
         $this->dropColumn($this->tableName,'delete_at');
        return true;
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
