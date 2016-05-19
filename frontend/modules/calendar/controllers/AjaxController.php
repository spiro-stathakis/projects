<?php

namespace app\modules\calendar\controllers;

use Yii;
use frontend\modules\calendar\models\Calendar;
use app\modules\calendar\models\CalendarSearch;
use common\components\XController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Json; 

/**
 * CalendarController implements the CRUD actions for Calendar model.
 */
class AjaxController extends XController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                        'class' => AccessControl::className(),
                        'rules' => [
                                    ['actions' => ['listcalendars', 'listevents'], 'allow' => true, 'roles' => ['@'],], 
                        ],
            ],
        ];
        
    }



    /* ****************************************************************************************** */ 

    public function actionListcalendars()
    {
        print_r(yii::$app->CalendarComponent->myCalendars); 
    }
    /* ****************************************************************************************** */ 
    public function actionTogglesub()
    {
            $request = Yii::$app->request;
            $cal_id = $request['cal_id']; 
    }
    /* ****************************************************************************************** */ 
    public function actionListevents($start=NULL,$end=NULL,$_=NULL)
    {

        $events = array();
        $start_timestamp = yii::$app->datecomponent->isoDateToTimestamp($start); 
        $end_timestamp = yii::$app->datecomponent->isoDateToTimestamp($end);

        $list = yii::$app->CalendarComponent->getEvents($start_timestamp,$end_timestamp); 


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

        $this->sendContent($events);
          
           

    }

    /* ****************************************************************************************** */ 
    private function sendContent($data)
    {
            header('Content-type: application/json');
            echo Json::encode($data);
            Yii::$app->end();
    }
    /* ****************************************************************************************** */ 
    
    
}
