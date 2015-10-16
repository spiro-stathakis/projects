<?php 

namespace app\modules\calendar\models;


use yii2fullcalendar;


class CalEvent extends yii2fullcalendar\models\Event
{
 public $project_id; 
 public $resource_id; 
}