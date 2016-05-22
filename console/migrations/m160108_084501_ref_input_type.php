<?php

use common\components\XMigration;


class m160108_084501_ref_input_type extends XMigration
{

/* ************************************************************************************** */ 

    
    public function init()
    {
       $this->tableName = '{{%ref_input_type}}'; 
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
            $this->addForeignKey('fk_ref_input_type_status_id' , $this->tableName , 'status_id' , 'ref_status' , 'id' , 'NO ACTION' , 'NO ACTION'); 
            
            $this->insert($this->tableName,['code'=>'null','name'=>'No value','description'=>'No value','sort_order'=>100,'status_id'=>1,'created_at'=>time(),'created_by'=>1 ]); 
            $this->insert($this->tableName,['code'=>'small_text','name'=>'Small text','description'=>'Small text field', 'sort_order'=>100,'status_id'=>2,'created_at'=>time(),'created_by'=>1 ]);
            $this->insert($this->tableName,['code'=>'med_text','name'=>'Medium text','description'=>'Medium text field', 'sort_order'=>100,'status_id'=>2,'created_at'=>time(),'created_by'=>1 ]);
            $this->insert($this->tableName,['code'=>'large_text','name'=>'Large text','description'=>'Large text field', 'sort_order'=>100,'status_id'=>2,'created_at'=>time(),'created_by'=>1 ]);  
            $this->insert($this->tableName,['code'=>'date','name'=>'Date field','description'=>'Date field', 'sort_order'=>100,'status_id'=>2,'created_at'=>time(),'created_by'=>1 ]); 
            $this->insert($this->tableName,['code'=>'radio','name'=>'Radio field','description'=>'Radio field for true / false responses', 'sort_order'=>100,'status_id'=>2,'created_at'=>time(),'created_by'=>1 ]);  
            $this->insert($this->tableName,['code'=>'text_agreement','name'=>'Text agreement','description'=>'Text agreement', 'sort_order'=>100,'status_id'=>2,'created_at'=>time(),'created_by'=>1 ]);  
            $this->insert($this->tableName,['code'=>'image_overlay','name'=>'Image overlay','description'=>'An image that imposes user provided overlay data', 'sort_order'=>100,'status_id'=>2,'created_at'=>time(),'created_by'=>1 ]);  
            $this->insert($this->tableName,['code'=>'text_area','name'=>'Text area','description'=>'Text area', 'sort_order'=>100,'status_id'=>2,'created_at'=>time(),'created_by'=>1 ]);  

    }
  /* ************************************************************************************** */ 

    public function down()
    {
        $this->init();
        $this->dropForeignKey('fk_ref_input_type_status_id',$this->tableName); 
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
