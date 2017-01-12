<?php

use yii\db\Migration;

class m170112_143822_lab_manager_sapgp4 extends Migration
{
    public function up()
    {
             $auth = \yii::$app->authManager;
             $role = $auth->getRole('admin_role');
            $user = $this->_getUserId('sapgp4'); 

            if ($user)
                    $auth->assign($role, $user);
    }

    public function down()
    {
        echo "m170112_143822_lab_manager_sapgp4 cannot be reverted.\n";

        return false;
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
