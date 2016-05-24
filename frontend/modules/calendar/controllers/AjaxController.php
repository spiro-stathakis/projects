<?php

namespace app\modules\calendar\controllers;

use Yii;
use frontend\modules\calendar\models\Calendar;
use frontend\modules\calendar\models\CalendarSearch;
use frontend\modules\calendar\models\Booking;
use frontend\modules\calendar\models\Event;
use frontend\modules\calendar\models\CalEvent;
use frontend\modules\calendar\models\EventEntry;
use common\components\XController;
use common\components\Types; 
use yii\widgets\ActiveForm;
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
                                    ['actions' => ['createevent','listcalendars', 'listevents'], 'allow' => true, 'roles' => ['@'],], 
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
   
    /* ****************************************************************************************** */ 
    
    public function actionCreateevent()
    {
        $request = \yii::$app->request; 
        
        $bookingModel = new Booking; 
        $eventModel = new Event; 
        $eventEntryModel = new EventEntry; 

        $bookingModel->load($request->post()); 

        if ($bookingModel->validate())
        {
             
            
            $eventModel->load(['Event'=>$bookingModel->attributes]); 
            if ($eventModel->validate())
            {
                    try
                    {

                        $transaction = \yii::$app->db->beginTransaction();
                   
                        $eventModel->save(false);
                        $eventEntryModel->load(['EventEntry'=>$bookingModel->attributes]); 
                        $eventEntryModel->event_id = $eventModel->primaryKey; 
                        
                        if ($eventEntryModel->validate())
                        {
                            $eventEntryModel->save(false);    
                            yii::$app->AjaxResponse->error = false; 
                        } 
                        else 
                        {
                            yii::$app->AjaxResponse->message = array_values($eventEntryModel->getErrors());  
                        }
                        $transaction->commit();
                        yii::$app->AjaxResponse->message = $bookingModel->jsObject;
                        
                    } 
                    catch (Exception $e)
                    {
                         $transaction->rollBack();
                    }
                
                
            }
            else 
                yii::$app->AjaxResponse->message = array_values($eventModel->getErrors()); 
        }
        else 
            yii::$app->AjaxResponse->message = array_values($bookingModel->getErrors()); 
        

        
        yii::$app->AjaxResponse->sendContent();  

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
        $start_timestamp = yii::$app->DateComponent->isoDateToTimestamp($start); 
        $end_timestamp = yii::$app->DateComponent->isoDateToTimestamp($end);

        $list = yii::$app->CalendarComponent->getEvents($start_timestamp,$end_timestamp); 


        foreach ( $list as $e)
        {
            $model = new CalEvent(); 
            $model->id = $e['event_entry_id']; 
            if (strlen($e['event_entry_title']) > 0)
                $model->title =  $e['event_entry_title']; 
            else 
                $model->title =  $e['event_title'];

            $model->start = yii::$app->DateComponent->timestampToIsoDate($e['start_timestamp'], true) ;
            $model->end =  yii::$app->DateComponent->timestampToIsoDate($e['end_timestamp'], true) ;
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
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            echo Json::encode($data);
            Yii::$app->end();
    }
    /* ****************************************************************************************** */ 
    
    
}
