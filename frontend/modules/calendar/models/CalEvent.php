<?php 

namespace frontend\modules\calendar\models;




class CalEvent extends \yii2fullcalendar\models\Event
{
 public $project_id; 
 public $resource_id; 
 public $cal_id; 
 public $created_by; 
 public $created_at; 
 public $create_name; 
 public $project_title;
 public $project_collection_title; 
 public $calendar_title;
 public $event_entry_id; 
 public $event_description; 
 public $event_entry_description; 
 //public $editable;  
}