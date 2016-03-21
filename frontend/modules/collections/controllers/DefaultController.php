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
class DefaultController  extends \common\components\XController
{
   

	protected $collectionComponent;
	

	/* ****************************************************************************************************************** */ 
   	public function init()
   	{
   		$this->collectionComponent = \yii::$app->CollectionComponent;
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
                                    ['actions' => ['ajaxsearchusers'], 'allow' => true, 'roles' => ['@'],], 
                                    ['actions' => ['ajaxadduser'], 'allow' => true, 'roles' => ['@'],], 
                                    ['actions' => ['ajaxremoveuser'], 'allow' => true, 'roles' => ['@'],], 
                                   
                                    ],
                        ],
        ];
        
    }


    /* ********************************************************************************************************************** */ 
    
    /* *********************************************************************************************************************** */ 
    
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
    	$memberProvider  =  new ArrayDataProvider([
    			'allModels' =>$this->collectionComponent->getAllMemberships(),
    			'pagination'=>false, 
    	]);
    	$managerProvider  =  new ArrayDataProvider([
    			'allModels' =>$this->collectionComponent->getAllManagement(),
    			'pagination'=>false, 
    	]);

     	return $this->render('index' , ['memberProvider'=>$memberProvider,'managerProvider'=>$managerProvider]);
    }
    /* *********************************************************************************************************************** */ 
    public function actionMembers($id)
    {

    	if ($this->collectionComponent->isManager($id) === false) 
    		 throw new \yii\web\HttpException(403, yii::t('app', 'No permission to access collection.'));
    	
      $collectionModel = Collection::findOne($id); 
      if ($collectionModel === null)
         throw new \yii\web\HttpException(404, yii::t('app', 'Cannot find collection.')); 


    	return $this->render('members' , ['collectionModel'=>$collectionModel]); 
    }


    /* *********************************************************************************************************************** */ 
    public function actionAjaxsearchusers($q=null, $id=null)
    {
          \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return \yii::$app->UserComponent->ajaxSearchActiveUsers($q);
           
    }
    /* *********************************************************************************************************************** */ 
    public function actionAjaxadduser() //$collection_id, $member_type, $user_id
    {
          
          \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
          $user_id = \yii::$app->request->post('id'); 
          $collection_id = \yii::$app->request->post('col');
          $member_type_id = \yii::$app->request->post('mem');

          if ($this->collectionComponent->isManager($collection_id ) === false) 
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
    public function actionAjaxremoveuser()
    {
          
           \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
          $user_id = \yii::$app->request->post('id'); 
          $collection_id = \yii::$app->request->post('col');
          $member_type_id = \yii::$app->request->post('mem');

          if ($this->collectionComponent->isManager($collection_id ) === false) 
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
