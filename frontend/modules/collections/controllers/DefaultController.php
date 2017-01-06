<?php

namespace app\modules\collections\controllers;
use yii\filters\AccessControl; 
use yii\data\ArrayDataProvider; 
use yii\helpers\Url; 
use common\components\Types; 
use common\models\Collection; 
use common\models\UserCollection; 
use yii; 
/**
 * Default controller for the `collections` module
 */
class DefaultController  extends \common\components\XController
{
  
	

	/* ****************************************************************************************************************** */ 
   	public function init()
   	{
   		return parent::init(); 
	}
	/* ****************************************************************************************************************** */ 
   	

   	public function behaviors()
   	{
        return [
                'access' => [
                        'class' => AccessControl::className(),
                        'rules' => [
                                    ['actions' => ['index'], 'allow' => true, 'roles' => ['@'],], 
                                   
                                    
                                    ],
                        ],
        ];
        
    }


    /* ****************************************************************************************************************** */ 
    
    /* ****************************************************************************************************************** */ 
    
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
    	$memberProvider  =  new ArrayDataProvider([
    			'allModels' =>yii::$app->CollectionComponent->myMemberCollections,
    			'pagination'=>false, 
    	]);
    	$managerProvider  =  new ArrayDataProvider([
    			'allModels' =>yii::$app->CollectionComponent->myManagerCollections,
    			'pagination'=>false, 
    	]);

     	return $this->render('index' , ['memberProvider'=>$memberProvider,'managerProvider'=>$managerProvider]);
    }
    /* *********************************************************************************************************************** */ 
    

    /* *********************************************************************************************************************** */ 
   
    /* *********************************************************************************************************************** */ 
    
    /* *********************************************************************************************************************** */ 
    /* *********************************************************************************************************************** */ 
   
    /* *********************************************************************************************************************** */ 
   
    /* *********************************************************************************************************************** */ 
    
    
}
