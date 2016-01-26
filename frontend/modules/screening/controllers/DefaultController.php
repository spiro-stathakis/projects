<?php

namespace app\modules\screening\controllers;

use Yii; 
use common\components\XController;
use common\models\Subject; 
use common\models\ScreeningForm; 
use common\models\ScreeningQuestion; 
use common\models\ScreeningEntry; 
use yii\filters\AccessControl; 
use common\components\Types; 
class DefaultController extends XController
{
	

    /* ************************************************************************************************************************* */ 
   
     public function behaviors()
    {
        return [
                'access' => [
                        'class' => AccessControl::className(),
                        'rules' => [
                                    ['actions' => ['index'], 'allow' => true, 'roles' => ['@'],], 
                                    ['actions' => ['create'], 'allow' => true, 'roles' => ['@'],],
                                    ['actions' => ['update'], 'allow' => true, 'roles' => ['@'],], 
                                    ['actions' => ['active'], 'allow' => true, 'roles' => ['@'],], 
                                    ['actions' => ['subsign'], 'allow' => true, 'roles' => ['@'],], 
                                ],
                        ],
        ];
        
    }

    /* ************************************************************************************************************************* */ 
    public function actionSubsign($hash)
    {

        return $this->render('subsign'); 
    }    

    /* ************************************************************************************************************************* */ 
    public function actionActive()
    {
            $subjects = Yii::$app->session->get('subjects'); 
            print_r($subjects); 

    }
    /* ************************************************************************************************************************* */ 
    
    public function actionIndex()
    {

    	return $this->render('index', ['screeningList'=>$this->_buildScreeningList()] );
    }

	/* ************************************************************************************************************************* */ 
    
	public function actionCreate($screening_form_id,$subject)
	{



         
		 if (! \Yii::$app->screeningform->isManager($screening_form_id))
            throw new \yii\web\HttpException(403, yii::t('app', 'No permission to access page.'));

        if (Yii::$app->session->get('subjects') === null)
            Yii::$app->session->set('subjects' , []); 

        if (in_array($subject , Yii::$app->session->get('subjects')))
            $this->redirect('active');
        else 
        {
            $sub = Yii::$app->session->get('subjects');
            $sub[] =  $subject;  
            Yii::$app->session->set('subjects' , $sub); 
        }

        $subject_model = Subject::findOne(['hash'=>$subject]);
        if ($subject_model === null)
            throw new \yii\web\HttpException(404, yii::t('app', 'Cannot locate this subject.'));

        $screening_entry_model = $this->_initScreeningForm($screening_form_id, $subject_model); 
        
        $this->redirect(['update' , 'hash'=>$screening_entry_model->hash]);
         

	}
    /* ************************************************************************************************************************* */ 
      /* ************************************************************************************************************************* */ 
    
    public function actionUpdate($hash)
    {
        

       

        $screening_entry_model = ScreeningEntry::findOne(['hash'=>$hash]);
       
        return $this->render('update', ['responses'=>yii::$app->screeningresponse->getResponses($hash),
                                'subject_model'=> Subject::findOne($screening_entry_model->subject_id), 
                                'screening_form_model'=>ScreeningForm::findOne($screening_entry_model->screening_form_id), 
                                'screening_questions'=>\yii::$app->screeningresponse->getResponses($hash),
                                'count'=>1, 
                                'hash'=>$hash, 

            ]);  

    }
    /* ************************************************************************************************************************* */ 
    
    /* ************************************************************************************************************************* */ 
    /* PRIVATE FUNCTIONS */ 
	/* ************************************************************************************************************************* */ 
    private function _buildScreeningList()
    {
    	$return = []; 
    	foreach (\Yii::$app->screeningform->allManagment as $screeningForm) 
    		$return[$screeningForm['collection_name']][] = [
    									'screening_form_name'=>$screeningForm['screening_form_name'], 
										'screening_form_id'=>$screeningForm['screening_form_id'], 


    									] ;
    	
    	return $return; 


    }


    /* ******************************************************************************************************* */ 
    /* ******************************************************************************************************* */ 
    
     /* ******************************************************************************************************* */ 
    private function _initScreeningForm($screening_form_id, $subject_model)
    {
        $questions =  \yii::$app->screeningquestion->getQuestions($screening_form_id);
        $screening_entry_model = new \common\models\ScreeningEntry(); 
        $screening_entry_model->screening_form_id = $screening_form_id; 
        $screening_entry_model->subject_id = $subject_model->id; 
        $screening_entry_model->researcher_id = \Yii::$app->user->identity->id ;
        
        if ($screening_entry_model->save() == false)
            throw new \yii\web\HttpException(500, yii::t('app', 'An error occured.'));

        foreach($questions as $q)
        {
           $model = new \common\models\ScreeningResponse; 
           $model->screening_question_id = $q['screening_question_id']; 
           $model->screening_entry_id = $screening_entry_model->id; 
           $model->subject_id = $subject_model->id; 
           $model->save(); 
        }

           
        return $screening_entry_model;        

        

    }
    /* ******************************************************************************************************* */ 
    /* ******************************************************************************************************* */ 
    

}

