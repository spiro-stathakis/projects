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
            yii::$app->jsconfig->addData('myCalendars', yii::$app->CalendarComponent->myCalendars);
            yii::$app->jsconfig->addData('createEventUri', Url::to('/calendar/ajax/createevent') );

            
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
        foreach(yii::$app->CollectionComponent->myList as $collection)
            $tree[] = [
                        'text'=>$collection['title'],
                        'selectedIcon'=>'glyphicon glyphicon-calendar',
                        'selectable'=>false, 
                        'nodes'=>
                            [
                                [
                                    'text'=>'abce',
                                    'custom'=>'boo!',
                                    
                                    //'selectable'=>'true',
                                   // 'icon'=>'glyphicon glyphicon-calendar', 
                                   'state'=>['checked'=>true,], 
                                     
                                    
                                ],
                                [
                                    'text'=>'def', 

                                ]
                            ]
                        ];  
        
        return $tree; 

    }
/* ********************************************************************** */ 


}
