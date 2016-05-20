<?php

namespace app\modules\calendar\controllers;
use yii; 
use yii\filters\AccessControl;
use common\components\XController;
use common\components\Types;
use frontend\modules\calendar\models\Booking; 

class DefaultController extends XController
{

/* ********************************************************************** */ 

    public function init()
    {
        if (! Yii::$app->user->isGuest)
            yii::$app->jsconfig->addData('myCalendars', yii::$app->CalendarComponent->myCalendars);
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
                                        'allow' => false,
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
	 return $this->render('index', ['bookingModel'=>$bookingModel]);


    }

	
	
/* ********************************************************************** */ 


}
