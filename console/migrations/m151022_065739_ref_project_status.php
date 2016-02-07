<?php

use common\components\XMigration;


class m151022_065739_ref_project_status extends XMigration
{
    



    /* ************************************************************************************** */ 

    
    public function init()
    {
       $this->tableName = 'ref_project_status'; 
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
                    $options 
                );
            $this->addForeignKey('fk_ref_project_status_id' , $this->tableName , 'status_id' , 'ref_status' , 'id' , 'NO ACTION' , 'NO ACTION'); 
            
            $this->insert($this->tableName,['code'=>'null','name'=>'No value','description'=>'No value','sort_order'=>100,'status_id'=>1,'created_at'=>time(),'created_by'=>1 ]); 
            $this->insert($this->tableName,['code'=>'in_progress','name'=>'in_progress', 'description'=>'Project is in progress', 'sort_order'=>100,'status_id'=>2,'created_at'=>time(),'created_by'=>1 ]);
            $this->insert($this->tableName,['code'=>'complete','name'=>'complete','description'=>'Project is complete', 'sort_order'=>100,'status_id'=>2,'created_at'=>time(),'created_by'=>1 ]);
            $this->insert($this->tableName,['code'=>'withdrawn','name'=>'withdrawn','description'=>'Project is withdrawn', 'sort_order'=>100,'status_id'=>2,'created_at'=>time(),'created_by'=>1 ]); 
            $this->insert($this->tableName,['code'=>'dormant','name'=>'dormant','description'=>'Project is dormant', 'sort_order'=>100,'status_id'=>2,'created_at'=>time(),'created_by'=>1 ]);  
    }
    /* ************************************************************************************** */ 

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
