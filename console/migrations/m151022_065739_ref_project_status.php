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
                        'sort_order'=> $this->integer()->notNull()->defaultValue(2),
                        'status_id'=>$this->integer()->notNull(),
                        'created_at' => $this->integer()->notNull(),
                        'updated_at' => $this->integer(),
                        'created_by' => $this->integer()->notNull(),
                        'updated_by' => $this->integer(),
                    ], 
                    $options 
                );
            $this->addForeignKey('fk_ref_project_status_id' , $this->tableName , 'status_id' , 'ref_status' , 'id' , 'NO ACTION' , 'NO ACTION'); 
            
            $this->insert($this->tableName,['code'=>'null','name'=>'No value','description'=>'No value','sort_order'=>100,'status_id'=>1,'created_at'=>time(),'created_by'=>0 ]); 
            $this->insert($this->tableName,['code'=>'data_collection','name'=>'data_collection', 'description'=>'Project is in data collection stage', 'sort_order'=>100,'status_id'=>2,'created_at'=>time(),'created_by'=>0 ]);
            $this->insert($this->tableName,['code'=>'data_analysis','name'=>'data_analysis','description'=>'Project is in data analysis stage', 'sort_order'=>100,'status_id'=>2,'created_at'=>time(),'created_by'=>0 ]);
            $this->insert($this->tableName,['code'=>'project_concluded','name'=>'project_concluded','description'=>'Project is concluded', 'sort_order'=>100,'status_id'=>2,'created_at'=>time(),'created_by'=>0 ]);  
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
