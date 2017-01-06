<?php

use yii\db\Migration;
use \common\models\User; 
class m170106_095109_sapcs5_role extends Migration
{
    public function up()
    {

        $auth = \yii::$app->authManager;
        $role = $auth->getRole('admin_role');
        if (!$role) {
            throw new InvalidParamException("There is no role \"$role\".");
        }

        $user = User::find()->where(['user_name' => 'sapcs5'])->one();
        if ($user !== null)
            $auth->assign($role, $user->id);
        
        
        $user = User::find()->where(['user_name' => 'sapzh1'])->one();
        
        if ($user !== null)
            $auth->assign($role, $user->id);
        
        
    }
/* *****************************************************************  */
    public function down()
    {
        echo "m170106_095109_sapcs5_role cannot be reverted.\n";

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
