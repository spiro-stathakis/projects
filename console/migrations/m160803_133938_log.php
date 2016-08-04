<?php

use common\components\XMigration;


class m160803_133938_log extends XMigration
{
     public function init()
    {
       $this->tableName = '{{%log}}'; 
       return parent::init();  
    }


    public function up()
    {

         $this->init(); 
            $this->createTable(
                    $this->tableName, 
                    [
                        'id'=>$this->primaryKey(),
                        'sys_event_id'=>$this->integer()->notNull(),
                        'user_id'=>$this->integer()->notNull(),
                        'description'=>$this->string(255)->notNull(),
                        'sort_order'=> $this->integer()->notNull()->defaultValue(100),
                        'status_id'=>$this->integer()->notNull(),
                        'created_at' => $this->integer()->notNull(),
                        'updated_at' => $this->integer(),
                        'created_by' => $this->integer()->notNull(),
                        'updated_by' => $this->integer(),
                    ], 
                    $this->mysqlOptions 
                );

            $this->addForeignKey('fk_log_status_id' , $this->tableName,  'status_id' , 'ref_status' , 'id' , 'NO ACTION' , 'NO ACTION'); 
             $this->addForeignKey('fk_log_sys_event_id' , $this->tableName,  'sys_event_id' , 'ref_sys_event' , 'id' , 'NO ACTION' , 'NO ACTION'); 
              $this->addForeignKey('fk_log_user_id' , $this->tableName,  'user_id' , 'user' , 'id' , 'NO ACTION' , 'NO ACTION'); 
        
            

    }

    public function down()
    {
        
        $this->init(); 
        $this->dropForeignKey('fk_log_status_id',$this->tableName); 
        $this->dropForeignKey('fk_log_sys_event_id',$this->tableName); 
        $this->dropForeignKey('fk_log_user_id',$this->tableName); 
        $this->dropTable($this->tableName); 
       

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
