<?php

namespace frontend\modules\calendar\models;

use Yii;
use common\models\RefBoolean; 
use common\models\Collection; 
use common\models\Palette; 
use common\models\RefStatus; 
use common\components\Types; 
use yii\behaviors\TimestampBehavior; 
use yii\behaviors\BlameableBehavior; 


/**
 * This is the model class for table "calendar".
 *
 * @property integer $id
 * @property integer $collection_id
 * @property string $title
 * @property string $description
 * @property string $location
 * @property string $start_hour
 * @property string $start_min
 * @property string $end_hour
 * @property string $end_min
 * @property integer $hex_code
 * @property integer $project_option_id
 * @property integer $allow_overlap_option_id
 * @property integer $read_only_option_id
 * @property integer $advance_limit
 * @property integer $old_id
 * @property integer $sort_order
 * @property integer $status_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property RefBoolean $allowOverlapOption
 * @property Collection $collection
 * @property Palette $palette
 * @property RefBoolean $projectOption
 * @property RefBoolean $readOnlyOption
 * @property RefStatus $status
 * @property CalendarSubscription[] $calendarSubscriptions
 * @property Event[] $events
 */
class Calendar extends \common\components\XActiveRecord
{
 
    /* ********************************************************************************************** */ 
    public function behaviors()
    {
       return  parent::behaviors(); 
    }
    /* ********************************************************************************************** */ 
    public function init()
    {

        if ($this->isNewRecord)
        {
            $this->project_option_id = Types::$boolean['false']['id']; 
            $this->read_only_option_id = Types::$boolean['false']['id']; 
            $this->start_hour = '07'; 
            $this->start_min = '00'; 
            $this->end_hour = '23'; 
            $this->end_min = '59'; 
            $this->hex_code ='#d42300'; 
            $this->advance_limit =90; 
            $this->old_id = 0 ; 
            $this->allow_overlap_option_id = Types::$boolean['false']['id'];  


        }
        return parent::init(); 
    }
    /* ********************************************************************************************** */ 
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'calendar';
    }


    /* ********************************************************************************************** */ 
    public function getBooleanOptions()
    {
        return [
                Types::$boolean['true']['id']=>Types::$boolean['true']['code'], 
                Types::$boolean['false']['id']=>Types::$boolean['false']['code'], 
        ];
    }


    /* ********************************************************************************************** */ 
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['collection_id', 'title', 'description', 'location', 'hex_code'], 'required'],
            [['collection_id', 'project_option_id', 'allow_overlap_option_id', 'read_only_option_id', 'advance_limit', 'old_id', 'sort_order', 'status_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['title', 'description', 'location'], 'string', 'max' => 2048],
            [['start_hour', 'start_min', 'end_hour', 'end_min'], 'string', 'max' => 4],
            [['allow_overlap_option_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefBoolean::className(), 'targetAttribute' => ['allow_overlap_option_id' => 'id']],
            [['collection_id'], 'exist', 'skipOnError' => true, 'targetClass' => Collection::className(), 'targetAttribute' => ['collection_id' => 'id']],
            [['hex_code'], 'string', 'max' => 16],
            [['title'], 'unique'],
            [['project_option_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefBoolean::className(), 'targetAttribute' => ['project_option_id' => 'id']],
            [['read_only_option_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefBoolean::className(), 'targetAttribute' => ['read_only_option_id' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => RefStatus::className(), 'targetAttribute' => ['status_id' => 'id']],
        ];
    }
    /* ********************************************************************************************** */ 
    /**
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'collection_id' => Yii::t('app', 'Collection'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'location' => Yii::t('app', 'Location'),
            'start_hour' => Yii::t('app', 'Start Hour'),
            'start_min' => Yii::t('app', 'Start Min'),
            'end_hour' => Yii::t('app', 'End Hour'),
            'end_min' => Yii::t('app', 'End Min'),
            'hex_code' => Yii::t('app', 'Palette Colour'),
            'project_option_id' => Yii::t('app', 'Project Option ID'),
            'allow_overlap_option_id' => Yii::t('app', 'Allow Event Overlap'),
            'read_only_option_id' => Yii::t('app', 'Read Only Option'),
            'advance_limit' => Yii::t('app', 'Advance Limit (days)'),
            'old_id' => Yii::t('app', 'Old ID'),
            'sort_order' => Yii::t('app', 'Sort Order'),
            'status_id' => Yii::t('app', 'Status ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }
    /* ********************************************************************************************** */ 
    /**
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAllowOverlapOption()
    {
        return $this->hasOne(RefBoolean::className(), ['id' => 'allow_overlap_option_id']);
    }
    /* ********************************************************************************************** */ 
    /**
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCollection()
    {
        return $this->hasOne(Collection::className(), ['id' => 'collection_id']);
    }
    /* ********************************************************************************************** */ 
   
   public function getCollectionOptions()
   {
        $return = []; 
        foreach ( \yii::$app->CollectionComponent->CalendarCollections as $rec)
                $return[$rec['collection_id']] = $rec['title']; 

        return $return; 

   }
    /* ********************************************************************************************** */ 
    /**
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectOption()
    {
        return $this->hasOne(RefBoolean::className(), ['id' => 'project_option_id']);
    }
    /* ********************************************************************************************** */ 
    /**
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReadOnlyOption()
    {
        return $this->hasOne(RefBoolean::className(), ['id' => 'read_only_option_id']);
    }
    /* ********************************************************************************************** */ 
    /**
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(RefStatus::className(), ['id' => 'status_id']);
    }
    /* ********************************************************************************************** */ 
    /**
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCalendarSubscriptions()
    {
        return $this->hasMany(CalendarSubscription::className(), ['calendar_id' => 'id']);
    }
    /* ********************************************************************************************** */ 
    /**
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvents()
    {
        return $this->hasMany(Event::className(), ['calendar_id' => 'id']);
    }
    /* ********************************************************************************************** */ 
    /**
    /**
     * @inheritdoc
     * @return CalendarQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CalendarQuery(get_called_class());
    }

}
