<?php

namespace frontend\modules\calendar\models;

use Yii;
use common\models\RefBoolean; 
use common\models\RefStatus;
use common\models\User; 
use frontend\modules\calendar\models\Calendar; 
/**
 * This is the model class for table "calendar_subscription".
 *
 * @property integer $id
 * @property integer $calendar_id
 * @property integer $user_id
 * @property integer $display_option_id
 * @property integer $sort_order
 * @property integer $status_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property RefBoolean $displayOption
 * @property Calendar $calendar
 * @property RefStatus $status
 * @property User $user
 */
class CalendarSubscription extends \common\components\XActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'calendar_subscription';
    }

    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['calendar_id', 'user_id', 'display_option_id'], 'required'],
            [['calendar_id', 'user_id', 'display_option_id', 'sort_order', 'status_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['display_option_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefBoolean::className(), 'targetAttribute' => ['display_option_id' => 'id']],
            [['calendar_id'], 'exist', 'skipOnError' => true, 'targetClass' => Calendar::className(), 'targetAttribute' => ['calendar_id' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefStatus::className(), 'targetAttribute' => ['status_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'calendar_id' => 'Calendar ID',
            'user_id' => 'User ID',
            'display_option_id' => 'Display Option ID',
            'sort_order' => 'Sort Order',
            'status_id' => 'Status ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDisplayOption()
    {
        return $this->hasOne(RefBoolean::className(), ['id' => 'display_option_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCalendar()
    {
        return $this->hasOne(Calendar::className(), ['id' => 'calendar_id']);
    }

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
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @inheritdoc
     * @return CalendarSubscriptionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CalendarSubscriptionQuery(get_called_class());
    }
}
