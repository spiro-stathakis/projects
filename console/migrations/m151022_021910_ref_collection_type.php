<?php

use common\components\XMigration;

class m151022_021910_ref_collection_type extends XMigration
{
    

 /* ************************************************************************************** */ 

    public function init()
    {
       $this->tableName = '{{%ref_collection_type}}'; 
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
                        'code'=>$this->string(255)->notNull(),
                        'name'=>$this->string(255)->notNull(),
                        'description'=>$this->string(255)->notNull(),
                        'sort_order'=> $this->integer()->notNull()->defaultValue(100),
                        'status_id'=>$this->integer()->notNull(),
                        'created_at' => $this->integer()->notNull(),
                        'updated_at' => $this->integer(),
                        'created_by' => $this->integer()->notNull(),
                        'updated_by' => $this->integer(),
                    ], 
                    $this->mysqlOptions 
                );

            $this->insert($this->tableName,['code'=>'null','name'=>'No value','description'=>'No value','sort_order'=>100,'status_id'=>1,'created_at'=>time(),'created_by'=>1 ]); 
            $this->insert($this->tableName,['code'=>'resource','name'=>'Resource collection','description'=>'A collection for a resource at CUBRIC (ie. a scanner)', 'sort_order'=>100,'status_id'=>2,'created_at'=>time(),'created_by'=>1 ]);
            $this->insert($this->tableName,['code'=>'project','name'=>'Project collection','description'=>'A collection for a project at CUBRIC (ie. a research study)', 'sort_order'=>100,'status_id'=>2,'created_at'=>time(),'created_by'=>1 ]);
            $this->insert($this->tableName,['code'=>'group','name'=>'Group collection','description'=>'A collection for a group of people (ie. a internal users)', 'sort_order'=>100,'status_id'=>2,'created_at'=>time(),'created_by'=>1 ]);
                          
    }

    public function down()
    {
        $this->init();
        $this->dropTable($this->tableName); 
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
