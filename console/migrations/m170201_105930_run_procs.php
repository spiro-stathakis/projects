<?php

use yii\db\Migration;

class m170201_105930_run_procs extends Migration
{
    public function up()
    {
            
            $this->execute('CALL sp_import_projects();');
            $this->execute('CALL sp_import_subjects();');
            # $this->execute('CALL sp_import_calendars();');
            $this->execute('CALL sp_inserts()'); 
            # $this->execute('CALL sp_import_events()'); 
            # $this->execute('CALL sp_import_event_entry()'); 
            
    }

    public function down()
    {
        

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

