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
   
    public $start_datetime; 
    public $end_datetime; 


    public $start_timestamp; 
    public $end_timestamp; 
    
    

    public function init()
    {
        $this->booking_status_id = Types::$bookingStatus['confirmed']['id']; 
        $this->all_day_option_id = Types::$boolean['false']['id']; 
        return parent::init(); 
    }
    public function rules()
    {
        return [
            [['title','start_time','end_time','start_date', 'calendar_id'], 'required'],
            [['start_timestamp','end_timestamp'], 'integer'],
            [['start_datetime','end_datetime'] , 'date', 'format'=>'dd/MM/yyyy H:m'],
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
        $this->start_timestamp = $dateObj->ukDateTimeToTimestamp($this->start_datetime);
        $this->end_timestamp = $dateObj->ukDateTimeToTimestamp($this->end_datetime);
        return parent::afterValidate(); 
    }
    /* ************************************************************************************************ */ 
    public function beforeValidate()
    {
        $this->start_datetime  = sprintf(sprintf('%s %s', $this->start_date, $this->start_time)); 
        $this->end_datetime  = sprintf(sprintf('%s %s', $this->start_date, $this->end_time)); 
        
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
