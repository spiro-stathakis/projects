<?php

namespace frontend\modules\calendar\models;

use Yii;
use yii\base\Model;

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
   


    public $start_timestamp; 
    public $end_timestamp; 
    
    

    public function rules()
    {
        return [
            [['title','start_time','end_time','start_date', 'calendar_id'], 'required'],
            
        ];
    }

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
