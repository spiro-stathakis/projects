<?php

namespace app\modules\calendar\controllers;

use Yii;
use frontend\modules\calendar\models\EventEntry;
use frontend\modules\calendar\models\EventEntrySearch;
use common\components\XController;
use common\components\Types; 
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * EventEntryController implements the CRUD actions for EventEntry model.
 */
class EventEntryController extends XController
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
        ];
    }

    /* ********************************************************************** */ 
    /**
     * Lists all EventEntry models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EventEntrySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    /* ********************************************************************** */ 
    /**
     * Displays a single EventEntry model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    /* ********************************************************************** */ 
    
    
    /* ********************************************************************** */ 
    /**
     * Updates an existing EventEntry model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($ee_id)
    {
        $eventEntryModel = $this->findModel($ee_id);
        $eventModel = Event::findOne($eventEntryModel->event->id);
        $bookingModel = new Booking;

        $bookingModel->attributes  =  array_merge($eventEntryModel->attributes , $eventModel->attributes);

        if ($bookingModel->load(Yii::$app->request->post()) && $eventEntryModel->save()) {
            return $this->redirect(['view', 'id' => $eventEntryModel->id]);
        } else {
            return $this->render('update', [
                'eventEntryModel' => $eventEntryModel,
            ]);
        }
    }
    /* ********************************************************************** */ 

    /**
     * Deletes an existing EventEntry model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($ee_id)
    {
        $request = yii::$app->request;
        $eventEntryRecord = yii::$app->CalendarComponent->eventEntryRecord($ee_id);  
        if (! yii::$app->CalendarComponent->canUpdateEvent($eventEntryRecord))
           throw new \yii\web\HttpException(403, sprintf('Event delete not authorized for use'));
        $model = $this->findModel($ee_id);
        $model->status_id = Types::$status['inactive']['id']; 
        $model->save(); 
        return $this->redirect(['/calendar/manage/events', 'id'=>$model->event->calendar_id]);
    }
    /* ********************************************************************** */ 
    /**
     * Finds the EventEntry model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return EventEntry the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = EventEntry::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
