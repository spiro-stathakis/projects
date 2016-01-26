<?php

use common\components\XMigration;


class m160108_161327_subject extends XMigration
{
   

   /* ************************************************************************************** */ 

    
    public function init()
    {
       $this->tableName = '{{%subject}}'; 
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
                        'cubric_id'=>$this->string(255)->notNull(),
                        'first_name'=>$this->string(255)->notNull(),
                        'last_name'=>$this->string(255)->notNull(),
                        'dob'=>$this->date('%d/%m/%Y')->notNull(),
                        'hash'=>$this->string(255)->notNull()->unique(), 
                        'email'=>$this->string(255),
                        'telephone'=>$this->string(255),
                        'address'=>$this->string(255),
                        'gp_opt_id'=>$this->integer()->notNull(),
                        'email_opt_id'=>$this->integer()->notNull(),
                        'sex_id'=>$this->integer()->notNull(),
                        'old_id'=>$this->integer()->notNull(),
                        'sort_order'=> $this->integer()->notNull()->defaultValue(2),
                        'status_id'=>$this->integer()->notNull(),
                        'created_at' => $this->integer()->notNull(),
                        'updated_at' => $this->integer(),
                        'created_by' => $this->integer()->notNull(),
                        'updated_by' => $this->integer(),
                    ], 
                    $this->mysqlOptions 
                );
            $this->addForeignKey('fk_subjects_status_id' , $this->tableName,  'status_id' , 'ref_status' , 'id' , 'NO ACTION' , 'NO ACTION'); 
            $this->addForeignKey('fk_subjects_gp_opt_id' , $this->tableName,  'gp_opt_id' , 'ref_boolean' , 'id' , 'NO ACTION' , 'NO ACTION'); 
            $this->addForeignKey('fk_subjects_email_opt_id' , $this->tableName,  'email_opt_id' , 'ref_boolean' , 'id' , 'NO ACTION' , 'NO ACTION'); 
            $this->addForeignKey('fk_subjects_sex_id_id' , $this->tableName,  'sex_id' , 'ref_sex' , 'id' , 'NO ACTION' , 'NO ACTION'); 
             $this->execute('CALL sp_import_subjects();')  ;
        
            
    
    }
    /* ************************************************************************************** */ 
    

    public function down()
    {
        $this->init(); 
        $this->dropForeignKey('fk_subjects_status_id',$this->tableName); 
        $this->dropForeignKey('fk_subjects_gp_opt_id',$this->tableName); 
        $this->dropForeignKey('fk_subjects_email_opt_id',$this->tableName); 
        $this->dropForeignKey('fk_subjects_sex_id_id',$this->tableName); 
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
