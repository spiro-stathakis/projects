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
                                    ['actions' => ['members'], 'allow' => true, 'roles' => ['@'],], 
                                    
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
    public function actionMembers($id)
    {

      
      \yii::$app->jsconfig->addData('searchUri', Url::to(['ajax/searchusers'])); 
      \yii::$app->jsconfig->addData('targetId', '#member-select'); 
      \yii::$app->jsconfig->addData('collectionId', $id); 
      \yii::$app->jsconfig->addData('addUri', Url::to(['ajax/adduser'])); 
      \yii::$app->jsconfig->addData('removeUri', Url::to(['ajax/removeuser'])); 
      \yii::$app->jsconfig->addData('memberType', Types::$member_type['member']['id']); 
    	

      if (yii::$app->CollectionComponent->isManager($id) === false) 
    		 throw new \yii\web\HttpException(403, yii::t('app', 'No permission to access collection.'));
    	
      $collectionModel = Collection::findOne($id); 
      if ($collectionModel === null)
         throw new \yii\web\HttpException(404, yii::t('app', 'Cannot find collection.')); 


    	return $this->render('members' , ['collectionModel'=>$collectionModel]); 
    }


    /* *********************************************************************************************************************** */ 
   
    /* *********************************************************************************************************************** */ 
    
    /* *********************************************************************************************************************** */ 
    /* *********************************************************************************************************************** */ 
   
    /* *********************************************************************************************************************** */ 
   
    /* *********************************************************************************************************************** */ 
    
    
}
