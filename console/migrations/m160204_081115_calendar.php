<?php

use common\components\XMigration;

class m160204_081115_calendar extends XMigration
{
    

    /* ************************************************************************************** */ 

    public function init()
    {
       $this->tableName = '{{%calendar}}'; 
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
                    'collection_id'=> $this->integer()->notNull(),
                    'title'=>$this->string(255)->notNull()->unique(),
                    'description'=>$this->string(2048)->notNull(),
                    'location'=>$this->string(2048)->notNull(),
                    'start_time'=>$this->string(8)->notNull()->defaultValue('09:00'),
                    'end_time'=>$this->string(8)->notNull()->defaultValue('20:00'),
                    'hex_code'=>$this->string(16)->notNull()->defaultValue('#c0c0c0'),
                    'project_option_id'=> $this->integer()->notNull()->defaultValue(3),
                    'allow_overlap_option_id'=> $this->integer()->notNull()->defaultValue(3),
                    'read_only_option_id'=> $this->integer()->notNull()->defaultValue(3),
                    'advance_limit'=> $this->integer()->notNull()->defaultValue(0),
                    'old_id'=> $this->integer(),
                    'sort_order'=> $this->integer()->notNull()->defaultValue(100),
                    'status_id'=>$this->integer()->notNull()->defaultValue(2),
                    'created_at' => $this->integer()->notNull(),
                    'updated_at' => $this->integer(),
                    'created_by' => $this->integer()->notNull(),
                    'updated_by' => $this->integer(),
                ], 
                $this->mysqlOptions 
            );

        $this->addForeignKey('fk_calendar_status_id' , $this->tableName,  'status_id' , 'ref_status' , 'id' , 'NO ACTION' , 'NO ACTION'); 
        $this->addForeignKey('fk_calendar_collection_id' , $this->tableName,  'collection_id' , 'collection' , 'id' , 'NO ACTION' , 'NO ACTION'); 
        $this->addForeignKey('fk_calendar_project_option_id' , $this->tableName,  'project_option_id' , 'ref_boolean' , 'id' , 'NO ACTION' , 'NO ACTION'); 
        $this->addForeignKey('fk_calendar_allow_overlap_option_id' , $this->tableName,  'allow_overlap_option_id' , 'ref_boolean' , 'id' , 'NO ACTION' , 'NO ACTION'); 
        $this->addForeignKey('fk_calendar_read_only_option_id' , $this->tableName,  'read_only_option_id' , 'ref_boolean' , 'id' , 'NO ACTION' , 'NO ACTION'); 
          


    }

    /* ************************************************************************************** */ 
    
    public function down()
    {
        $this->init();
        $this->dropForeignKey('fk_calendar_status_id',$this->tableName); 
        $this->dropForeignKey('fk_calendar_collection_id',$this->tableName); 
        $this->dropForeignKey('fk_calendar_project_option_id',$this->tableName); 
        $this->dropForeignKey('fk_calendar_allow_overlap_option_id',$this->tableName); 
        $this->dropForeignKey('fk_calendar_read_only_option_id',$this->tableName); 

        

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
