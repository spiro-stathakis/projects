<?php

use common\components\XMigration;

class m160125_142255_screening_response extends XMigration
{

     /* ************************************************************************************** */ 

    public function init()
    {
       $this->tableName = '{{%screening_response}}'; 
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
                    'screening_question_id' => $this->integer()->notNull(),
                    'screening_entry_id'=> $this->integer()->notNull(),
                    'subject_id'=>$this->integer()->notNull(),
                    'response'=>$this->string(4096),
                    'sort_order' => $this->integer()->notNull()->defaultValue(100), 
                    'status_id'=>$this->integer()->notNull()->defaultValue(2),
                    'created_at' => $this->integer()->notNull(),
                    'updated_at' => $this->integer(),
                    'created_by' => $this->integer()->notNull(),
                    'updated_by' => $this->integer(),
                ], 
                $this->mysqlOptions 
            );

        $this->addForeignKey('fk_screening_response_screening_question_id' , $this->tableName,  'screening_question_id' , 'screening_question' , 'id' , 'NO ACTION' , 'NO ACTION'); 
        $this->addForeignKey('fk_screening_response_screening_entry_id' , $this->tableName,  'screening_entry_id' , 'screening_entry' , 'id' , 'NO ACTION' , 'NO ACTION'); 
        $this->addForeignKey('fk_screening_response_subject_id' , $this->tableName,  'subject_id' , 'subject' , 'id' , 'NO ACTION' , 'NO ACTION'); 
        $this->addForeignKey('fk_screening_response_status_id' , $this->tableName,  'status_id' , 'ref_status' , 'id' , 'NO ACTION' , 'NO ACTION'); 
        

        
          
    }
    /* ************************************************************************************** */
    
    public function down()
    {
        
        $this->init();
        $this->dropForeignKey('fk_screening_response_screening_question_id',$this->tableName); 
        $this->dropForeignKey('fk_screening_response_screening_entry_id',$this->tableName); 
        $this->dropForeignKey('fk_screening_response_subject_id',$this->tableName); 
        $this->dropForeignKey('fk_screening_response_status_id',$this->tableName); 
        
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
