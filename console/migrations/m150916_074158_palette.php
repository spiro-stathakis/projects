<?php
use common\components\XMigration;


use yii\db\Migration;

class m150916_074158_palette extends XMigration
{
    
     public function init()
    {
       $this->tableName = '{{%palette}}'; 
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
                        'hex_code'=>$this->string(255)->notNull(),
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
            $this->addForeignKey('fk_palette_status_id' , $this->tableName , 'status_id' , 'ref_status' , 'id' , 'NO ACTION' , 'NO ACTION'); 
            
            $this->insert($this->tableName,['hex_code'=>'A32929','name'=>'','description'=>'', 'sort_order'=>100,'status_id'=>2,'created_at'=>time(),'created_by'=>1 ]);
            $this->insert($this->tableName,['hex_code'=>'B1365F','name'=>'','description'=>'', 'sort_order'=>100,'status_id'=>2,'created_at'=>time(),'created_by'=>1 ]);
            $this->insert($this->tableName,['hex_code'=>'7A367A','name'=>'','description'=>'', 'sort_order'=>100,'status_id'=>2,'created_at'=>time(),'created_by'=>1 ]);
            $this->insert($this->tableName,['hex_code'=>'5229A3','name'=>'','description'=>'', 'sort_order'=>100,'status_id'=>2,'created_at'=>time(),'created_by'=>1 ]);
            $this->insert($this->tableName,['hex_code'=>'29527A','name'=>'','description'=>'', 'sort_order'=>100,'status_id'=>2,'created_at'=>time(),'created_by'=>1 ]);
            $this->insert($this->tableName,['hex_code'=>'2952A3','name'=>'','description'=>'', 'sort_order'=>100,'status_id'=>2,'created_at'=>time(),'created_by'=>1 ]);
            $this->insert($this->tableName,['hex_code'=>'1B887A','name'=>'','description'=>'', 'sort_order'=>100,'status_id'=>2,'created_at'=>time(),'created_by'=>1 ]);
            $this->insert($this->tableName,['hex_code'=>'28754E','name'=>'','description'=>'', 'sort_order'=>100,'status_id'=>2,'created_at'=>time(),'created_by'=>1 ]);
            $this->insert($this->tableName,['hex_code'=>'0D7813','name'=>'','description'=>'', 'sort_order'=>100,'status_id'=>2,'created_at'=>time(),'created_by'=>1 ]);
            $this->insert($this->tableName,['hex_code'=>'528800','name'=>'','description'=>'', 'sort_order'=>100,'status_id'=>2,'created_at'=>time(),'created_by'=>1 ]);
            $this->insert($this->tableName,['hex_code'=>'88880E','name'=>'','description'=>'', 'sort_order'=>100,'status_id'=>2,'created_at'=>time(),'created_by'=>1 ]);
            $this->insert($this->tableName,['hex_code'=>'AB8B00','name'=>'','description'=>'', 'sort_order'=>100,'status_id'=>2,'created_at'=>time(),'created_by'=>1 ]);
            $this->insert($this->tableName,['hex_code'=>'BE6D00','name'=>'','description'=>'', 'sort_order'=>100,'status_id'=>2,'created_at'=>time(),'created_by'=>1 ]);
            $this->insert($this->tableName,['hex_code'=>'B1440E','name'=>'','description'=>'', 'sort_order'=>100,'status_id'=>2,'created_at'=>time(),'created_by'=>1 ]);
            $this->insert($this->tableName,['hex_code'=>'865A5A','name'=>'','description'=>'', 'sort_order'=>100,'status_id'=>2,'created_at'=>time(),'created_by'=>1 ]);
            $this->insert($this->tableName,['hex_code'=>'4E5D6C','name'=>'','description'=>'', 'sort_order'=>100,'status_id'=>2,'created_at'=>time(),'created_by'=>1 ]);
            $this->insert($this->tableName,['hex_code'=>'705770','name'=>'','description'=>'', 'sort_order'=>100,'status_id'=>2,'created_at'=>time(),'created_by'=>1 ]);
            $this->insert($this->tableName,['hex_code'=>'5A6986','name'=>'','description'=>'', 'sort_order'=>100,'status_id'=>2,'created_at'=>time(),'created_by'=>1 ]);
            $this->insert($this->tableName,['hex_code'=>'4A716C','name'=>'','description'=>'', 'sort_order'=>100,'status_id'=>2,'created_at'=>time(),'created_by'=>1 ]);
            $this->insert($this->tableName,['hex_code'=>'6E6E41','name'=>'','description'=>'', 'sort_order'=>100,'status_id'=>2,'created_at'=>time(),'created_by'=>1 ]);
            $this->insert($this->tableName,['hex_code'=>'8D6F47','name'=>'','description'=>'', 'sort_order'=>100,'status_id'=>2,'created_at'=>time(),'created_by'=>1 ]);

    }
    /* ************************************************************************************** */ 

    /* ************************************************************************************** */ 

   
    public function down()
    {
        
        $this->init();
        $this->dropForeignKey('fk_palette_status_id',$this->tableName); 
       

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
