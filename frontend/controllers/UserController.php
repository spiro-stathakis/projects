<?php 
namespace frontend\controllers;
//use Yii; 
use common\components\XController;

class UserController extends XController
{
	public function actionIndex()
	{
		print_r($this->actions()); 
	
	}

	public function actions()
    {
        return parent::actions(); 
    }

}
