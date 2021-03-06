<?php
use common\components\XMigration;



class m160802_093525_ref_sys_event extends XMigration
{
    
    public function init()
    {
       $this->tableName = '{{%ref_sys_event}}'; 
       return parent::init();  
    }


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

            $this->addForeignKey('fk_ref_sys_event_status_id' , $this->tableName,  'status_id' , 'ref_status' , 'id' , 'NO ACTION' , 'NO ACTION'); 
        
            $this->insert($this->tableName,['code'=>'null','name'=>'No value','description'=>'No value','sort_order'=>100,'status_id'=>1,'created_at'=>time(),'created_by'=>1 ]); 
            $this->insert($this->tableName,['code'=>'user_activated','name'=>'User activated','description'=>'user_activated', 'sort_order'=>100,'status_id'=>2,'created_at'=>time(),'created_by'=>1 ]);
            $this->insert($this->tableName,['code'=>'user_deactivated','name'=>'User deactivated','description'=>'User deactivated', 'sort_order'=>100,'status_id'=>2,'created_at'=>time(),'created_by'=>1 ]);
            $this->insert($this->tableName,['code'=>'email_send','name'=>'Sent an email','description'=>'Send email', 'sort_order'=>100,'status_id'=>2,'created_at'=>time(),'created_by'=>1 ]);


    }

    public function down()
    {
        
        $this->init(); 
        $this->dropForeignKey('fk_ref_sys_event_status_id',$this->tableName); 
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
