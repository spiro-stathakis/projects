<?php

namespace app\modules\screening\controllers;

use Yii;
use common\models\Subject;
use frontend\modules\screening\models\SubjectScreeningSearch;
//use common\components\XController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SubjectsController implements the CRUD actions for Subjects model.
 */
class SubjectController extends ScreeningController
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
    public function actionSearch($project_id)  // step 3 of screening process
    {

        if (! \Yii::$app->project->canUse($project_id))
             throw new \yii\web\HttpException(403, yii::t('app', 'No permission to access page.'));

        if (! \yii::$app->ScreeningForm->canUse($this->getScreeningSession('screening_form_id')))
             throw new \yii\web\HttpException(403, yii::t('app', 'No permission to access page.'));
        
        if (! \yii::$app->resourcecomponent->canUse($this->getScreeningSession('resource_id')))
             throw new \yii\web\HttpException(403, yii::t('app', 'No permission to access page.'));
        
        $this->setScreeningSession('project_id', $project_id); 

        $searchModel = new SubjectScreeningSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('search', [
            'model' => $searchModel,
            'dataProvider' => $dataProvider,
            
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
    public function actionIndex() // step 4 of screening process
    {

        $searchModel = new SubjectScreeningSearch();
        // if you came from a create get the subject from a hash 
        
        $dataProvider = $searchModel->search(['hash'=>$this->getScreeningSession('subject_hash')]); 
        
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
            $this->setScreeningSession('subject_hash', $model->hash);
            return $this->redirect(['index']);
        } else {
            
            if (Yii::$app->request->post('first_name'))
                $model->first_name = Yii::$app->request->post('first_name'); 
            
            if (Yii::$app->request->post('last_name'))
                $model->last_name = Yii::$app->request->post('last_name');
           
            if (Yii::$app->request->post('dob'))
                 $model->dob = Yii::$app->request->post('dob');
            
            return $this->render('create', ['model' => $model]);
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
