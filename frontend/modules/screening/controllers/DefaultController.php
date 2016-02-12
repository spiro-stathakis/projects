<?php

namespace app\modules\screening\controllers;

use Yii; 
use common\components\XController;
use common\models\Subject; 
use common\models\ScreeningForm; 
use common\models\ScreeningQuestion; 
use common\models\ScreeningEntry; 
use common\models\ScreeningResponse;  
use yii\filters\AccessControl; 
use common\components\Types; 
class DefaultController extends XController
{
	

 public $defaultAction = 'form';
    /* ************************************************************************************************************************* */ 
   
     public function behaviors()
    {
        return [
                'access' => [
                        'class' => AccessControl::className(),
                        'rules' => [
                                    ['actions' => ['form'], 'allow' => true, 'roles' => ['@'],], 
                                    ['actions' => ['project'], 'allow' => true, 'roles' => ['@'],], 
                                    
                                    ['actions' => ['create'], 'allow' => true, 'roles' => ['@'],],
                                    ['actions' => ['update'], 'allow' => true, 'roles' => ['@'],], 
                                   // ['actions' => ['active'], 'allow' => true, 'roles' => ['@'],], 
                                    ['actions' => ['signature'], 'allow' => true, 'roles' => ['@'],],
                                    ['actions' => ['ajaxsign'], 'allow' => true, 'roles' => ['@'],], 
                                    ['actions' => ['confirm'], 'allow' => true, 'roles' => ['@'],],
                                     ['actions' => ['pdf'], 'allow' => true, 'roles' => ['@'],], 
                                ],
                        ],
        ];
        
    }


    /* ************************************************************************************************************************* */ 
    
    /* ************************************************************************************************************************* */ 
    
    public function actionAjaxsign($hash)
    {
         $arr = []; 
         $signature = ''; 

         $screening_entry_model = ScreeningEntry::findOne(['hash'=>$hash]);
         if ($screening_entry_model === null)
             throw new \yii\web\HttpException(404, yii::t('app', 'Page cannot be found.'));

          if (! \Yii::$app->screeningform->isManager($screening_entry_model->screening_form_id))
            throw new \yii\web\HttpException(403, yii::t('app', 'No permission to access page.'));

        $arr = explode(",", Yii::$app->request->post('signature')); 
        $signature = $arr[1]; 

        if (Yii::$app->request->post('signee') == 'subject')
        {

            $screening_entry_model->subject_signature = $signature;
            $screening_entry_model->save(); 
        }
        
        if (Yii::$app->request->post('signee') == 'researcher')
        {
                $screening_entry_model->researcher_signature =$signature;
                $screening_entry_model->progress_id = Types::$progress['published']['id']; 
                $screening_entry_model->save(); 
                $this->_generatePdf($hash); 
        }

        
        
    }    


    /* ************************************************************************************************************************* */ 
    public function actionConfirm($hash)
    {

        return $this->_generatePdf($hash); 
    }
    /* ************************************************************************************************************************* */ 
    public function actionSignature($hash)
    {
        \yii::$app->jsconfig->addData('signatureUri', \yii\helpers\Url::to(['ajaxsign' , 'hash'=>$hash])); 
        \yii::$app->jsconfig->addData('redirectUri', \yii\helpers\Url::to(['confirm' , 'hash'=>$hash])); 
        \yii::$app->jsconfig->addData('hash', $hash); 
        return $this->render('signature' , ['hash'=>$hash]); 
    }    

    /* ************************************************************************************************************************* */ 
      public function actionProject($screening_form_id)
    {
       if (! \Yii::$app->screeningform->isManager($screening_form_id))
             throw new \yii\web\HttpException(403, yii::t('app', 'No permission to access page.'));
         
       return $this->render('project', ['projectList'=>$this->_projectList(),'screening_form_id'=>$screening_form_id]);


    }
    /* ************************************************************************************************************************* */ 
    
    /* ************************************************************************************************************************* */ 
    
    public function actionForm()
    {

    	return $this->render('form', ['screeningList'=>$this->_screeningList()] );
    }

	/* ************************************************************************************************************************* */ 
    
	public function actionCreate($project_id,$screening_form_id,$subject)
	{



         
         if (! \Yii::$app->project->isMember($project_id))
            throw new \yii\web\HttpException(403, yii::t('app', 'No permission to access page.'));

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

        $screening_entry_model = $this->_initScreeningForm($project_id,$screening_form_id,$subject_model); 
        
        $this->redirect(['update' , 'hash'=>$screening_entry_model->hash]);
         

	}
    /* ************************************************************************************************************************* */ 
      /* ************************************************************************************************************************* */ 
    
    public function actionUpdate($hash)
    {
        

       

        $screening_entry_model = ScreeningEntry::findOne(['hash'=>$hash]);
        if (yii::$app->request->isPost && $screening_entry_model != null) 
        {
            if ($screening_entry_model->researcher_id != yii::$app->user->id)
                 throw new \yii\web\HttpException(403, yii::t('app', 'Permission denied.'));

            if ($screening_entry_model->progress_id == Types::$progress['published']['id'])
                 throw new \yii\web\HttpException(404, yii::t('app', 'Cannot locate this record.'));


             foreach(yii::$app->request->post() as $k=>$v)
             {
                   if (strpos( $k , 'question_' )!== false )
                   {
                        $screening_question_id = str_replace('question_','',$k); 
                        $screening_response_model =   ScreeningResponse::findOne([
                                    'screening_question_id'=>$screening_question_id, 
                                    'screening_entry_id'=>$screening_entry_model->id, 
                        ]); 
                        if ($screening_response_model !== null)
                        {
                            $screening_response_model->response = $v; 
                            $screening_response_model->save(); 
                        }

                   }
            } 
             $this->redirect(['signature', 'hash'=>$hash]); 

        }
        
        

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
    private function _projectList()
    {
        
        return \Yii::$app->project->allProjects;

    }
    /* ************************************************************************************************************************* */ 
    private function _screeningList()
    {
    	$return = []; 
    	foreach (\Yii::$app->screeningform->myScreeningForms as $screeningForm) 
    		$return[$screeningForm['collection_title']][] = [
    									'screening_form_name'=>$screeningForm['screening_form_title'], 
										'screening_form_id'=>$screeningForm['screening_form_id'], 
                                    ];
    	
    	return $return; 
    }


    /* ******************************************************************************************************* */ 
    private function _generatePdf($hash)
    {
        require_once(\yii::$app->basePath . "/../vendor/setasign/fpdf/fpdf.php");
        require_once(\yii::$app->basePath . "/../vendor/setasign/fpdi/fpdi.php");
        require_once(\yii::$app->basePath . "/../vendor/setasign/fpdi_pdf-parser/pdf_parser.php");
        require_once(\yii::$app->basePath . "/../vendor/setasign/setapdf-signer/library/SetaPDF/Autoload.php");
       

        $screening_entry_model = ScreeningEntry::findOne(['hash'=>$hash]);
        $count =1; 
        
       //class_exists('TCPDF', true); // trigger Composers autoloader to load the TCPDF class
        $pdf = new \FPDI();
        $pdf->SetAutoPageBreak(true); 
        // add a page
        $pdf->SetTopMargin(30);
        $pdf->AddPage();
        // set the source file
        $pdf->setSourceFile(\yii::$app->basePath . "/../psych-letterhead.pdf");
        // import page 1
        $tplIdx = $pdf->importPage(1);
        // use the imported page and place it at point 10,10 with a width of 100 mm
        $pdf->useTemplate($tplIdx, 0, 0);
        $pdf->SetFont('Courier', '',12);


        $pdf->SetXY(10,6);
        $pdf->Cell(150,3 ,'Confidential' ); 
        

        $pdf->SetXY(10,36);
        $pdf->MultiCell(150,3 ,yii::$app->datecomponent->timestampToUkDate($screening_entry_model->created_at), 0, 'R'); 
        $pdf->Ln();
        $pdf->MultiCell(100,3 ,$screening_entry_model->screening_form_title, 0,'' ); 
        $pdf->Ln(); 

        $pdf->SetFont('Courier', '',9);
      
        $pdf->Cell(100,4,sprintf('Participant: %s %s (dob %s)',
                                 
                                 $screening_entry_model->subject->first_name,
                                  $screening_entry_model->subject->last_name,
                                  yii::$app->datecomponent->isoToUkDate($screening_entry_model->subject->dob)

                                  ) );
      
      $pdf->Cell(50,4,sprintf('Identifier: %s', $screening_entry_model->subject->cubric_id),0,'','R' );
      
        
     
        $pdf->Ln();
       $pdf->Cell(100,4,sprintf('Researcher: %s %s (project %s)',
                                 $screening_entry_model->researcher->first_name,
                                  $screening_entry_model->researcher->last_name,
                                  $screening_entry_model->project->code
                                  ) );
       
       $pdf->Cell(50,4,sprintf('Resource: %s',
                                 'the scanner') , 0, '', 'R' );
       
       $pdf->Ln(); 
       $pdf->Ln(); 

       $pdf->SetFont('Courier', '',12);
       $pdf->Cell(150,4,sprintf('Reponses:') );
        $pdf->SetFont('Courier', '',9);
        $pdf->Ln(); 
        
       foreach (yii::$app->screeningresponse->getResponses($hash) as $response)
       {
            if (strlen($response['caption']) > 0)
            {
                $pdf->Ln();
                $pdf->Cell( 150, 4 ,sprintf('%s ' , $response['caption']) , 0 , 'U');
                $count = 1; 

            }
            else
            { 
                $pdf->Cell( 150, 4 ,sprintf('%s. %s ', $count , $response['content']));
                $pdf->Ln();  
                if ($response['response'] === null) $response['response'] = 'UNKNOWN'; 
                $pdf->Cell( 150, 4 ,sprintf('%s ', $response['response']));
                
                $count++;  
            }
            $pdf->Ln();  

           
       }
       $pdf->Ln();  
        $pdf->SetFont('Courier', '',12);
            $pdf->Cell(150,4,sprintf('Signatures:') );
        // now write some text above the imported page
       


        // NOW SET ScreeningEntry::progress_id = PUBLISHED so it cannot be edited again. 
        $pdf->Output();

    }
    /* ******************************************************************************************************* */ 
    
    /* ******************************************************************************************************* */
    private function _initScreeningForm($project_id, $screening_form_id, $subject_model)
    {
        $questions =  \yii::$app->screeningquestion->getQuestions($screening_form_id);
        $screening_entry_model = new \common\models\ScreeningEntry(); 
        $screening_entry_model->screening_form_id = $screening_form_id; 
        $screening_entry_model->project_id = $project_id; 
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

