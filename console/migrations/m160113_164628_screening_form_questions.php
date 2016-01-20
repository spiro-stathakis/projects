<?php


use common\components\XMigration;

class m160113_164628_screening_form_questions extends XMigration
{

    /* ************************************************************************************** */ 

    public function init()
    {
       $this->tableName = '{{%screening_form_questions}}'; 
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
                    'title'=>$this->string(4096),
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

        $this->addForeignKey('fk_screening_form_questions_input_type_id' , $this->tableName,  'input_type_id' , 'ref_input_type' , 'id' , 'NO ACTION' , 'NO ACTION'); 
        $this->addForeignKey('fk_screening_form_questions_screening_form_id' , $this->tableName,  'screening_form_id' , 'screening_forms' , 'id' , 'NO ACTION' , 'NO ACTION'); 
        $this->addForeignKey('fk_screening_form_questions_status_id' , $this->tableName,  'status_id' , 'ref_status' , 'id' , 'NO ACTION' , 'NO ACTION'); 
        

        $this->insert($this->tableName,['title'=>'Question 1',
                                    'name'=>'Are you pregnant',
                                    'input_type_id'=>6,
                                    'screening_form_id'=>1,
                                    'default_value'=>3, 
                                    'sort_order'=>100, 
                                    'status_id'=>2, 
                                    'created_at'=>time(),
                                    'updated_at'=>0, 
                                    'created_by'=>1, 
                                    'updated_by'=>0,  
                                ]); 
          
       
    }
 
    /* ************************************************************************************** */
  
    public function down()
    {

        
        $this->init();
        $this->dropForeignKey('fk_screening_form_questions_input_type_id',$this->tableName); 
        $this->dropForeignKey('fk_screening_form_questions_screening_form_id',$this->tableName); 
        $this->dropForeignKey('fk_screening_form_questions_status_id',$this->tableName); 
        
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
