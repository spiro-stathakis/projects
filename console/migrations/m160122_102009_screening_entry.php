<?php

use common\components\XMigration;

class m160122_102009_screening_entry extends XMigration
{
    /* ************************************************************************************** */ 

    public function init()
    {
       $this->tableName = '{{%screening_entry}}'; 
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
                    'screening_form_id' => $this->integer()->notNull(),
                    'subject_id'=> $this->integer()->notNull(),
                    'researcher_id'=>$this->integer()->notNull(),
                    'project_id'=>$this->integer()->notNull(), 
                    'progress_id'=>$this->integer()->notNull(),
                    'contraindication_id'=>$this->integer()->notNull(),
                    'hash'=>$this->string(255)->notNull(), 
                    'subject_signature'=>$this->text(), 
                    'researcher_signature'=>$this->text(),
                    'time_in'=>$this->integer(), 
                    'time_out'=>$this->integer(), 
                    'sort_order' => $this->integer()->notNull()->defaultValue(100), 
                    'status_id'=>$this->integer()->notNull()->defaultValue(2),
                    'created_at' => $this->integer()->notNull(),
                    'updated_at' => $this->integer(),
                    'created_by' => $this->integer()->notNull(),
                    'updated_by' => $this->integer(),
                ], 
                $this->mysqlOptions 
            );

        $this->addForeignKey('fk_screening_entry_screening_form_id' , $this->tableName,  'screening_form_id' , 'screening_form' , 'id' , 'NO ACTION' , 'NO ACTION'); 
        $this->addForeignKey('fk_screening_entry_subject_id' , $this->tableName,  'subject_id' , 'subject' , 'id' , 'NO ACTION' , 'NO ACTION'); 
        $this->addForeignKey('fk_screening_entry_project_id' , $this->tableName,  'project_id' , 'project' , 'id' , 'NO ACTION' , 'NO ACTION'); 
        $this->addForeignKey('fk_screening_entry_researcher_id' , $this->tableName,  'researcher_id' , 'user' , 'id' , 'NO ACTION' , 'NO ACTION'); 
        $this->addForeignKey('fk_screening_entry_progress_id' , $this->tableName,  'progress_id' , 'ref_progress' , 'id' , 'NO ACTION' , 'NO ACTION'); 
        $this->addForeignKey('fk_screening_entry_contraindication_id' , $this->tableName,  'contraindication_id' , 'ref_boolean' , 'id' , 'NO ACTION' , 'NO ACTION'); 
        $this->addForeignKey('fk_screening_entry_status_id' , $this->tableName,  'status_id' , 'ref_status' , 'id' , 'NO ACTION' , 'NO ACTION'); 
        

        
          
    }
    /* ************************************************************************************** */
    
    public function down()
    {
        
        $this->init();
        $this->dropForeignKey('fk_screening_entry_screening_form_id',$this->tableName); 
        $this->dropForeignKey('fk_screening_entry_subject_id',$this->tableName); 
        $this->dropForeignKey('fk_screening_entry_project_id',$this->tableName); 
        $this->dropForeignKey('fk_screening_entry_researcher_id',$this->tableName); 
        $this->dropForeignKey('fk_screening_entry_progress_id',$this->tableName); 
        $this->dropForeignKey('fk_screening_entry_contraindication_id',$this->tableName); 
        $this->dropForeignKey('fk_screening_entry_status_id',$this->tableName); 
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
