<?php

namespace frontend\modules\calendar\models;
use common\models\RefStatus; 
use common\models\RefBoolean; 
use common\models\RefBookingStatus; 
use common\components\Types; 
use common\components\XActiveRecord; 
use frontend\modules\calendar\models\Event; 
use Yii;

/**
 * This is the model class for table "event_entry".
 *
 * @property integer $id
 * @property integer $event_id
 * @property string $title
 * @property string $description
 * @property integer $booking_status_id
 * @property integer $start_timestamp
 * @property integer $end_timestamp
 * @property integer $all_day_option_id
 * @property integer $confirm_by
 * @property integer $confirm_date
 * @property integer $sort_order
 * @property integer $status_id
 * @property integer $old_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property RefStatus $status
 * @property RefBoolean $allDayOption
 * @property RefBookingStatus $bookingStatus
 * @property Event $event
 */
class EventEntry extends XActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'event_entry';
    }


    public function init()
    {
        parent::init();
        if ($this->isNewRecord)
        {
            $this->booking_status_id = Types::$bookingStatus['confirmed']['id']; 
            $this->all_day_option_id = Types::$boolean['false']['id']; 
        } 
          
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['event_id', 'title', 'booking_status_id', 'start_timestamp', 'end_timestamp', 'all_day_option_id'], 'required'],
            [['event_id', 'booking_status_id', 'start_timestamp', 'end_timestamp', 'all_day_option_id', 'confirm_by', 'confirm_date', 'sort_order', 'status_id', 'old_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['title', 'description'], 'string', 'max' => 2048],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefStatus::className(), 'targetAttribute' => ['status_id' => 'id']],
            [['all_day_option_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefBoolean::className(), 'targetAttribute' => ['all_day_option_id' => 'id']],
            [['booking_status_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefBookingStatus::className(), 'targetAttribute' => ['booking_status_id' => 'id']],
            [['event_id'], 'exist', 'skipOnError' => true, 'targetClass' => Event::className(), 'targetAttribute' => ['event_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'event_id' => Yii::t('app', 'Event ID'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'booking_status_id' => Yii::t('app', 'Booking Status ID'),
            'start_timestamp' => Yii::t('app', 'Start Timestamp'),
            'end_timestamp' => Yii::t('app', 'End Timestamp'),
            'all_day_option_id' => Yii::t('app', 'All Day Option ID'),
            'confirm_by' => Yii::t('app', 'Confirm By'),
            'confirm_date' => Yii::t('app', 'Confirm Date'),
            'sort_order' => Yii::t('app', 'Sort Order'),
            'status_id' => Yii::t('app', 'Status ID'),
            'old_id' => Yii::t('app', 'Old ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
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
    public function getAllDayOption()
    {
        return $this->hasOne(RefBoolean::className(), ['id' => 'all_day_option_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBookingStatus()
    {
        return $this->hasOne(RefBookingStatus::className(), ['id' => 'booking_status_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvent()
    {
        return $this->hasOne(Event::className(), ['id' => 'event_id']);
    }

    /**
     * @inheritdoc
     * @return EventEntryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EventEntryQuery(get_called_class());
    }
}
