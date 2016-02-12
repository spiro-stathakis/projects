<?php

namespace app\modules\calendar\controllers;

use common\components\XController;
use app\modules\calendar\models\Event; 

class DefaultController extends XController
{
    public function actionIndex()
    {
	        
		

	  //echo $this->layout; 
	 //echo $this->action->id; 
	 return $this->render('index');
    }

/* ********************************************************************** */ 

	
/* ********************************************************************** */ 


}
