<?php

use yii\db\Migration;
use \common\models\User; 
class m160712_222123_super_role extends Migration
{
    public function up()
    {

        $auth = \yii::$app->authManager;
        $super_manager = $auth->getRole('super_manager');
        if (!$super_manager) {
            throw new InvalidParamException("There is no role \"$super_manager\".");
        }

        $user = User::find()->where(['user_name' => 'sapss8'])->one();
        $auth->assign($super_manager, $user->id);
        
        $user = User::find()->where(['user_name' => 'scmcc2'])->one();
        $auth->assign($super_manager, $user->id);
        
    }
/* *****************************************************************  */
    public function down()
    {
        echo "m160712_222123_super_role cannot be reverted.\n";

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
