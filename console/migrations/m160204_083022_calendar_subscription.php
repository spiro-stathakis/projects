<?php

use common\components\XMigration;


class m160204_083022_calendar_subscription extends XMigration
{
    /* ************************************************************************************** */ 

    public function init()
    {
       $this->tableName = '{{%calendar_subscription}}'; 
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
                    'calendar_id'=> $this->integer()->notNull(),
                    'user_id'=> $this->integer()->notNull(),
                    'display_option_id'=>$this->integer()->notNull(),
                    'sort_order'=> $this->integer()->notNull()->defaultValue(100),
                    'status_id'=>$this->integer()->notNull()->defaultValue(2),
                    'created_at' => $this->integer()->notNull(),
                    'updated_at' => $this->integer(),
                    'created_by' => $this->integer()->notNull(),
                    'updated_by' => $this->integer(),
                ], 
                $this->mysqlOptions 
            );

        $this->addForeignKey('fk_calendar_subscription_status_id' , $this->tableName,  'status_id' , 'ref_status' , 'id' , 'NO ACTION' , 'NO ACTION'); 
        $this->addForeignKey('fk_calendar_subscription_calendar_id' , $this->tableName,  'calendar_id' , 'calendar' , 'id' , 'NO ACTION' , 'NO ACTION'); 
        $this->addForeignKey('fk_calendar_subscription_user_id' , $this->tableName,  'user_id' , 'user' , 'id' , 'NO ACTION' , 'NO ACTION'); 
         $this->addForeignKey('fk_calendar_display_option_id' , $this->tableName,  'display_option_id' , 'ref_boolean' , 'id' , 'NO ACTION' , 'NO ACTION'); 

    }

    /* ************************************************************************************** */ 
    
    public function down()
    {
       $this->init();
        $this->dropForeignKey('fk_calendar_subscription_status_id',$this->tableName); 
        $this->dropForeignKey('fk_calendar_subscription_calendar_id',$this->tableName); 
        $this->dropForeignKey('fk_calendar_subscription_user_id',$this->tableName); 
         $this->dropForeignKey('fk_calendar_display_option_id',$this->tableName); 
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
