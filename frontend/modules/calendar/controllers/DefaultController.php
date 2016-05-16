<?php

namespace app\modules\calendar\controllers;

use common\components\XController;
use app\modules\calendar\models\Event; 
use yii\filters\AccessControl; 
class DefaultController extends XController
{

	 public function behaviors()
    {
        return [
                'access' => [
                        'class' => AccessControl::className(),
                        'rules' => [
                                    ['actions' => ['create'], 'allow' => true, 'roles' => ['createCalendar'],], 
                                    ['actions' => ['edit'], 'allow' => true, 'roles' => ['editCalendar'],], 
                                   
                                ],
                        ],
        ];
        
    }


    public function actionIndex()
    {
	        
		

	  //echo $this->layout; 
	 //echo $this->action->id; 
	 return $this->render('index');
    }

/* ********************************************************************** */ 
	public function actionCreate()
	{

		echo "Create a calendar"; 
	}
	
/* ********************************************************************** */ 


}
