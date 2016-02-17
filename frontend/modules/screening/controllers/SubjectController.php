<?php

namespace app\modules\screening\controllers;

use Yii;
use common\models\Subject;
use frontend\modules\screening\models\SubjectScreeningSearch;
use common\components\XController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SubjectsController implements the CRUD actions for Subjects model.
 */
class SubjectController extends XController
{
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

    

    /* ******************************************************************************************************* */ 
    public function actionSearch($resource_id, $screening_form_id, $project_id)
    {


        if (! \Yii::$app->project->canUse($project_id))
             throw new \yii\web\HttpException(403, yii::t('app', 'No permission to access page.'));

        if (! \yii::$app->ScreeningForm->canUse($screening_form_id))
             throw new \yii\web\HttpException(403, yii::t('app', 'No permission to access page.'));
        
        if (! \Yii::$app->resourcecomponent->canUse($resource_id))
             throw new \yii\web\HttpException(403, yii::t('app', 'No permission to access page.'));
        
        $searchModel = new SubjectScreeningSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('search', [
            'model' => $searchModel,
            'dataProvider' => $dataProvider,
            'screening_form_id'=> $screening_form_id, 
            'resource_id'=> $resource_id, 
            'project_id'=>$project_id 
        ]);

    }
    /* ******************************************************************************************************* */ 
    /* ******************************************************************************************************* */ 
    /* ******************************************************************************************************* */ 
    /* ******************************************************************************************************* */ 
    /* ******************************************************************************************************* */ 
    
    /**
     * Lists all Subjects models.
     * @return mixed
     */
    public function actionIndex($hash=null)
    {

        $searchModel = new SubjectScreeningSearch();
        // if you came from a create get the subject from a hash 
        if ($hash !== null) 
                $dataProvider = $searchModel->search(['hash'=>$hash]); 
        else 
          // you have performed a search on an existing subject - may / may not have a result  
            $dataProvider = $searchModel->search(Yii::$app->request->post());
        
        yii::$app->ScreeningForm->screening_form_id = Yii::$app->request->post('screening_form_id'); 
        yii::$app->ScreeningForm->project_id = Yii::$app->request->post('project_id'); 
        yii::$app->ScreeningForm->resource_id = Yii::$app->request->post('resource_id'); 
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    /* ******************************************************************************************************* */ 
    
    /* ******************************************************************************************************* */ 
    /* ******************************************************************************************************* */ 
    /* ******************************************************************************************************* */ 
    /* ******************************************************************************************************* */ 
    
    
    /* ******************************************************************************************************* */ 
    
    
    /* ******************************************************************************************************* */ 
    
    /**
     * Creates a new Subjects model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Subject();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'hash' => $model->hash]);
        } else {
            
            if (Yii::$app->request->post('first_name'))
                $model->first_name = Yii::$app->request->post('first_name'); 
            
            if (Yii::$app->request->post('last_name'))
                $model->last_name = Yii::$app->request->post('last_name');
           
            if (Yii::$app->request->post('dob'))
                 $model->dob = Yii::$app->request->post('dob');
            

            return $this->render('create', [
                'model' => $model,
                'screening_form_id'=>Yii::$app->request->post('screening_form_id'), 
                'resource_id'=>Yii::$app->request->post('resource_id'), 
                'project_id'=>Yii::$app->request->post('project_id')
                ]);
        }
    }
    
    /* ******************************************************************************************************* */ 
    
    /**
     * Updates an existing Subjects model.
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
 /* ******************************************************************************************************* */ 
   
    /**
     * Deletes an existing Subjects model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
 /* ******************************************************************************************************* */ 
   
    /**
     * Finds the Subjects model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Subjects the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Subject::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    
}
