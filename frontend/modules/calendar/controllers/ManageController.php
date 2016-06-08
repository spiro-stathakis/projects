<?php

namespace app\modules\calendar\controllers;
use yii; 
use common\components\XController;
use common\components\Types;
use app\modules\calendar\models\Event; 
use yii\filters\AccessControl;
use frontend\modules\calendar\models\Calendar;  

class ManageController extends XController
{


    public function init()
    {
        
        return parent::init(); 
    }

	 public function behaviors()
    {
        return [
                'access' => [
                        'class' => AccessControl::className(),
                        'rules' => [
                                    ['actions' => ['create'], 'allow' => true, 'roles' => ['createCalendar'],], 
                                    ['actions' => ['update'], 'allow' => true, 'roles' => ['editCalendar'],], 
                                    ['actions' => ['view'], 'allow' => true, 'roles' => ['editCalendar'],], 
                                    ['actions' => ['list'], 'allow' => true, 'roles' => ['editCalendar'],], 
                                    ['actions' => ['index'], 'allow' => true, 'roles' => ['@'],], 
                                ],
                        ],
        ];
        
    }

    /* ********************************************************************** */ 
    
    /* ********************************************************************** */ 
    public function actionIndex()
    {
	        
		

	  //echo $this->layout; 
	 //echo $this->action->id; 
        $theCalendarList = []; 
        $myCalendarList = []; 
        foreach(yii::$app->CalendarComponent->myCalendars as $cal)
        {
            $theCalendarList[$cal['calendar_id']] = $cal['calendar_title'];
            if ($cal['display_option_id'] == Types::$boolean['true']['id'] || $cal['display_option_id'] == null )
                $myCalendarList[] = $cal['calendar_id'];
        }

	 return $this->render('index', ['theCalendarList'=>$theCalendarList, 'myCalendarList'=>$myCalendarList]);
    }

    /* ********************************************************************** */ 
	public function actionView($id)
    {
        $model = $this->findModel($id); 
        return $this->render('view', ['model'=>$model]); 
    }
    /* ********************************************************************** */ 
    public function actionUpdate($id)
    {
        
        if (! yii::$app->CalendarComponent->isManager($id))
            throw new \yii\web\HttpException(403, 'Permission to update this calendar is denied.');
        
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) 
        {
            Yii::$app->session->setFlash('success', sprintf('Calendar %s has been updated' , $model->title));
            return $this->redirect(['/collections/default/manage', 'id' => $model->collection_id]);
        } 
        else 
        {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
        return $this->render('update'); 
    }
    /* ********************************************************************** */ 
    public function actionCreate($col = null)
	{
        $model = new Calendar();
        if ($col !== null) 
            $model->collection_id = $col ; 
        
        if ($model->load(\yii::$app->request->post()) && $model->save()) 
        {
             Yii::$app->session->setFlash('success', sprintf('Calendar %s has been created' , $model->title));
            return $this->redirect(['/collections/default/manage', 'id' => $model->collection_id]);
        } 
        else 
        {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
   

	}
/* ********************************************************************** */ 
public function actionList()
{
    return $this->render('list', ['managementList'=>yii::$app->CalendarComponent->managementList]);
    
}	
/* ********************************************************************** */ 
protected function findModel($id)
    {
        if (($model = Calendar::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


}
