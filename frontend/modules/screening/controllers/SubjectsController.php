<?php

namespace app\modules\screening\controllers;

use Yii;
use common\models\Subjects;
use common\models\SubjectsSearch;
use common\components\XController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SubjectsController implements the CRUD actions for Subjects model.
 */
class SubjectsController extends XController
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
    public function actionSearch($screening_form_id)
    {


        if (! \Yii::$app->screeningform->isManager($screening_form_id))
            throw new \yii\web\HttpException(403, yii::t('app', 'No permission to access page.'));

        $searchModel = new SubjectsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('search', [
            'model' => $searchModel,
            'dataProvider' => $dataProvider,
            'screening_form_id'=> $screening_form_id 
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
    public function actionIndex()
    {
        $searchModel = new SubjectsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->post());

        //print_r(Yii::$app->request->post('screening_form_id')); 
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'screening_form_id'=>Yii::$app->request->post('screening_form_id')
        ]);
    }
    /* ******************************************************************************************************* */ 
    
    /* ******************************************************************************************************* */ 
    /* ******************************************************************************************************* */ 
    /* ******************************************************************************************************* */ 
    /* ******************************************************************************************************* */ 
    
    
    /* ******************************************************************************************************* */ 
    
    /**
     * Displays a single Subjects model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    /* ******************************************************************************************************* */ 
    
    /**
     * Creates a new Subjects model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Subjects();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
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

    /**
     * Finds the Subjects model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Subjects the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Subjects::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
