<?php

use common\components\XMigration;

class m160122_102009_screening_form_answers extends XMigration
{

     /* ************************************************************************************** */ 

    public function init()
    {
       $this->tableName = '{{%screening_form_answers}}'; 
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
                    'screening_form_question_id' => $this->integer()->notNull(),
                    'screening_form_id'=> $this->integer()->notNull(),
                    'subject_id'=>$this->integer()->notNull(),
                    'answer'=>$this->string(4096),
                    'name'=>$this->string(4096)->notNull(),
                    'input_type_id' => $this->integer()->notNull(),
                    'screening_form_id'=>$this->integer()->notNull(),
                    'default_value'=>$this->integer()->notNull()->defaultValue(1),
                    'sort_order' => $this->integer()->notNull()->defaultValue(100), 
                    'status_id'=>$this->integer()->notNull()->defaultValue(2),
                    'created_at' => $this->integer()->notNull(),
                    'updated_at' => $this->integer(),
                    'created_by' => $this->integer()->notNull(),
                    'updated_by' => $this->integer(),
                ], 
                $this->mysqlOptions 
            );

        $this->addForeignKey('fk_screening_form_answers_screening_form_question_id' , $this->tableName,  'screening_form_question_id' , 'screening_form_questions' , 'id' , 'NO ACTION' , 'NO ACTION'); 
        $this->addForeignKey('fk_screening_form_answers_screening_form_id' , $this->tableName,  'screening_form_id' , 'screening_forms' , 'id' , 'NO ACTION' , 'NO ACTION'); 
        $this->addForeignKey('fk_screening_form_answers_subject_id' , $this->tableName,  'subject_id' , 'subjects' , 'id' , 'NO ACTION' , 'NO ACTION'); 
        $this->addForeignKey('fk_screening_form_answers_status_id' , $this->tableName,  'status_id' , 'ref_status' , 'id' , 'NO ACTION' , 'NO ACTION'); 
        

        
          
    }
    /* ************************************************************************************** */
    
    public function down()
    {
        
        $this->init();
        $this->dropForeignKey('fk_screening_form_answers_screening_form_question_id',$this->tableName); 
        $this->dropForeignKey('fk_screening_form_answers_screening_form_id',$this->tableName); 
        $this->dropForeignKey('fk_screening_form_answers_subject_id',$this->tableName); 
        $this->dropForeignKey('fk_screening_form_answers_status_id',$this->tableName); 
        
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
