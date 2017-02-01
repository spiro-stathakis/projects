<?php

use common\components\XMigration;

class m170124_135521_invoice extends XMigration
{


    /* ************************************************************************************** */ 

    public function init()
    {
       $this->tableName = '{{%invoice}}'; 
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
                    'invoice_number'=> $this->integer()->notNull(),
                    'project_id'=> $this->integer()->notNull(),
                    'publish_status_id'=> $this->integer()->notNull(),
                    'vat_status_id'=>$this->integer()->notNull(),
                    'amount'=>$this->integer()->notNull(),
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


        $this->addForeignKey('fk_invoice_project_id' , $this->tableName,  'project_id' , 'project' , 'id' , 'NO ACTION' , 'NO ACTION'); 
        $this->addForeignKey('fk_invoice_publish_status_id' , $this->tableName,  'publish_status_id' , 'ref_boolean' , 'id' , 'NO ACTION' , 'NO ACTION'); 
         $this->addForeignKey('fk_invoice_vat_status_id' , $this->tableName,  'vat_status_id' , 'ref_boolean' , 'id' , 'NO ACTION' , 'NO ACTION'); 
        $this->addForeignKey('fk_invoice_status_id' , $this->tableName,  'status_id' , 'ref_status' , 'id' , 'NO ACTION' , 'NO ACTION'); 

                             
    }
    /* ************************************************************************************** */ 
    
    public function down()
    {
       
        $this->init();
        $this->dropForeignKey('fk_invoice_project_id',$this->tableName); 
        $this->dropForeignKey('fk_invoice_publish_status_id',$this->tableName); 
        $this->dropForeignKey('fk_invoice_vat_status_id',$this->tableName); 
        $this->dropForeignKey('fk_invoice_status_id',$this->tableName); 
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
