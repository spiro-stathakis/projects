<?php

use common\components\XMigration;


class m160209_080045_event extends XMigration
{
   
/* ************************************************************************************** */ 

    public function init()
    {
       $this->tableName = '{{%event}}'; 
       return parent::init();  
    }

    /* ************************************************************************************** */ 
    public function up()
    {

        $this->init(); 
             $this->createTable(
                $this->tableName, 
                [
                    'id'=>$this->primaryKey(),
                    'title'=>$this->string(2048)->notNull(),
                    'description'=>$this->string(2048),
                    'calendar_id'=> $this->integer()->notNull(),
                    'project_id'=> $this->integer(),
                    'sort_order'=> $this->integer()->notNull()->defaultValue(100),
                    'status_id'=>$this->integer()->notNull()->defaultValue(2),
                    'old_id'=>$this->integer(),
                    'created_at' => $this->integer()->notNull(),
                    'updated_at' => $this->integer(),
                    'created_by' => $this->integer()->notNull(),
                    'updated_by' => $this->integer(),
                ], 
                $this->mysqlOptions 
            );

        $this->addForeignKey('fk_event_calendar_id' , $this->tableName,  'calendar_id' , 'calendar' , 'id' , 'NO ACTION' , 'NO ACTION'); 
        $this->addForeignKey('fk_event_status_id' , $this->tableName,  'status_id' , 'ref_status' , 'id' , 'NO ACTION' , 'NO ACTION'); 
                             


    }
     /* ************************************************************************************** */ 
   
    public function down()
    {
        $this->init();
        $this->dropForeignKey('fk_event_calendar_id',$this->tableName); 
        $this->dropForeignKey('fk_event_status_id',$this->tableName); 
        
        $this->dropTable($this->tableName); 
        return true;
    }
     /* ************************************************************************************** */ 
   
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
