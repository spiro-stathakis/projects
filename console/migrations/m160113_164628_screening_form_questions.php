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
                    'name'=>$this->string(255)->notNull(),
                    'title'=>$this->string(4096),
                    'description'=>$this->string(4096),
                    'collection_id' => $this->integer()->notNull(),
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
        $this->addForeignKey('fk_screening_form_collection_id' , $this->tableName,  'collection_id' , 'collections' , 'id' , 'NO ACTION' , 'NO ACTION'); 
                   
        $this->insert($this->tableName,['name'=>'MRI primary screening',
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
        echo "m160113_164628_screening_form_questions cannot be reverted.\n";

        return false;
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
