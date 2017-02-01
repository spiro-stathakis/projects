<?php

use common\components\XMigration;

class m170125_171753_invoice_entry extends XMigration

{

     /* ************************************************************************************** */ 

    public function init()
    {
       $this->tableName = '{{%invoice_entry}}'; 
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
                    'invoice_id'=> $this->integer()->notNull(),
                    'resource_id'=> $this->integer()->notNull(),
                    'resource_other'=> $this->string(4096),
                    'unit_cost'=>$this->integer(),
                    'qty'=>$this->integer(),
                    'total_cost'=>$this->integer()->notNull(),
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


        $this->addForeignKey('fk_invoice_entry_invoice_id' , $this->tableName,  'invoice_id' , 'invoice' , 'id' , 'NO ACTION' , 'NO ACTION'); 
        $this->addForeignKey('fk_invoice_entry_resource_id' , $this->tableName,  'resource_id' , 'resource' , 'id' , 'NO ACTION' , 'NO ACTION'); 
        $this->addForeignKey('fk_invoice_entry_status_id' , $this->tableName,  'status_id' , 'ref_status' , 'id' , 'NO ACTION' , 'NO ACTION'); 


    }
    /* ************************************************************************************** */ 
    
    public function down()
    {
        
        $this->init();
        $this->dropForeignKey('fk_invoice_entry_invoice_id',$this->tableName); 
        $this->dropForeignKey('fk_invoice_entry_resource_id',$this->tableName); 
        $this->dropForeignKey('fk_invoice_entry_status_id',$this->tableName); 
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
