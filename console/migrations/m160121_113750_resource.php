<?php

use common\components\XMigration;



class m160121_113750_resource extends XMigration
{



  /* ************************************************************************************** */ 

    public function init()
    {
       $this->tableName = '{{%resource}}'; 
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
                    'collection_id'=> $this->integer()->notNull(),
                    'title'=>$this->string(2048)->notNull(),
                    'description'=>$this->string(2048)->notNull(),
                    'location'=>$this->string(2048)->notNull(),
                    'sort_order'=> $this->integer()->notNull()->defaultValue(100),
                    'status_id'=>$this->integer()->notNull()->defaultValue(2),
                    'created_at' => $this->integer()->notNull(),
                    'updated_at' => $this->integer(),
                    'created_by' => $this->integer()->notNull(),
                    'updated_by' => $this->integer(),
                ], 
                $this->mysqlOptions 
            );

        $this->addForeignKey('fk_resource_status_id' , $this->tableName,  'status_id' , 'ref_status' , 'id' , 'NO ACTION' , 'NO ACTION'); 
        $this->addForeignKey('fk_resource_collection_id' , $this->tableName,  'collection_id' , 'collection' , 'id' , 'NO ACTION' , 'NO ACTION'); 
        

        $this->insert($this->tableName,['collection_id'=>1,'title'=>'MRI 3TW','description'=>'MRI 3T West', 'location'=>'Maindy Rd.', 'sort_order'=>100,'status_id'=>2,'created_at'=>time(),'created_by'=>1 ]);
        
        $this->insert($this->tableName,['collection_id'=>1,'title'=>'MRI 3TE','description'=>'MRI 3T East', 'location'=>'Maindy Rd.', 'sort_order'=>100,'status_id'=>2,'created_at'=>time(),'created_by'=>1 ]);
        
        $this->insert($this->tableName,['collection_id'=>1,'title'=>'MRI 7T','description'=>'MRI 7T', 'location'=>'Maindy Rd.', 'sort_order'=>100,'status_id'=>2,'created_at'=>time(),'created_by'=>1 ]);

    }
    
    /* ************************************************************************************** */ 
    
    public function down()
    {
        
        $this->init();
        $this->dropForeignKey('fk_resource_status_id',$this->tableName); 
        $this->dropForeignKey('fk_resource_collection_id',$this->tableName); 
        
        

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
