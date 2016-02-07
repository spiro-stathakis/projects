<?php

use common\components\XMigration;


class m150915_110034_ref_auth_type extends XMigration
{
    

 /* ************************************************************************************** */ 

    public function init()
    {
       $this->tableName = '{{%ref_auth_type}}'; 
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
            $this->insert($this->tableName,['code'=>'ldap','name'=>'LDAP','description'=>'LDAP authentication', 'sort_order'=>100,'status_id'=>2,'created_at'=>time(),'created_by'=>1]);
            $this->insert($this->tableName,['code'=>'db','name'=>'DB','description'=>'Database authentication', 'sort_order'=>100,'status_id'=>2,'created_at'=>time(),'created_by'=>1 ]);
                  

    }

    public function down()
    {
        $this->init();
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
