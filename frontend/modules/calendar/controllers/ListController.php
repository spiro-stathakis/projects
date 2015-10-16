<?php

namespace app\modules\calendar\controllers;
use Yii;  
use common\components\XController;
//use frontend\modules\calendar\models; 
use yii\helpers\Json;
use app\modules\calendar\models\CalEvent as Event; 
class ListController extends XController
{
    
/* ********************************************************************** */ 

	public function actionEvents($start=NULL,$end=NULL,$_=NULL)
	{

	
	
		$events = array();
	  //Testing
	  $Event = new Event();
	  $Event->id = 1;
	  $Event->title = 'Hello';
	  $Event->start = date('Y-m-d\Th:m:s\Z');
	  //$Event->start = time();
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

		header('Content-type: application/json');
    	echo Json::encode($events);
 
    	Yii::$app->end();
    	
	}

/* ********************************************************************** */ 


}
