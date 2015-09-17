<?php

use yii\db\Migration;

class m150915_100034_init_ref_status extends Migration
{
    public function up()
    {
            
            $options = ''; 
            if ($this->db->driverName === 'mysql')
                 $options = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB'; 

            $this->createTable(
                    '{{%ref_status}}', 
                    [
                        'id'=>$this->primaryKey(),
                        'code'=>$this->string(255)->notNull(),
                        'name'=>$this->string(255)->notNull(),
                        'description'=>$this->string(255)->notNull(),
                        'sort_order'=> $this->integer()->notNull()->defaultValue(2),
                        'status_id'=>$this->integer()->notNull(),
                    ], 
                    $options 
                );

            $this->insert('{{%ref_project_type}}',['code'=>'null','name'=>'No value','description'=>'No value','sort_order'=>100,'status_id'=>1]); 
            $this->insert('{{%ref_project_type}}',['code'=>'active','name'=>'Active','description'=>'Active', 'sort_order'=>100,'status_id'=>2]);
            $this->insert('{{%ref_project_type}}',['code'=>'inactive','name'=>'Inactive','description'=>'Inactive', 'sort_order'=>100,'status_id'=>2]);  
    
    }

    public function down()
    {
        
        $this->dropTable('{{%ref_status}}'); 
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
