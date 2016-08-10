<?php

namespace common\models;

use Yii;
use common\models\User; 
use common\models\RefStatus; 
use common\models\RefSysEvent;  
use common\models\Log;
use common\components\Types; 
use common\components\XActiveRecord; 
/**
 * This is the model class for table "log".
 *
 * @property integer $id
 * @property integer $sys_event_id
 * @property integer $user_id
 * @property string $description
 * @property integer $sort_order
 * @property integer $status_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property User $user
 * @property RefStatus $status
 * @property RefSysEvent $sysEvent
 */
class Log extends XActiveRecord
{
    /**
     * @inheritdoc
     */
    

    
    /* ********************************************************************************* */ 
    /* ********************************************************************************* */ 
    /* ********************************************************************************* */ 
    /* ********************************************************************************* */ 
    /* ********************************************************************************* */ 
     public function behaviors()
    {
        return []; 
    }
    /* ******************************************************************************************************* */ 
    public function init()
    {
        if ($this->isNewRecord)
        {
            $this->created_at = time(); 
            if (yii::$app->user->isGuest)
                $this->created_by = 1; 
        }

        return parent::init(); 
    }
    
    /* ********************************************************************************* */ 
    

    public static function tableName()
    {
        return 'log';
    }
    /* ********************************************************************************* */ 
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sys_event_id', 'user_id',  'status_id'], 'required'],
            [['sys_event_id', 'user_id', 'sort_order', 'status_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['description'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefStatus::className(), 'targetAttribute' => ['status_id' => 'id']],
            [['sys_event_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefSysEvent::className(), 'targetAttribute' => ['sys_event_id' => 'id']],
        ];
    }
    /* ********************************************************************************* */ 
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'sys_event_id' => Yii::t('app', 'Sys Event ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'description' => Yii::t('app', 'Description'),
            'sort_order' => Yii::t('app', 'Sort Order'),
            'status_id' => Yii::t('app', 'Status ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }
    /* ********************************************************************************* */ 
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    /* ********************************************************************************* */ 
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(RefStatus::className(), ['id' => 'status_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSysEvent()
    {
        return $this->hasOne(RefSysEvent::className(), ['id' => 'sys_event_id']);
    }

    /**
     * @inheritdoc
     * @return LogQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new LogQuery(get_called_class());
    }
}
