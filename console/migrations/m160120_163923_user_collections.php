<?php


use common\components\XMigration;

class m160120_163923_user_collections extends XMigration
{

     /* ************************************************************************************** */ 

    public function init()
    {
       $this->tableName = '{{%user_collections}}'; 
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
                    'collection_id'=>$this->integer()->notNull(),
                    'user_id'=>$this->integer()->notNull(),
                    'member_type_id'=>$this->integer()->notNull(),
                    'expiry'=>$this->integer()->notNull()->defaultValue(0), 
                    'sort_order'=> $this->integer()->notNull()->defaultValue(2),
                    'status_id'=>$this->integer()->notNull()->defaultValue(2),
                    'created_at' => $this->integer()->notNull(),
                    'updated_at' => $this->integer(),
                    'created_by' => $this->integer()->notNull(),
                    'updated_by' => $this->integer(),
                ], 
                $this->mysqlOptions 
            );

        $this->addForeignKey('fk_user_collections_status_id' , $this->tableName,  'status_id' , 'ref_status' , 'id' , 'NO ACTION' , 'NO ACTION'); 
        $this->addForeignKey('fk_user_collections_collection_id' , $this->tableName,  'collection_id' , 'collections' , 'id' , 'NO ACTION' , 'NO ACTION'); 
        $this->addForeignKey('fk_user_collections_user_id' , $this->tableName,  'user_id' , 'users' , 'id' , 'NO ACTION' , 'NO ACTION'); 
        $this->addForeignKey('fk_user_collections_member_type_id' , $this->tableName,  'member_type_id' , 'ref_member_type' , 'id' , 'NO ACTION' , 'NO ACTION'); 
                    
        $this->insert($this->tableName,['collection_id'=>1,
                                    'user_id'=>44,
                                    'member_type_id'=>3,
                                    'expiry'=>(time() + (365 * 86400)),
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
        $this->dropForeignKey('fk_user_collections_status_id',$this->tableName); 
        $this->dropForeignKey('fk_user_collections_collection_id',$this->tableName);
        $this->dropForeignKey('fk_user_collections_user_id',$this->tableName);
        $this->dropForeignKey('fk_user_collections_member_type_id',$this->tableName);
        
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
