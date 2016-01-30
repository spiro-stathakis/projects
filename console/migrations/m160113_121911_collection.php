<?php

use common\components\XMigration;


class m160113_121911_collection extends XMigration
{


    /* ************************************************************************************** */ 

    public function init()
    {
       $this->tableName = '{{%collection}}'; 
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
                    'description'=>$this->string(4096),
                    'collection_type_id' => $this->integer()->notNull(),
                    'membership_duration'=> $this->integer()->notNull()->defaultValue(5256000),
                    'member_count' => $this->integer()->notNull()->defaultValue(0),
                    'manager_count'=>$this->integer()->notNull()->defaultValue(0),
                    'sort_order'=> $this->integer()->notNull()->defaultValue(2),
                    'status_id'=>$this->integer()->notNull()->defaultValue(2),
                    'created_at' => $this->integer()->notNull(),
                    'updated_at' => $this->integer(),
                    'created_by' => $this->integer()->notNull(),
                    'updated_by' => $this->integer(),
                ], 
                $this->mysqlOptions 
            );

        $this->addForeignKey('fk_collection_status_id' , $this->tableName,  'status_id' , 'ref_status' , 'id' , 'NO ACTION' , 'NO ACTION'); 
        $this->addForeignKey('fk_collection_type_id' , $this->tableName,  'collection_type_id' , 'ref_collection_type' , 'id' , 'NO ACTION' , 'NO ACTION'); 
                   
        $this->insert($this->tableName,['name'=>'MRI operators',
                                    'description'=>'Collection of MRI operators',
                                    'collection_type_id'=>2,
                                    'membership_duration'=>365,
                                    'member_count'=>0,
                                    'manager_count'=>0, 
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
        $this->dropForeignKey('fk_collection_status_id',$this->tableName); 
        $this->dropForeignKey('fk_collection_type_id',$this->tableName); 
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