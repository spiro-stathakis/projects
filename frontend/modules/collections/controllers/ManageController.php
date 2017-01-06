<?php

namespace app\modules\collections\controllers;

use Yii;
use common\components\Types;
use common\models\Collection;
use common\models\CollectionSearch;
use common\models\UserCollection; 
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\data\ArrayDataProvider; 
use yii\helpers\Url; 

/**
 * CollectionController implements the CRUD actions for Collection model.
 */
class ManageController extends Controller
{
  /* ********************************************************************** */ 

    public function init()
    {
        
        return parent::init(); 
    }
/* ********************************************************************** */ 
     public function behaviors()
    {
        return [
                'access' => [
                        'class' => AccessControl::className(),
                        'rules' => [
                                    ['actions' => ['create'], 'allow' => true, 'roles' => ['createCalendar'],], 
                                    ['actions' => ['update'], 'allow' => true, 'roles' => ['editCalendar'],], 
                                    ['actions' => ['view'], 'allow' => true, 'roles' => ['editCalendar'],], 
                                    ['actions' => ['index'], 'allow' => true, 'roles' => ['@'],], 
                                    ['actions' => ['members'], 'allow' => true, 'roles' => ['@'],], 
                                ],
                        ],
        ];
        
    }

/* ********************************************************************** */ 
    

    /**
     * Lists all Collection models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CollectionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    /* ********************************************************************** */ 
    /**
     * Displays a single Collection model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    /* ********************************************************************** */ 
    
    /**
     * Creates a new Collection model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Collection();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
              $userCollectionModel = new \common\models\UserCollection(); 
              $userCollectionModel->user_id  = yii::$app->user->id; 
              $userCollectionModel->collection_id = $model->id; 
              $userCollectionModel->member_type_id = Types::$member_type['manager']['id']; 
              $userCollectionModel->save(); 
              
            return $this->redirect(['/collections']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /* ************************************************************************************************ */ 
    /**
     * Updates an existing Collection model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if (yii::$app->CollectionComponent->isManager($id) === false) 
                 throw new \yii\web\HttpException(403, yii::t('app', 'No permission to access collection.'));
            
        $collectionModel = $this->findModel($id);

        if ($collectionModel->load(Yii::$app->request->post()) && $collectionModel->save()) {
            return $this->redirect(['/collections']);
        } else {
            return $this->render('update', [
                'collectionModel' => $collectionModel,
            ]);
        }
    }
    /* ************************************************************************************************ */ 
    public function actionMembers($id)
    {
          \yii::$app->jsconfig->addData('searchUri', Url::to(['ajax/searchusers'])); 
          \yii::$app->jsconfig->addData('memberTargetId', '#member-select'); 
          \yii::$app->jsconfig->addData('managerTargetId', '#manager-select'); 
          \yii::$app->jsconfig->addData('collectionId', $id); 
          \yii::$app->jsconfig->addData('addUri', Url::to(['ajax/adduser'])); 
          \yii::$app->jsconfig->addData('removeUri', Url::to(['ajax/removeuser'])); 
          \yii::$app->jsconfig->addData('memberType', Types::$member_type['member']['id']); 
          \yii::$app->jsconfig->addData('managerType', Types::$member_type['manager']['id']); 
            

          if (yii::$app->CollectionComponent->isManager($id) === false) 
                 throw new \yii\web\HttpException(403, yii::t('app', 'No permission to access collection.'));
            
          $collectionModel = Collection::findOne($id); 
          if ($collectionModel === null)
             throw new \yii\web\HttpException(404, yii::t('app', 'Cannot find collection.')); 


        return $this->render('members' , ['collectionModel'=>$collectionModel]); 
    }
    /* ************************************************************************************************ */ 
    
    /**
     * Deletes an existing Collection model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Collection model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Collection the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Collection::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
