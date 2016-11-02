<?php

namespace app\modules\calendar\controllers;
use yii; 
use yii\filters\AccessControl;
use common\components\XController;
use common\components\Types;
use frontend\modules\calendar\models\Booking; 
use yii\helpers\Url; 
use yii\helpers\Json; 
class DefaultController extends XController
{

/* ********************************************************************** */ 

    public function init()
    {
        if (! Yii::$app->user->isGuest){
            yii::$app->jsconfig->addData('allCalendars', yii::$app->CalendarComponent->allCalendars);
            yii::$app->jsconfig->addData('myCalendars', yii::$app->CalendarComponent->myCalendars);
            yii::$app->jsconfig->addData('myProjects', yii::$app->ProjectComponent->myProjects); 
            yii::$app->jsconfig->addData('createEventUri', Url::to('/calendar/ajax/createevent') );
            yii::$app->jsconfig->addData('updateEventUri', Url::to('/calendar/ajax/updateevent') );
            yii::$app->jsconfig->addData('deleteEventUri', Url::to('/calendar/ajax/deleteevent') );
            yii::$app->jsconfig->addData('subscribeUri', Url::to('/calendar/ajax/subscribe') );
            yii::$app->jsconfig->addData('unsubscribeUri', Url::to('/calendar/ajax/unsubscribe') );

            
        }
        return parent::init(); 
    }

/* ********************************************************************** */ 

	 public function behaviors()
    {
        return [
                'access' => [
                        'class' => AccessControl::className(),
                        'rules' => [
                                    [
                                        'actions' => ['index'], 
                                        'allow' => true,
                                        'roles' => ['@'],
                                     ], 
                                ],
                        ],
        ];
        
    }

/* ********************************************************************** */ 

    public function actionIndex()
    {
	    $bookingModel  = new Booking;  
        yii::$app->jsconfig->addData('tree', Json::encode($this->_getTree()));  
	   return $this->render('index', ['bookingModel'=>$bookingModel]);


    }
/* ********************************************************************** */ 

    private function _getTree()
    {
        $tree = []; 
        $found = []; 
        foreach(yii::$app->CollectionComponent->theCollections as $collection)
        {
           if (! in_array($collection['collection_id'] , $found ))
                $tree[] = $this->_getTreeSection($collection);
           $found[] = $collection['collection_id']; 
        }
        
        return $tree; 

    }
/* ********************************************************************** */ 
    private function _getTreeSection($collection)
    {
        $checked = false; 
        $nodes = []; 
        $found = []; 
        foreach(yii::$app->CalendarComponent->myCalendars as $calendar)
        {
            $checked = false; 
            if ($calendar['collection_id'] == $collection['collection_id'])
            {
                if (! in_array($calendar['calendar_id'],$found ))
                {
                    if (array_key_exists( $calendar['calendar_id'], yii::$app->CalendarComponent->myCalendarList))
                        if (yii::$app->CalendarComponent->isSubscribed($calendar['calendar_id']))
                            $checked = true; 
                        
                        $nodes[] = [
                            'text'=>$calendar['calendar_title'], 
                            'cal_id'=>$calendar['calendar_id'], 
                            'state'=>['checked'=>$checked], 
                        ];
                }
            }
            $found[] = $calendar['calendar_id']; 
        }
        return [
                'text'=>$collection['collection_title'], 
                'selectedIcon'=>'glyphicon glyphicon-calendar',
                'selectable'=>false, 
                'tags'=>[count($nodes)],
                'state'=>['disabled'=>(count($nodes)===0)],  
                'nodes'=>$nodes, 

        ]; 
    }

/* ********************************************************************** */ 

}
