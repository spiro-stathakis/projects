<?php

namespace app\modules\collections\controllers;

use Yii;
use common\models\Collection;
use common\models\CollectionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use common\components\Types;

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
                                    ['actions' => ['edit'], 'allow' => true, 'roles' => ['editCalendar'],], 
                                    ['actions' => ['view'], 'allow' => true, 'roles' => ['editCalendar'],], 
                                    ['actions' => ['index'], 'allow' => true, 'roles' => ['@'],], 
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

    /**
     * Updates an existing Collection model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

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
