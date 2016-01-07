<?php

use common\components\XMigration;

class m151022_080225_lnk_project_assoc extends XMigration
{
    


/* ************************************************************************************** */ 

    public function init()
    {
       $this->tableName = '{{%lnk_project_assoc}}'; 
       return parent::init();  
       
    }
/* ************************************************************************************** */ 
    public function up()
    {

        $this->init(); 
         $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'project_id' => $this->integer()->notNull(),
            'assoc_id' => $this->integer()->notNull(),
            'status_id' => $this->integer()->notNull()->defaultValue(2),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer()->notNull(),
            'updated_by' => $this->integer(),
        ], $this->mysqlOptions);
        //$this->renameColumn('user', 'status', 'status_id'); 
        $this->addForeignKey('fk_user_project_status_id'  , $this->tableName ,  'status_id' , 'ref_status' , 'id' , 'NO ACTION' , 'NO ACTION'); 
        $this->addForeignKey('fk_user_project_user_id'    , $this->tableName  , 'user_id' , 'users' , 'id' , 'NO ACTION' , 'NO ACTION'); 
        $this->addForeignKey('fk_user_project_project_id' , $this->tableName  , 'project_id' , 'projects' , 'id' , 'NO ACTION' , 'NO ACTION'); 
        $this->addForeignKey('fk_user_project_assoc_id'   , $this->tableName  , 'assoc_id' , 'ref_assoc' , 'id' , 'NO ACTION' , 'NO ACTION'); 


    }
/* ************************************************************************************** */ 

    public function down()
    {
        $this->init(); 
        $this->dropForeignKey('fk_user_project_status_id',$this->tableName); 
        $this->dropForeignKey('fk_user_project_user_id',$this->tableName); 
        $this->dropForeignKey('fk_user_project_project_id',$this->tableName); 
        $this->dropForeignKey('fk_user_project_assoc_id',$this->tableName); 
        $this->dropTable($this->tableName); 
        
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
