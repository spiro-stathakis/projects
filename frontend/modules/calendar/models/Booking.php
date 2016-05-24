<?php

namespace frontend\modules\calendar\models;

use Yii;
use yii\base\Model;
use common\components\Types; 

class Booking extends Model
{
    public $event_id;
    public $booking_status_id;
    public $calendar_id; 
	public $project_id; 
    public $all_day_option_id;
    
    public $title;
    public $description; 
    public $start_date;
    public $end_date;  
    
    public $start_time; 
    public $end_time; 
   
    public $start_datetime_uk; 
    public $end_datetime_uk; 


    public $start_timestamp; 
    public $end_timestamp; 
    public $jsObject; 
   
    /* ************************************************************************************************ */ 

    public function init()
    {
        $this->jsObject = []; 
        $this->booking_status_id = Types::$bookingStatus['confirmed']['id']; 
        $this->all_day_option_id = Types::$boolean['false']['id']; 
        return parent::init(); 
    }
    /* ************************************************************************************************ */ 

    public function rules()
    {
        return [
            [['title','start_time','end_time','start_date', 'calendar_id'], 'required'],
            [['start_timestamp','end_timestamp'], 'integer'],
            [['start_datetime_uk','end_datetime_uk'] , 'date', 'format'=>'dd-MM-yyyy H:m'],
        ];
    }
    /* ************************************************************************************************ */ 

    public function getAllDayOptions()
    {
        return [
                Types::$boolean['true']['id']=>Types::$boolean['true']['code'],
                Types::$boolean['false']['id']=>Types::$boolean['false']['code'],
                ]; 

    }
    /* ************************************************************************************************ */ 
    public function afterValidate()
    {

        $dateObj =\yii::$app->DateComponent; 
        if ($this->all_day_option_id == Types::$boolean['true']['id']) 
            $this->jsObject['allDay'] = true;  
        else 
            $this->jsObject['allDay'] = false;

        $this->start_timestamp = $dateObj->ukDateTimeToTimestamp($this->start_datetime_uk);
        $this->end_timestamp = $dateObj->ukDateTimeToTimestamp($this->end_datetime_uk);
        $this->jsObject['start'] = $dateObj->timeStampToIsoDateTime($this->start_timestamp);
        $this->jsObject['end'] = $dateObj->timeStampToIsoDateTime($this->end_timestamp);
        $this->jsObject['className'] = sprintf('calendar-%s', $this->calendar_id); 
        $this->jsObject['title'] = $this->title; 
        $this->jsObject['description'] = $this->description; 
        
        return parent::afterValidate(); 
    }
    /* ************************************************************************************************ */ 
    
    /* ************************************************************************************************ */ 
    public function beforeValidate()
    {
        $this->start_datetime_uk  = sprintf(sprintf('%s %s', $this->start_date, $this->start_time)); 
        $this->end_datetime_uk  = sprintf(sprintf('%s %s', $this->start_date, $this->end_time)); 
        
        return parent::beforeValidate(); 
    }
    /* ************************************************************************************************ */ 
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'calendar_id' => Yii::t('app', 'Calendar'),
            'project_id' => Yii::t('app', 'Project'),
            'start_time' => Yii::t('app', 'Start'),
            'end_time' => Yii::t('app', 'End'),
            'start_date' => Yii::t('app', 'Date'),
              
        ];

    }

    /* ********************************************************************************************************* */



   
}
