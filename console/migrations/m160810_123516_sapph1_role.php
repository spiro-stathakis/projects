<?php

use yii\db\Migration;
use \common\models\User; 
class m160810_123516_sapph1_role extends Migration
{
    public function up()
    {

        $auth = \yii::$app->authManager;
        $role = $auth->getRole('lab_manager_role');
        if (!$role) {
            throw new InvalidParamException("There is no role \"$role\".");
        }

        $user = User::find()->where(['user_name' => 'sapph1'])->one();
        $auth->assign($role, $user->id);
        
        
        
    }
/* *****************************************************************  */
    public function down()
    {
        echo "m160810_123516_sapph1_role cannot be reverted.\n";

        return false;
    }

/* *****************************************************************  */
  

   /* *****************************************************************  */ 
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
