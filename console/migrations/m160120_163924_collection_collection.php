<?php


use common\components\XMigration;

class m160120_163924_collection_collection extends XMigration
{

     /* ************************************************************************************** */ 

    public function init()
    {
       $this->tableName = '{{%collection_collection}}'; 
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
                    'parent_collection_id'=>$this->integer()->notNull(),
                    'child_collection_id'=>$this->integer()->notNull(),
                    'member_type_id'=>$this->integer()->notNull(),
                    'expiry'=>$this->integer()->notNull()->defaultValue(0), 
                    'sort_order'=> $this->integer()->notNull()->defaultValue(100),
                    'status_id'=>$this->integer()->notNull()->defaultValue(2),
                    'created_at' => $this->integer()->notNull(),
                    'updated_at' => $this->integer(),
                    'created_by' => $this->integer()->notNull(),
                    'updated_by' => $this->integer(),
                ], 
                $this->mysqlOptions 
            );

        $this->addForeignKey('fk_collection_collection_status_id' , $this->tableName,  'status_id' , 'ref_status' , 'id' , 'NO ACTION' , 'NO ACTION'); 
        $this->addForeignKey('fk_collection_collection_parent_collection_id' , $this->tableName,'parent_collection_id','collection', 'id' , 'NO ACTION' , 'NO ACTION'); 
        $this->addForeignKey('fk_collection_collection_child_collection_id' , $this->tableName,  'child_collection_id' , 'collection' , 'id' , 'NO ACTION' , 'NO ACTION'); 
        $this->addForeignKey('fk_collection_collection_member_type_id' , $this->tableName,  'member_type_id' , 'ref_member_type' , 'id' , 'NO ACTION' , 'NO ACTION'); 
                    
       
              

    }


    /* ************************************************************************************** */ 
    
    public function down()
    {
        

        $this->init();
        $this->dropForeignKey('fk_collection_collection_status_id',$this->tableName); 
        $this->dropForeignKey('fk_collection_collection_parent_collection_id',$this->tableName);
        $this->dropForeignKey('fk_collection_collection_child_collection_id',$this->tableName);
        $this->dropForeignKey('fk_collection_collection_member_type_id',$this->tableName);
        
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
