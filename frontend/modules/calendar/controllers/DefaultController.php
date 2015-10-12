<?php

namespace app\modules\calendar\controllers;

use common\components\XController;

class DefaultController extends XController
{
    public function actionIndex()
    {
	        
		

	  //echo $this->layout; 
	 //echo $this->action->id; 
	 return $this->render('index');
    }

/* ********************************************************************** */ 

	public function actionListEvents()
	{


	
	$events = array();
	  //Testing
	  $Event = new \yii2fullcalendar\models\Event();
	  $Event->id = 1;
	  $Event->title = 'Testing';
	  $Event->start = date('Y-m-d\Th:m:s\Z');
	  $events[] = $Event;
	 
	  $Event = new \yii2fullcalendar\models\Event();
	  $Event->id = 2;
	  $Event->title = 'Testing';
	  $Event->start = date('Y-m-d\Th:m:s\Z',strtotime('tomorrow 6am'));
	  $events[] = $Event;



	header('Content-type: application/json');
    echo Json::encode($events);
 
    Yii::$app->end();
	}

/* ********************************************************************** */ 


}
