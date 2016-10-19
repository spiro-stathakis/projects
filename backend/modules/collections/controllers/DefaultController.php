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
                                    ['actions' => ['index'], 'allow' => true, 'roles' => ['super_manager'],], 
                                    ['actions' => ['manage'], 'allow' => true, 'roles' => ['super_manager'],], 
                                    
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
    			'allModels' =>yii::$app->CollectionComponent->allCollections,
    			'pagination'=>false, 
    	]);
    	$managerProvider  =  new ArrayDataProvider([
    			'allModels' =>yii::$app->CollectionComponent->allCollections,
    			'pagination'=>false, 
    	]);

     	return $this->render('index' , ['memberProvider'=>$memberProvider,'managerProvider'=>$managerProvider]);
    }
    /* *********************************************************************************************************************** */ 
    public function actionManage($id)
    {

      
      \yii::$app->jsconfig->addData('searchUri', Url::to(['ajax/searchusers'])); 
      \yii::$app->jsconfig->addData('memberTargetId', '#member-select'); 
      \yii::$app->jsconfig->addData('managerTargetId', '#manager-select'); 
      \yii::$app->jsconfig->addData('collectionId', $id); 
      \yii::$app->jsconfig->addData('addUri', Url::to(['ajax/adduser'])); 
      \yii::$app->jsconfig->addData('removeUri', Url::to(['ajax/removeuser'])); 
      \yii::$app->jsconfig->addData('memberType', Types::$member_type['member']['id']); 
      \yii::$app->jsconfig->addData('managerType', Types::$member_type['manager']['id']); 
    	

     
      $collectionModel = Collection::findOne($id); 
      if ($collectionModel === null)
         throw new \yii\web\HttpException(404, yii::t('app', 'Cannot find collection.')); 


    	return $this->render('manage' , ['collectionModel'=>$collectionModel]); 
    }


    /* ****************************************************************************************************** */ 
    /* ****************************************************************************************************** */ 
    /* ****************************************************************************************************** */ 
    /* ****************************************************************************************************** */ 
    /* ****************************************************************************************************** */ 
    /* ****************************************************************************************************** */ 
    /* ****************************************************************************************************** */ 
    /* ****************************************************************************************************** */ 
    /* ****************************************************************************************************** */ 
    /* ****************************************************************************************************** */ 
    /* ****************************************************************************************************** */ 
    /* ****************************************************************************************************** */ 
    
    
}
