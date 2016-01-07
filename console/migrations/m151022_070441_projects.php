<?php

use common\components\XMigration;


class m151022_070441_projects extends XMigration
{
    
    /* ************************************************************************************** */ 

    
    public function init()
    {
       $this->tableName = 'projects'; 
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
                        'study_name'=>$this->string(255)->notNull(),
                        'funding_source'=>$this->string(255)->notNull(),
                        'funding_code'=>$this->string(255)->notNull(),
                        'app_received'=>$this->integer()->notNull(),
                        'cog_approval'=>$this->integer()->notNull(),
                        'presentation'=>$this->integer()->notNull(),
                        'ethics_approval'=>$this->integer()->notNull(),
                        'ethics_number'=>$this->string(255)->notNull(),
                        'risk_assesment'=>$this->integer()->notNull(),
                        'rules_procedure'=>$this->integer()->notNull(),
                        'mri_time'=>$this->integer()->notNull(),
                        'meg_time'=>$this->integer()->notNull(),
                        'project_code'=>$this->string(255)->notNull(),
                        'old_study_id'=>$this->integer()->notNull(),
                        'project_status_id'=>$this->integer()->notNull(),
                        'sort_order'=> $this->integer()->notNull()->defaultValue(2),
                        'status_id'=>$this->integer()->notNull(),
                        'created_at' => $this->integer()->notNull(),
                        'updated_at' => $this->integer(),
                        'created_by' => $this->integer()->notNull(),
                        'updated_by' => $this->integer(),
                    ], 
                    $this->mysqlOptions 
                );
            $this->addForeignKey('fk_projects_status_id' , $this->tableName,  'status_id' , 'ref_status' , 'id' , 'NO ACTION' , 'NO ACTION'); 
            $this->addForeignKey('fk_projects_project_status_id' , $this->tableName,  'project_status_id' , 'ref_project_status' , 'id' , 'NO ACTION' , 'NO ACTION'); 
            
            
    
    }

    public function down()
    {
        $this->init();
        $this->dropForeignKey('fk_projects_status_id',$this->tableName); 
        $this->dropForeignKey('fk_projects_project_status_id',$this->tableName); 
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
