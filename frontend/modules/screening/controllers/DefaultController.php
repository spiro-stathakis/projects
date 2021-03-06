<?php

namespace app\modules\screening\controllers;

use Yii; 
//use common\components\XController;
use common\models\Subject; 
use common\models\ScreeningForm; 
use common\models\ScreeningQuestion; 
use common\models\ScreeningEntry; 
use common\models\ScreeningResponse;
use common\models\Resource;  
use yii\filters\AccessControl; 
use common\components\Types; 
class DefaultController extends ScreeningController
{
	

 public $defaultAction = 'form';
    /* ****************************************************************************************************************** */ 
   
     public function behaviors()
    {
        return [
                'access' => [
                        'class' => AccessControl::className(),
                        'rules' => [
                                    ['actions' => ['form'], 'allow' => true, 'roles' => ['@'],], 
                                    ['actions' => ['resource'], 'allow' => true, 'roles' => ['@'],], 
                                    ['actions' => ['project'], 'allow' => true, 'roles' => ['@'],], 
                                    
                                    ['actions' => ['create'], 'allow' => true, 'roles' => ['@'],],
                                    ['actions' => ['update'], 'allow' => true, 'roles' => ['@'],], 
                                   // ['actions' => ['active'], 'allow' => true, 'roles' => ['@'],], 
                                    ['actions' => ['signature'], 'allow' => true, 'roles' => ['@'],],
                                    ['actions' => ['ajaxsign'], 'allow' => true, 'roles' => ['@'],], 
                                    ['actions' => ['confirm'], 'allow' => true, 'roles' => ['@'],],
                                    ['actions' => ['pdf'], 'allow' => true, 'roles' => ['@'],],
                                    ['actions' => ['finish'], 'allow' => true, 'roles' => ['@'],], 
                                ],
                        ],
        ];
        
    }


    /* ********************************************************************************************************************** */ 
    
    /* *********************************************************************************************************************** */ 
    
    public function actionForm() // step 0 of screening process 
    {

      $this->resetScreeningSession(); 
      $screeningList = $this->_screeningList(); 
      if (count($screeningList) == 0 )
            throw new \yii\web\HttpException(403, yii::t('app', 'No permission to access screening forms.'));
      

      return $this->render('form', ['screeningList'=>$screeningList] );
    }
    
    /* ********************************************************************************************************************** */ 
    /* ********************************************************************************************************************* */ 
    public function actionResource( $screening_form_id) // step 1 of screening process 
    {
       if (! \yii::$app->ScreeningForm->canUse($screening_form_id))
             throw new \yii\web\HttpException(403, yii::t('app', 'No permission to access page.'));
        
        $this->setScreeningSession('screening_form_id', $screening_form_id); 
        
        $screening_form_model  = ScreeningForm::findOne(['id'=>$screening_form_id]); 
        return $this->render('resource', ['resourceList'=>$this->_resourceList($screening_form_model->collection_id)]);
    }
    /* ********************************************************************************************************************** */ 
     public function actionProject($resource_id)  // step 2 of screening process 
    {
      
      if (! \yii::$app->ScreeningForm->canUse($this->getScreeningSession('screening_form_id')))
             throw new \yii\web\HttpException(403, yii::t('app', 'No permission to access screening form.'));
      if (! \Yii::$app->ResourceComponent->canUse($resource_id))
              throw new \yii\web\HttpException(403, yii::t('app', 'No permission to access resource.'));

     
      $this->setScreeningSession('resource_id', $resource_id);
      return $this->render('project', ['projectList'=>$this->_projectList($resource_id)]);
    
    }
    /* ********************************************************************************************************************** */ 
    
    // step 3 of screening process lies in subject/search (SubjectController)
    // step 4 of screening process lies in subject/index (SubjectController) 


    /* ********************************************************************************************************************** */ 
   /* ************************************************************************************************************************* */ 
    
    public function actionCreate($subject)   // step 5 of screening process 
    {

          if (! \Yii::$app->ProjectComponent->canUse($this->getScreeningSession('project_id')))
               throw new \yii\web\HttpException(403, yii::t('app', 'No permission to access page.'));

          if (! \yii::$app->ScreeningForm->canUse($this->getScreeningSession('screening_form_id')))
               throw new \yii\web\HttpException(403, yii::t('app', 'No permission to access page.'));
          
          if (! \yii::$app->ResourceComponent->canUse($this->getScreeningSession('resource_id')))
               throw new \yii\web\HttpException(403, yii::t('app', 'No permission to access page.'));

          $subject_model = Subject::findOne(['hash'=>$subject]);
          if ($subject_model === null)
              throw new \yii\web\HttpException(404, yii::t('app', 'Cannot locate this subject.'));
      

        $this->setScreeningSession('subject_hash', $subject);
        $screening_form_model = ScreeningForm::findOne(['id'=>$this->getScreeningSession('screening_form_id')]);
        $resource_model = Resource::findOne(['id'=>$this->getScreeningSession('resource_id')]);
         

        if ($resource_model->collection_id !== $screening_form_model->collection_id)
              throw new \yii\web\HttpException(403, yii::t('app', 'No permission to access page. Type mismatch'));

        $this->_initScreeningForm($subject_model); 
          
        $this->redirect(['update']);
           

    }

    /* ********************************************************************************************************************** */ 
    
public function actionUpdate()   // step 6 of screening process 
    {
        
        $screening_entry_model = ScreeningEntry::findOne(['hash'=>$this->getScreeningSession('screening_hash')]);
        if ($screening_entry_model->researcher_id != yii::$app->user->id)
                 throw new \yii\web\HttpException(403, yii::t('app', 'Permission denied.'));

        if ($screening_entry_model->progress_id == Types::$progress['published']['id'])
                 throw new \yii\web\HttpException(404, yii::t('app', 'Cannot locate this record.'));

        if (yii::$app->request->isPost && $screening_entry_model != null) 
        {
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
            $this->redirect(['signature']); 

        }
        
        return $this->render('update', [
            'responses'=>yii::$app->screeningresponse->getResponses($this->getScreeningSession('screening_hash')),
            'subject_model'=> Subject::findOne($screening_entry_model->subject_id), 
            'screening_form_model'=>ScreeningForm::findOne($screening_entry_model->screening_form_id), 
              'screening_questions'=>\yii::$app->screeningresponse->getResponses($this->getScreeningSession('screening_hash')),
                                'count'=>1, 

            ]);  

    }
    /* ******************************************************************************************************************** */ 
     public function actionSignature() // step 7 of screening process 
        {
            
            \yii::$app->jsconfig->addData('signatureUri', \yii\helpers\Url::to(['ajaxsign' , 'hash'=>$this->getScreeningSession('screening_hash')])); 
            
            \yii::$app->jsconfig->addData('redirectUri', \yii\helpers\Url::to(['confirm' , 'hash'=>$this->getScreeningSession('screening_hash')])); 
            
            \yii::$app->jsconfig->addData('screening_hash', $this->getScreeningSession('screening_hash')); 
            return $this->render('signature'); 
        }    

   
    /* ********************************************************************************************************************* */ 
   
    /* ******************************************************************************************************************* */ 
       
    public function actionAjaxsign($hash)
    {
         $arr = []; 
         $signature = ''; 
         $filename = sprintf('%s.png', tempnam('/tmp', ''));
         $imageWidth = 200; 
         $imageHeight = 100; 
         $resizeCommand =''; 
         if (file_exists('/usr/bin/convert'))
            $imageMagick = '/usr/bin/convert'; 
         if (file_exists('/usr/local/bin/convert'))
            $imageMagick = '/usr/local/bin/convert'; 


         $screening_entry_model = ScreeningEntry::findOne(['hash'=>$hash]);
         if ($screening_entry_model === null)
             throw new \yii\web\HttpException(404, yii::t('app', 'Page cannot be found.'));

          if (! \yii::$app->ScreeningForm->isManager($screening_entry_model->screening_form_id))
            throw new \yii\web\HttpException(403, yii::t('app', 'No permission to access page.'));

        $arr = explode(",", Yii::$app->request->post('signature')); 
        $signature = $arr[1]; 
        
        $decoded_image = base64_decode($signature);
        file_put_contents($filename,$decoded_image);
        
        if (Yii::$app->request->post('signee') == 'subject')
        {
            $screening_entry_model->subject_signature = $signature;
            $screening_entry_model->save(); 
            $resizeCommand = sprintf('%s %s -resize %sx%s %s' , 
                                $imageMagick, $filename, $imageWidth, $imageHeight, 
                                sprintf('/tmp/subject-%s.png', $hash) 
                ); 
            system( $resizeCommand);
            echo $resizeCommand;  
        }
        
        if (Yii::$app->request->post('signee') == 'researcher')
        {
                $screening_entry_model->researcher_signature =$signature;
                $screening_entry_model->progress_id = Types::$progress['published']['id']; 
                $screening_entry_model->save(); 
                $resizeCommand = sprintf('%s %s -resize %sx%s %s' , 
                                $imageMagick, $filename, $imageWidth, $imageHeight, 
                                sprintf('/tmp/researcher-%s.png', $hash)
                ); 
                 system( $resizeCommand); 
                $this->_generatePdf(); 
        }
      
       

        
        
    }    


    /* ************************************************************************************************************************* */

    public function actionFinish($sig)
    {

      $screening_entry_model = ScreeningEntry::findOne(['hash'=>$sig]); 
      if ( $screening_entry_model === null) 
          throw new \yii\web\HttpException(404, yii::t('app', 'Page cannot be found.'));
        
      $subject_model = Subject::findOne(['id'=>$screening_entry_model->subject_id]); 
      Yii::$app->user->logout();
      return $this->render('finish',['cubric_identifier'=>$subject_model->cubric_id]);

    }
    /* ************************************************************************************************************************* */ 
    public function actionConfirm()
    {
        $screening_hash =  $this->getScreeningSession('screening_hash'); 
        if ($this->_generatePdf($screening_hash))
          $this->redirect(['finish', 'sig'=>$screening_hash]); 

    }
    /* ********************************************************************************************************************* */ 
   
    
    

	
    /* ******************************************************************************************************************** */ 
      /* **************************************************************************************************************** */ 
    
    
    
    /* ************************************************************************************************************************* */ 
    /* PRIVATE FUNCTIONS */ 
	
    /* ************************************************************************************************************************* */ 
    private function _projectList($resource_id)
    {
        
        $resourceModel = Resource::findOne($resource_id); 
        if ($resourceModel == null)
           throw new \yii\web\HttpException(404, yii::t('app', 'Cannot find page.'));

        if (\yii::$app->CollectionComponent->isManager($resourceModel->collection_id)) 
          return \Yii::$app->ProjectComponent->allProjects;
        else 
          return \Yii::$app->ProjectComponent->myProjects;
    }
    /* ************************************************************************************************************************* */ 
    private function _screeningList()
    {
    	$return = []; 
    	foreach (\yii::$app->ScreeningForm->myScreeningForms as $screeningForm) 
    		$return[$screeningForm['collection_title']][] = [
    									'screening_form_name'=>$screeningForm['screening_form_title'], 
										'screening_form_id'=>$screeningForm['screening_form_id'], 
                                    ];
    	
    	return $return; 
    }


    /* ******************************************************************************************************* */ 

    private function _resourceList($collection_id = 0)
    {
      $return = []; 
      foreach (\Yii::$app->ResourceComponent->myResources as $res) 
          if ($collection_id == 0 ||  $collection_id == $res['collection_id']) 
                $return[$res['collection_title']][] = [
                          'resource_title'=>$res['resource_title'], 
                          'resource_id'=>$res['resource_id'], 
                                    ];
      
      return $return; 
    }
    /* ******************************************************************************************************* */ 

    private function _generatePdf($hash)
    {
       return \Yii::$app->PdfComponent->createScreeningPdf($hash); 
    }
    /* ******************************************************************************************************* */ 
    
    /* ******************************************************************************************************* */
    private function _initScreeningForm($subject_model)
    {
        $questions =  \yii::$app->screeningquestion->getQuestions($this->getScreeningSession('screening_form_id'));
        $resource_model = Resource::findOne(['id'=>$this->getScreeningSession('resource_id')]); 
        $screening_form_model = ScreeningForm::findOne(['id'=>$this->getScreeningSession('screening_form_id')]);
        $screening_entry_model = new \common\models\ScreeningEntry(); 
        $screening_entry_model->screening_form_id = $this->getScreeningSession('screening_form_id'); 
        $screening_entry_model->project_id = $this->getScreeningSession('project_id'); 
        $screening_entry_model->subject_id = $subject_model->id; 
        $screening_entry_model->researcher_id = \Yii::$app->user->identity->id ;
        $screening_entry_model->screening_form_title = $screening_form_model->title ;
        $screening_entry_model->resource_id = $this->getScreeningSession('resource_id');
        $screening_entry_model->resource_title = $resource_model->title;
        if ($screening_entry_model->save() == false)
          throw new \yii\web\HttpException(500, yii::t('app', 'An error occured.'));
           
         $this->setScreeningSession('screening_hash', $screening_entry_model->hash); 
        foreach($questions as $q)
        {
           $model = new \common\models\ScreeningResponse; 
           $model->screening_question_id = $q['screening_question_id']; 
           $model->screening_entry_id = $screening_entry_model->id; 
           $model->subject_id = $subject_model->id; 
           $model->save(); 
        }

           
        return true;        

        

    }
    /* ******************************************************************************************************* */ 
    /* ******************************************************************************************************* */ 
    

}

