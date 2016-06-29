<?php

namespace app\modules\calendar\controllers;

use Yii;
use frontend\modules\calendar\models\EventEntry;
use frontend\modules\calendar\models\EventEntrySearch;
use common\components\XController;
use common\components\Types; 
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * EventEntryController implements the CRUD actions for EventEntry model.
 */
class EventEntryController extends XController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /* ********************************************************************** */ 
    /**
     * Lists all EventEntry models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EventEntrySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    /* ********************************************************************** */ 
    /**
     * Displays a single EventEntry model.
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
     * Creates a new EventEntry model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new EventEntry();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
    /* ********************************************************************** */ 
    /**
     * Updates an existing EventEntry model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($ee_id)
    {
        $eventEntryModel = $this->findModel($ee_id);

        if ($eventEntryModel->load(Yii::$app->request->post()) && $eventEntryModel->save()) {
            return $this->redirect(['view', 'id' => $eventEntryModel->id]);
        } else {
            return $this->render('update', [
                'eventEntryModel' => $eventEntryModel,
            ]);
        }
    }
    /* ********************************************************************** */ 

    /**
     * Deletes an existing EventEntry model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($ee_id)
    {
        $request = yii::$app->request; 
        $model = $this->findModel($ee_id);
        $model->status_id = Types::$status['inactive']['id']; 
        $model->save(); 
        return $this->redirect(['/calendar/manage/events', 'id'=>$model->event->calendar_id]);
    }
    /* ********************************************************************** */ 
    /**
     * Finds the EventEntry model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return EventEntry the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = EventEntry::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
