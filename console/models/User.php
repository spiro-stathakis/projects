<?php

namespace console\models;
use \common\components\Types;
use \common\models\RefAuthType;
use Yii;

/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property integer $auth_id
 * @property string $user_name
 * @property string $email
 * @property string $first_name
 * @property string $last_name
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property integer $old_id
 * @property integer $reg_date
 * @property integer $status_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property LnkProjectAssoc[] $lnkProjectAssocs
 * @property RefAuthType $auth
 * @property RefStatus $status
 */
class User extends \common\models\User
{
   

  

   /* ***************************************************************** */
    public function beforeSave($insert)
    {
            
            return true; 
    }
    /* ***************************************************************** */
    
}
