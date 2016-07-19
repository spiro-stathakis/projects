<?php

namespace app\modules\collections\controllers;
use yii\filters\AccessControl; 
use yii\data\ArrayDataProvider; 
use common\components\Types; 
use common\models\Collection; 
use common\models\UserCollection; 
use yii; 
/**
 * Default controller for the `collections` module
 */
class AjaxController  extends \common\components\XController
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
                                    ['actions' => ['searchusers'], 'allow' => true, 'roles' => ['@'],], 
                                    ['actions' => ['adduser'], 'allow' => true, 'roles' => ['@'],], 
                                    ['actions' => ['removeuser'], 'allow' => true, 'roles' => ['@'],], 
                                   
                                    ],
                        ],
        ];
        
    }


    /* ********************************************************************************************************************** */ 
    
    /* *********************************************************************************************************************** */ 
    
   
    /* *********************************************************************************************************************** */ 
    public function actionSearchusers($q=null, $id=null)
    {
          \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii::$app->UserComponent->ajaxSearchActiveUsers($q);
           
    }
    /* *********************************************************************************************************************** */ 
    public function actionAdduser() //$collection_id, $member_type, $user_id
    {
          
          \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
          $user_id = \yii::$app->request->post('id'); 
          $collection_id = \yii::$app->request->post('col');
          $member_type_id = \yii::$app->request->post('mem');

          if (yii::$app->CollectionComponent->isManager($collection_id ) === false) 
              throw new \yii\web\HttpException(403, yii::t('app', 'No permission to access collection.'));

          
          $userCollectionModel = UserCollection::findOne(
                                          ['user_id'=>$user_id, 
                                          'collection_id'=>$collection_id , 
                                          'member_type_id'=>$member_type_id]);
          if ($userCollectionModel === null)
          {
              $userCollectionModel = new UserCollection(); 
              $userCollectionModel->user_id  = $user_id; 
              $userCollectionModel->collection_id = $collection_id; 
              $userCollectionModel->member_type_id = $member_type_id; 

          } 
          $userCollectionModel->status_id = Types::$status['active']['id']; 
          if ($userCollectionModel->save() === false)
              return  $userCollectionModel->getErrors(); 







    }
    /* *********************************************************************************************************************** */ 
    /* *********************************************************************************************************************** */ 
    public function actionRemoveuser()
    {
          
           \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
          $user_id = \yii::$app->request->post('id'); 
          $collection_id = \yii::$app->request->post('col');
          $member_type_id = \yii::$app->request->post('mem');

          if (yii::$app->CollectionComponent->isManager($collection_id ) === false) 
              throw new \yii\web\HttpException(403, yii::t('app', 'No permission to access collection.'));

          
          $userCollectionModel = UserCollection::findOne(
                                          ['user_id'=>$user_id, 
                                          'collection_id'=>$collection_id , 
                                          'member_type_id'=>$member_type_id]);
          if ($userCollectionModel !== null)
          {
            $userCollectionModel->status_id = Types::$status['inactive']['id'];  
            $userCollectionModel->save();
          }

          
         
          

    }
    /* *********************************************************************************************************************** */ 
   
    /* *********************************************************************************************************************** */ 
    
    
}
