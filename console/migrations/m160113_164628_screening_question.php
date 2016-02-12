<?php


use common\components\XMigration;

class m160113_164628_screening_question extends XMigration
{

    /* ************************************************************************************** */ 

    public function init()
    {
       $this->tableName = '{{%screening_question}}'; 
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
                    'caption'=>$this->string(4096),
                    'content'=>$this->string(4096)->notNull(),
                    'input_type_id' => $this->integer()->notNull(),
                    'screening_form_id'=>$this->integer()->notNull(),
                    'tristate_option_id'=>$this->integer()->notNull(1), 
                    'prefix_text'=>$this->string(128)->defaultValue(''),  
                    'suffix_text'=>$this->string(128)->defaultValue(''),     
                    'sort_order' => $this->integer()->notNull()->defaultValue(100), 
                    'status_id'=>$this->integer()->notNull()->defaultValue(2),
                    'created_at' => $this->integer()->notNull(),
                    'updated_at' => $this->integer(),
                    'created_by' => $this->integer()->notNull(),
                    'updated_by' => $this->integer(),
                ], 
                $this->mysqlOptions 
            );

        $this->addForeignKey('fk_screening_question_input_type_id' , $this->tableName,  'input_type_id' , 'ref_input_type' , 'id' , 'NO ACTION' , 'NO ACTION'); 
        $this->addForeignKey('fk_screening_question_screening_form_id' , $this->tableName,  'screening_form_id' , 'screening_form' , 'id' , 'NO ACTION' , 'NO ACTION'); 
        $this->addForeignKey('fk_screening_question_tristate_option_id' , $this->tableName,  'tristate_option_id' , 'ref_boolean' , 'id' , 'NO ACTION' , 'NO ACTION'); 
        $this->addForeignKey('fk_screening_question_status_id' , $this->tableName,  'status_id' , 'ref_status' , 'id' , 'NO ACTION' , 'NO ACTION'); 
        

        $this->insert($this->tableName,['caption'=>'Participant',
                                    'content'=>'The MRI system uses magnetic and radio frequency fields that may be hazardous to certain individuals, such as those who have metallic, electronic, magnetic or mechanical implants, devices, or accessories.  It is therefore vital that formal comprehensive MRI screening and safety evaluation is carried out before entering the magnet environment.',
                                    'input_type_id'=>7,
                                    'screening_form_id'=>1,
                                    'tristate_option_id'=>1, 
                                    'sort_order'=>10, 
                                    'status_id'=>2, 
                                    'created_at'=>time(),
                                    'updated_at'=>0, 
                                    'created_by'=>1, 
                                    'updated_by'=>0,  
                                ]); 
          
          $this->insert($this->tableName,['caption'=>'',
                                    'content'=>'Do you have, or have you ever had, a cardiac (heart) device or pacemaker?',
                                    'input_type_id'=>6,
                                    'screening_form_id'=>1,
                                    'tristate_option_id'=>1, 
                                    'sort_order'=>20, 
                                    'status_id'=>2, 
                                    'created_at'=>time(),
                                    'updated_at'=>0, 
                                    'created_by'=>1, 
                                    'updated_by'=>0,  
                                ]); 

          $this->insert($this->tableName,['caption'=>'',
                                    'content'=>'Have you ever had any cardiac surgery, or a cardiac stent/implant/device?',
                                    'input_type_id'=>6,
                                    'screening_form_id'=>1,
                                    'tristate_option_id'=>1, 
                                    'sort_order'=>30, 
                                    'status_id'=>2, 
                                    'created_at'=>time(),
                                    'updated_at'=>0, 
                                    'created_by'=>1, 
                                    'updated_by'=>0,  
                                ]); 

           $this->insert($this->tableName,['caption'=>'',
                                    'content'=>'Do you have a heart arrhythmia (irregular heart beat) condition?',
                                    'input_type_id'=>6,
                                    'screening_form_id'=>1,
                                    'tristate_option_id'=>1, 
                                    'sort_order'=>40, 
                                    'status_id'=>2, 
                                    'created_at'=>time(),
                                    'updated_at'=>0, 
                                    'created_by'=>1, 
                                    'updated_by'=>0,  
                                ]); 

        $this->insert($this->tableName,['caption'=>'',
                                    'content'=>'Have you ever had any surgery to your neck, head or brain?',
                                    'input_type_id'=>6,
                                    'screening_form_id'=>1,
                                    'tristate_option_id'=>1, 
                                    'sort_order'=>50, 
                                    'status_id'=>2, 
                                    'created_at'=>time(),
                                    'updated_at'=>0, 
                                    'created_by'=>1, 
                                    'updated_by'=>0,  
                                ]); 

        $this->insert($this->tableName,['caption'=>'MRI staff',
                                    'content'=>'Participant/Patient Weight (kg)',
                                    'input_type_id'=>2,
                                    'screening_form_id'=>1,
                                    'tristate_option_id'=>1, 
                                    'sort_order'=>60,
                                    'suffix_text'=>'kilos',  
                                    'status_id'=>2, 
                                    'created_at'=>time(),
                                    'updated_at'=>0, 
                                    'created_by'=>1, 
                                    'updated_by'=>0,  
                                ]); 

        $this->insert($this->tableName,['caption'=>'',
                                    'content'=>'Participant/Patient Height (m)',
                                    'input_type_id'=>2,
                                    'screening_form_id'=>1,
                                    'tristate_option_id'=>1, 
                                    'sort_order'=>70,
                                    'suffix_text'=>'meters', 
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
        $this->dropForeignKey('fk_screening_question_input_type_id',$this->tableName); 
        $this->dropForeignKey('fk_screening_question_screening_form_id',$this->tableName); 
        $this->dropForeignKey('fk_screening_question_status_id',$this->tableName); 
        
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
