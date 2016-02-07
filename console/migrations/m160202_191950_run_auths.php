<?php

use common\components\XMigration;


class m160202_191950_run_auths extends XMigration
{


    public function up()
    {

        $auth = Yii::$app->getAuthManager();
        $role = $auth->createRole('admin_screening');
        //$auth->assign($role, 44);

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
