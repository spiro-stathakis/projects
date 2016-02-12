<?php

namespace app\modules\calendar\controllers;
use Yii;  
use common\components\XController;
use common\components\Types; 
//use frontend\modules\calendar\models; 
use yii\helpers\Json;
use app\modules\calendar\models\CalEvent as Event; 
class ListController extends XController
{
    
/* ********************************************************************** */ 

	public function actionEvents($start=NULL,$end=NULL,$_=NULL)
	{

	
	
	$events = array();
	$start_timestamp = yii::$app->datecomponent->isoDateToTimestamp($start); 
	$end_timestamp = yii::$app->datecomponent->isoDateToTimestamp($end);

	$list = yii::$app->calendarcomponent->getEvents($start_timestamp,$end_timestamp); 


	foreach ( $list as $e)
	{
		$model = new Event(); 
		$model->id = $e['event_entry_id']; 
		if (strlen($e['event_entry_title']) > 0)
			$model->title =  $e['event_entry_title']; 
		else 
			$model->title =  $e['event_title'];

		$model->start = yii::$app->datecomponent->timestampToIsoDate($e['start_timestamp'], true) ;
		$model->end =  yii::$app->datecomponent->timestampToIsoDate($e['end_timestamp'], true) ;
		if ($e['all_day_option_id'] == Types::$boolean['true']['id'])
			$model->allDay = true; 
		
		//$model->backgroundcolor = $e['hex_code']; 
		$model->className = sprintf('calendar-%s' , $e['calendar_id']); 


		$events[]  = $model ; 		  

	}  


	  /*
	  $Event = new Event();
	  $Event->id = 1;
	  $Event->title = 'Hello';
	  $Event->start = date('Y-m-d\Th:m:s\Z');
	 
	  $Event->project_id = 1; 
	  $Event->resource_id = 2; 
	  $events[] = $Event;
	 
	  $Event = new Event();
	  $Event->id = 2;

	  $Event->project_id = 2; 
	  $Event->resource_id = 3; 
	  $Event->title = 'Testing';
	  $Event->start = date('Y-m-d\Th:m:s\Z',strtotime('tomorrow 6am'));
	  $events[] = $Event;
*/
		header('Content-type: application/json');
    	echo Json::encode($events);
 
    	Yii::$app->end();
    	
	}

/* ********************************************************************** */ 


}
