<?php

namespace app\modules\screening\controllers;

use Yii; 
use common\components\XController;
use common\models\Subject; 
use common\models\ScreeningForm; 
use common\models\ScreeningFormQuestion; 
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
                                ],
                        ],
        ];
        
    }

    /* ************************************************************************************************************************* */ 
    
    public function actionIndex()
    {

    	return $this->render('index', ['screeningList'=>$this->_buildScreeningList()] );
    }

	/* ************************************************************************************************************************* */ 
    
	public function actionCreate($screening_form_id,$subject_id)
	{

        $items = []; 
		 if (! \Yii::$app->screeningform->isManager($screening_form_id))
            throw new \yii\web\HttpException(403, yii::t('app', 'No permission to access page.'));

        $screening_form_model = ScreeningForm::findOne($screening_form_id);
        $subject_model = Subject::findOne($subject_id); 
        $screening_questions = \yii::$app->screeningformquestion->getQuestions($screening_form_id);
        foreach ($screening_questions as $question)
            $items[] = ['caption'=>$question['title'], 
                            'content'=>$question['name'], 
                            'input_type_id'=>$question['input_type_id']];

        return $this->render('create', ['subject_model'=>$subject_model,
                                        'screening_form_model'=>$screening_form_model, 
                                        'screening_questions'=>$items

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

}

