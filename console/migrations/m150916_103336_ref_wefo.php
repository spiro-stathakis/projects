<?php

use common\components\XMigration;




class m150916_103336_ref_wefo extends XMigration
{


    /* ************************************************************************************** */ 

    
    public function init()
    {
       $this->tableName = '{{%ref_wefo}}'; 
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
            $this->addForeignKey('fk_ref_wefo_type_status_id' , $this->tableName , 'status_id' , 'ref_status' , 'id' , 'NO ACTION' , 'NO ACTION'); 
            
            $this->insert($this->tableName,['code'=>'null','name'=>'No value','description'=>'No value','sort_order'=>100,'status_id'=>1,'created_at'=>time(),'created_by'=>0 ]); 
            $this->insert($this->tableName,['code'=>'internal_research','name'=>'Internal research','description'=>'Internal University funded research - non economic', 'sort_order'=>100,'status_id'=>2,'created_at'=>time(),'created_by'=>0 ]);
            $this->insert($this->tableName,['code'=>'external_research','name'=>'External research','description'=>'External grant funded research - non economic', 'sort_order'=>100,'status_id'=>2,'created_at'=>time(),'created_by'=>0 ]);
            $this->insert($this->tableName,['code'=>'external_commercial_research','name'=>'External research','description'=>'External [contracts/service/consultancy] funded research - economic', 'sort_order'=>100,'status_id'=>2,'created_at'=>time(),'created_by'=>0 ]);  
    }
    /* ************************************************************************************** */ 

    public function down()
    {
        
        $this->init();
        $this->dropForeignKey('fk_ref_wefo_type_status_id',$this->tableName); 
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
