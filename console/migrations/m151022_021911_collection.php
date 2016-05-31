<?php

use common\components\XMigration;


class m151022_021911_collection extends XMigration
{


    /* ************************************************************************************** */ 

    public function init()
    {
       $this->tableName = '{{%collection}}'; 
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
                    'title'=>$this->string(255)->notNull(),
                    'alias'=>$this->string(255),
                    'description'=>$this->string(4096),
                    'collection_type_id' => $this->integer()->notNull(),
                    'public_option_id' => $this->integer()->notNull(),
                    'membership_duration'=> $this->integer()->notNull()->defaultValue(5256000),
                    'member_count' => $this->integer()->notNull()->defaultValue(0),
                    'manager_count'=>$this->integer()->notNull()->defaultValue(0),
                    'sort_order'=> $this->integer()->notNull()->defaultValue(100),
                    'status_id'=>$this->integer()->notNull()->defaultValue(2),
                    'created_at' => $this->integer()->notNull(),
                    'updated_at' => $this->integer(),
                    'created_by' => $this->integer()->notNull(),
                    'updated_by' => $this->integer(),
                ], 
                $this->mysqlOptions 
            );

        $this->addForeignKey('fk_collection_status_id' , $this->tableName,  'status_id' , 'ref_status' , 'id' , 'NO ACTION' , 'NO ACTION'); 
        $this->addForeignKey('fk_collection_type_id' , $this->tableName,  'collection_type_id' , 'ref_collection_type' , 'id' , 'NO ACTION' , 'NO ACTION');
        $this->addForeignKey('fk_collection_public_option_id' , $this->tableName,  'public_option_id' , 'ref_boolean' , 'id' , 'NO ACTION' , 'NO ACTION'); 
                   
        $this->insert($this->tableName,['title'=>'MRI',
                                    'description'=>'A collection of resources that are managed through the MRI lab',
                                    'alias'=>'mri', 
                                    'collection_type_id'=>2,
                                    'public_option_id'=>3, 
                                    'membership_duration'=>365,
                                    'member_count'=>0,
                                    'manager_count'=>0, 
                                    'sort_order'=>100, 
                                    'status_id'=>2, 
                                    'created_at'=>time(),
                                    'updated_at'=>0, 
                                    'created_by'=>1, 
                                    'updated_by'=>0,  
                                ]); 
         
         $this->insert($this->tableName,['title'=>'Park place',
                                    'description'=>'A collection of resources that belong to the Park place site',
                                    'alias'=>'park-place', 
                                    'collection_type_id'=>4,
                                    'public_option_id'=>3, 
                                    'membership_duration'=>365,
                                    'member_count'=>0,
                                    'manager_count'=>0, 
                                    'sort_order'=>100, 
                                    'status_id'=>2, 
                                    'created_at'=>time(),
                                    'updated_at'=>0, 
                                    'created_by'=>1, 
                                    'updated_by'=>0,  
                                ]);       
        $this->insert($this->tableName,['title'=>'CUBRIC internal',
                                    'description'=>'CUBRIC group for users in Cardiff University',
                                    'alias'=>'cubric-int', 
                                    'collection_type_id'=>4,
                                    'public_option_id'=>3, 
                                    'membership_duration'=>365,
                                    'member_count'=>0,
                                    'manager_count'=>0, 
                                    'sort_order'=>100, 
                                    'status_id'=>2, 
                                    'created_at'=>time(),
                                    'updated_at'=>0, 
                                    'created_by'=>1, 
                                    'updated_by'=>0,  
                                ]); 

    }
    /* ************************************************************************************** */
    
    public function down()
    {
        

        $this->init();
        $this->dropForeignKey('fk_collection_status_id',$this->tableName); 
        $this->dropForeignKey('fk_collection_type_id',$this->tableName); 
        $this->dropForeignKey('fk_collection_public_option_id',$this->tableName); 
        
        $this->dropTable($this->tableName); 
        return true;
    }
  /* ************************************************************************************** */
  
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
