<?php

use common\components\XMigration;

class m160113_151026_screening_form extends XMigration
{

    /* ************************************************************************************** */ 

    public function init()
    {
       $this->tableName = '{{%screening_form}}'; 
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
                    'alias'=>$this->string(255)->notNull(),
                    'description'=>$this->string(4096),
                    'subject_label'=>$this->string(255)->defaultValue('Participant'),
                    'researcher_label'=>$this->string(255)->defaultValue('Researcher'), 
                    'collection_id' => $this->integer()->notNull(),
                    'signature_option_id' => $this->integer()->notNull()->defaultValue(2),
                    'sort_order' => $this->integer()->notNull()->defaultValue(100), 
                    'status_id'=>$this->integer()->notNull()->defaultValue(2),
                    'created_at' => $this->integer()->notNull(),
                    'updated_at' => $this->integer(),
                    'created_by' => $this->integer()->notNull(),
                    'updated_by' => $this->integer(),
                ], 
                $this->mysqlOptions 
            );

        $this->addForeignKey('fk_screening_form_status_id' , $this->tableName,  'status_id' , 'ref_status' , 'id' , 'NO ACTION' , 'NO ACTION'); 
        $this->addForeignKey('fk_screening_form_collection_id' , $this->tableName,  'collection_id' , 'collection' , 'id' , 'NO ACTION' , 'NO ACTION'); 
        $this->addForeignKey('fk_screening_form_signature_option_id' , $this->tableName,  'signature_option_id' , 'ref_boolean' , 'id' , 'NO ACTION' , 'NO ACTION'); 
        $this->createIndex('idx_uniq_alias' , $this->tableName,  'alias' ,true);

        $this->insert($this->tableName,['title'=>'MRI primary screening',
                                    'alias'=>'mri-primary-screening',
                                    'description'=>'CUBRIC, Cardiff University - MRI screening form',
                                    'collection_id'=>1,
                                    'sort_order'=>100, 
                                    'status_id'=>2, 
                                    'created_at'=>time(),
                                    'updated_at'=>0, 
                                    'created_by'=>0, 
                                    'updated_by'=>0,  
                                ]); 

    }
    /* ************************************************************************************** */
  
    public function down()
    {
        $this->init();
        $this->dropForeignKey('fk_screening_form_status_id',$this->tableName); 
        $this->dropForeignKey('fk_screening_form_collection_id',$this->tableName); 
        $this->dropForeignKey('fk_screening_form_signature_option_id',$this->tableName); 
        $this->dropTable($this->tableName); 
        return true;
    }
    /* ************************************************************************************** */
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
