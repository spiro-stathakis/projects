<?php

namespace frontend\modules\calendar\models;
use common\models\RefStatus; 
use common\components\XActiveRecord; 
use frontend\modules\calendar\models\Calendar; 
use Yii;

/**
 * This is the model class for table "event".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property integer $calendar_id
 * @property integer $project_id
 * @property integer $sort_order
 * @property integer $status_id
 * @property integer $old_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property RefStatus $status
 * @property Calendar $calendar
 * @property EventEntry[] $eventEntries
 */
class Event extends XActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'event';
    }


     public function init()
        {
            return parent::init(); 

        }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'calendar_id'], 'required'],
            [['calendar_id', 'project_id', 'sort_order', 'status_id', 'old_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['title', 'description'], 'string', 'max' => 2048],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefStatus::className(), 'targetAttribute' => ['status_id' => 'id']],
            [['calendar_id'], 'exist', 'skipOnError' => true, 'targetClass' => Calendar::className(), 'targetAttribute' => ['calendar_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'calendar_id' => Yii::t('app', 'Calendar ID'),
            'project_id' => Yii::t('app', 'Project ID'),
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
    public function getCalendar()
    {
        return $this->hasOne(Calendar::className(), ['id' => 'calendar_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEventEntries()
    {
        return $this->hasMany(EventEntry::className(), ['event_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return EventQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EventQuery(get_called_class());
    }
}
