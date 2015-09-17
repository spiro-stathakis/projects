<?php

use yii\db\Migration;

class m150916_103336_ref_project_type extends Migration
{
    public function up()
    {
        $options = ''; 
            if ($this->db->driverName === 'mysql')
                 $options = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB'; 

            $this->createTable(
                    '{{%ref_project_type}}', 
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
            $this->addForeignKey('fk_ref_project_type_status_id' , 'ref_project_type' , 'status_id' , 'ref_status' , 'id' , 'NO ACTION' , 'NO ACTION'); 
            
            $this->insert('{{%ref_project_type}}',['code'=>'null','name'=>'No value','description'=>'No value','sort_order'=>100,'status_id'=>1]); 
            $this->insert('{{%ref_project_type}}',['code'=>'internal_research','name'=>'Internal research','description'=>'Internal University funded research - non economic', 'sort_order'=>100,'status_id'=>2]);
            $this->insert('{{%ref_project_type}}',['code'=>'external_research','name'=>'External research','description'=>'External grant funded research - non economic', 'sort_order'=>100,'status_id'=>2]);
            $this->insert('{{%ref_project_type}}',['code'=>'external_commercial_research','name'=>'External research','description'=>'External [contracts/service/consultancy] funded research - economic', 'sort_order'=>100,'status_id'=>2]);  
    }

    public function down()
    {
        
        $this->dropTable('{{%ref_project_type}}'); 
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
