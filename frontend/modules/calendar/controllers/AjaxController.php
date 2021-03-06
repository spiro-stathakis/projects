<?php

namespace app\modules\calendar\controllers;

use Yii;
use frontend\modules\calendar\models\Calendar;
use frontend\modules\calendar\models\CalendarSearch;
use frontend\modules\calendar\models\Booking;
use frontend\modules\calendar\models\Event;
use frontend\modules\calendar\models\CalEvent;
use frontend\modules\calendar\models\EventEntry;
use frontend\modules\calendar\models\CalendarSubscription; 
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
                                    ['actions' => ['createevent',
                                                    'updateevent',
                                                    'deleteevent',  
                                                    'listcalendars', 
                                                    'listevents', 
                                                    'unsubscribe', 
                                                    'subscribe', 
                                                ], 

                                                'allow' => true, 'roles' => ['@'],], 
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
    public function actionSubscribe()
    {
            $cal_id = yii::$app->request->post('cal_id'); 
            if ($cal_id  === null)
                throw new \yii\web\HttpException(404, sprintf('Calendar not found %s', $cal_id));
           
            $model = CalendarSubscription::findOne([
                'calendar_id' => $cal_id,
                'user_id' => yii::$app->user->id,
            ]);
            if ($model == null)
            {
                $model = new CalendarSubscription; 
                $model->user_id = yii::$app->user->id; 
                $model->calendar_id = $cal_id; 
            }

            $model->display_option_id = Types::$boolean['true']['id']; 
            $model->save(); 
            $this->sendContent(['status'=>'success']); 


    }
    
    /* ****************************************************************************************** */ 
    public function actionUnsubscribe()
    {
            $cal_id = yii::$app->request->post('cal_id'); 
            if ($cal_id  === null)
                throw new \yii\web\HttpException(404, sprintf('Calendar not found %s', $cal_id));
           
            $model = CalendarSubscription::findOne([
                'calendar_id' => $cal_id,
                'user_id' => yii::$app->user->id,
            ]);
            if ($model == null)
            {
                $model = new CalendarSubscription; 
                $model->user_id = yii::$app->user->id; 
                $model->calendar_id = $cal_id; 
            }

            $model->display_option_id = Types::$boolean['false']['id']; 
            $model->save(); 
            $this->sendContent(['status'=>'success']); 

    }
    /* ****************************************************************************************** */ 
    public function actionDeleteevent()
    {
        $request = yii::$app->request;
        $ee_id = $request->post('ee_id'); 
        $eventEntryRecord = yii::$app->CalendarComponent->eventEntryRecord($ee_id);  
        if (! yii::$app->CalendarComponent->canUpdateEvent($eventEntryRecord))
           throw new \yii\web\HttpException(403, sprintf('Event delete not authorized for use'));
        $model = EventEntry::findOne($ee_id);
        $model->status_id = Types::$status['inactive']['id']; 
        $model->save(); 
         $this->sendContent(['status'=>'success']); 

    }
    /* ****************************************************************************************** */ 
    
    public function actionUpdateevent()
    //event entries can be updated via form,  drag or resize events 

    {

        $request = \yii::$app->request; 
        if (yii::$app->CalendarComponent->eventEntryRecord($request->post('pk') !== null))
             $post = $request->post('pk'); 
       
       // check to see if we are doing an update via form and not resize or drag
        if ($request->post('name'))
            $post[$request->post('name')] = $request->post('value'); 
 

       $eventEntryRecord = yii::$app->CalendarComponent->eventEntryRecord($post['ee_id']); 
       $eventEntryModel = EventEntry::findOne($post['ee_id']); 
       $eventModel = Event::findOne($eventEntryModel->event->id);
       
        
        if (! yii::$app->CalendarComponent->canUpdateEvent(array_merge($eventEntryRecord, $post)))
           throw new \yii\web\HttpException(403, sprintf('Event update not authorized for use'));


       
        $bookingModel = new Booking; 
        $bookingModel->attributes = array_merge($eventEntryRecord , $eventModel->attributes, $post); 
        


        if ($bookingModel->validate()) 
        {
            
            
            $eventEntryModel->load(['EventEntry'=>$bookingModel->attributes]); 
            $eventModel->load(['Event'=>$bookingModel->attributes]);

            if ($eventEntryModel->validate() && $eventModel->validate()) 
            {
                $eventEntryModel->save();
                $eventModel->save(); 
                yii::$app->AjaxResponse->error = false; 
                yii::$app->AjaxResponse->message = $bookingModel->jsObject;     
            }
            else
                yii::$app->AjaxResponse->message = array_values($eventEntryModel->getErrors() + $eventModel->getErrors());  
        }
        else 
            yii::$app->AjaxResponse->message = array_values($bookingModel->getErrors());     
        
        
        yii::$app->AjaxResponse->sendContent();  


    }
    /* ****************************************************************************************** */ 
    
    /* ****************************************************************************************** */ 
    public function actionCreateevent()
    {
        $request = \yii::$app->request; 
        
        $bookingModel = new Booking; 
        $eventModel = new Event; 
        $eventEntryModel = new EventEntry; 
        $validate = false; 

        $bookingModel->load($request->post()); 

        if (yii::$app->CalendarComponent->canCreateEvents($bookingModel->calendar_id))
            $validate = true; 
        else 
            $bookingModel->addError('event_id', 'Cannot use this calendar. Double check the read only setting - ');
        
        
        if ($validate && $bookingModel->validate())
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
   
    /* ****************************************************************************************** */ 
    public function actionListevents($start=NULL,$end=NULL,$_=NULL)
    {

        $events = array();
        $start_timestamp = yii::$app->DateComponent->isoDateToTimestamp($start); 
        $end_timestamp = yii::$app->DateComponent->isoDateToTimestamp($end);

        $list = yii::$app->CalendarComponent->getEvents($start_timestamp,$end_timestamp); 


        foreach ( $list as $e)
        {
            if (yii::$app->CalendarComponent->isSubscribed($e['calendar_id']))
            {
                $model = new CalEvent(); 
                
                $model->editable = $model->startEditable = $model->durationEditable = yii::$app->CalendarComponent->canUpdateEvent($e); 
                $model->id = $e['event_entry_id']; 
                $model->cal_id = $e['calendar_id']; 
                $model->calendar_title = $e['calendar_title'];
                $model->event_entry_description = $e['event_entry_description'];
                $model->project_collection_title = $e['project_collection_title'];
                $model->event_entry_id = $e['event_entry_id']; 
                $model->created_by = $e['created_by']; 
                $model->project_id = $e['project_id']; 
                if (strlen($e['event_entry_title']) > 0)
                    $model->title =  $e['event_entry_title']; 
                else 
                    $model->title =  $e['event_title'];

                $model->start = yii::$app->DateComponent->timestampToIsoDateTime($e['start_timestamp']);
                $model->end =  yii::$app->DateComponent->timestampToIsoDateTime($e['end_timestamp']);
                $model->create_name = $e['create_name']; 
                $model->created_at = yii::$app->DateComponent->timestampToUkDateTime($e['created_at']); 
                if ($e['all_day_option_id'] == Types::$boolean['true']['id'])
                {
                    $model->allDay = true; 
                   
                }

                else 
                    $model->allDay = false;
                //$model->backgroundcolor = $e['hex_code']; 
                $model->className = sprintf('calendar-%s' , $e['calendar_id']); 
                

                $events[]  = $model ;         
            }
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
