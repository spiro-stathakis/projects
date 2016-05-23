<?php

use common\components\XMigration;

class m160209_103755_event_entry extends XMigration
{


    /* ************************************************************************************** */ 

    public function init()
    {
       $this->tableName = '{{%event_entry}}'; 
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
                    'event_id'=> $this->integer()->notNull(),
                    'title'=>$this->string(2048)->notNull(),
                    'description'=>$this->string(2048),
                    'booking_status_id'=>$this->integer()->notNull(), 
                    'start_timestamp'=> $this->integer()->notNull(),
                    'end_timestamp'=> $this->integer()->notNull(),
                    'all_day_option_id'=>$this->integer()->notNull(), 
                    'confirm_by'=>$this->integer(), 
                    'confirm_date'=>$this->integer(), 
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

        $this->addForeignKey('fk_event_entry_event_id' , $this->tableName,  'event_id' , 'event' , 'id' , 'NO ACTION' , 'NO ACTION'); 
        $this->addForeignKey('fk_event_entry_booking_status_id' , $this->tableName,  'booking_status_id' , 'ref_booking_status' , 'id' , 'NO ACTION' , 'NO ACTION'); 
        $this->addForeignKey('fk_event_entry_all_day_option_id' , $this->tableName,  'all_day_option_id' , 'ref_boolean' , 'id' , 'NO ACTION' , 'NO ACTION'); 
        $this->addForeignKey('fk_event_entry_status_id' , $this->tableName,  'status_id' , 'ref_status' , 'id' , 'NO ACTION' , 'NO ACTION'); 
                             


    }
     /* ************************************************************************************** */ 
   
    public function down()
    {
        $this->init();
        $this->dropForeignKey('fk_event_entry_event_id',$this->tableName); 
        $this->dropForeignKey('fk_event_entry_booking_status_id',$this->tableName); 
        $this->dropForeignKey('fk_event_entry_all_day_option_id',$this->tableName); 
        $this->dropForeignKey('fk_event_entry_status_id',$this->tableName); 
        
        $this->dropTable($this->tableName); 
        return true;
    }
     /* ************************************************

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
