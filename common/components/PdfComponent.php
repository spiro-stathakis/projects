<?php 
namespace common\components; 
use Yii; 
use yii\base\Object;
use common\models\Subject; 
use common\models\ScreeningForm; 
use common\models\ScreeningQuestion; 
use common\models\ScreeningEntry; 
use common\models\ScreeningResponse;
use common\models\Resource;
use common\components\Types;


class PdfComponent extends Object
{

  
   private $_font = 'Helvetica'; 
  
  /* ******************************************************************************************************* */ 
    /* ******************************************************************************************************* */ 
    /* ******************************************************************************************************* */ 
   
    /* ******************************************************************************************************* */ 
    public function init()
    {
        require_once(\yii::$app->basePath . "/../vendor/setasign/fpdf/fpdf.php");
        require_once(\yii::$app->basePath . "/../vendor/setasign/fpdi/fpdi.php");
        require_once(\yii::$app->basePath . "/../vendor/setasign/fpdi_pdf-parser/pdf_parser.php");
        require_once(\yii::$app->basePath . "/../vendor/setasign/setapdf-signer/library/SetaPDF/Autoload.php");
       

        return parent::init(); 
    }
    /* ******************************************************************************************************* */ 
    public function createScreeningPdf($hash)
    {
        
        $screening_entry_model = ScreeningEntry::findOne(['hash'=>$hash]);
        $screening_form_model = ScreeningForm::findOne(['id'=>$screening_entry_model->screening_form_id]); 
        $subject_model = Subject::findOne(['id'=>$screening_entry_model->subject_id]); 



        $count =1; 
        
        //$permissions = \SetaPDF_Core_SecHandler::PERM_DIGITAL_PRINT ;
        $this->_font= 'Helvetica';

        

       //class_exists('TCPDF', true); // trigger Composers autoloader to load the TCPDF class
        $pdf = new \FPDI();
        
        $pdf->SetAutoPageBreak(true); 
        // add a page
        $pdf->SetTopMargin(30);
        $pdf->AddPage();
        $pdf->setSourceFile(\yii::$app->basePath . "/../letterhead-mini-header.pdf");
        $tplIdx = $pdf->importPage(1);
        // use the imported page and place it at point 10,10 with a width of 100 mm
        $pdf->useTemplate($tplIdx, 0, 0);
        $pdf->SetFont($this->_font, '',9);


        $pdf->SetXY(10,6);
        $pdf->Cell(0,3 ,'Confidential - Participant screening form' ); 
        
        $pdf->SetFont($this->_font, '',12);
        $pdf->SetXY(10,14);
        $pdf->MultiCell(150,3 ,yii::$app->datecomponent->timestampToUkDate($screening_entry_model->created_at), 0, 'R'); 
        
        $pdf->MultiCell(100,3 ,$screening_entry_model->screening_form_title, 0,'' ); 
        $pdf->Ln(); 


        $pdf->SetFont($this->_font, '',9);
      
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
                                 $screening_entry_model->resource_title) , 0, '', 'R' );
       
       
      $pdf->SetXY(10,38);
      $pdf->SetFont($this->_font, '',12);
      $pdf->Cell(150,4,sprintf('Responses') );
      $pdf->SetFont($this->_font, '',9);
      $pdf->Ln(); 
        
       foreach (yii::$app->screeningresponse->getResponses($hash) as $response)
       {
            if (strlen($response['caption']) > 0)
            {
                $pdf->Ln();
                $pdf->MultiCell( 180, 4 ,sprintf('%s ' , $response['caption']) , 0 , 'U');
                $count = 1; 
                
            }
           
            $pdf->MultiCell( 180, 4 ,sprintf('%s. %s ', $count , $response['content']));
            
            $pdf->SetFont($this->_font, 'B',9);
            if ($response['response'] === null) $response['response'] = 'Not specified / Unknown.'; 
            $pdf->MultiCell( 180, 4 ,sprintf('%s ', $response['response']));
            $pdf->SetFont($this->_font, '',9);
            $count++;  
            
            $pdf->Ln();  
        }
       $pdf->Ln();  
        $pdf->SetFont($this->_font, '',12);
       $pdf->Cell(180,4,sprintf('Signatures') );
       $pdf->Ln(); 
       $pdf->Ln(); 
       
       
         $pdf->SetFont($this->_font, '',9);
        $pdf->Cell( 100, 4 ,'Participant ');
        $pdf->Cell( 100, 4 ,'Researcher ');
        $pdf->Ln(); 
        $pdf->Ln(); 
        $currentX = $pdf->GetX();
        $currentY = $pdf->GetY();
        $pdf->Image( sprintf('/tmp/subject-%s.png' , $hash) , $currentX , $currentY );
        $currentX = $pdf->GetX();
        
        $pdf->Image( sprintf('/tmp/researcher-%s.png' , $hash) , $currentX +100 , $currentY );
        // now write some text above the imported page
       


        // NOW SET ScreeningEntry::progress_id = PUBLISHED so it cannot be edited again. 
       // $pdfData = $pdf->Output('S');
       
        // create a writer
        // create a Http writer
         //$writer = new \SetaPDF_Core_Writer_Http("fpdf-sign-demo.pdf", true);
        
        // load document by filename
        
        //$document = new \SetaPDF_Core_Document::loadByString($pdfData, $writer);
       //$document = new \SetaPDF_Core_Reader_File($pdf->Output(), $writer);
      

      $writer = new \SetaPDF_Core_Writer_File("/tmp/myPDF.pdf");
      $document = \SetaPDF_Core_Document::loadByString($pdf->Output("S"), $writer); 

        // let's prepare the temporary file writer:
        \SetaPDF_Core_Writer_TempFile::setTempDir("/tmp/");
       
       // create a signer instance for the document
        $signer = new \SetaPDF_Signer($document);


        // add a field with the name "Signature" to the top left of page 1
        $signer->addSignatureField(
            \SetaPDF_Signer_SignatureField::DEFAULT_FIELD_NAME,                  // Name of the signature field
            1,                              // put appearance on page 1
            \SetaPDF_Signer_SignatureField::POSITION_LEFT_BOTTOM,
            array('x'=>10, 'y'=>10),   // Translate the position (x 50, y -80 -> 50 points right, 80 points down)
            180,                            // Width - 180 points
            50                              // Height - 50 points
        );

        // set some signature properties
        $signer->setReason('Integrity');
        $signer->setLocation('CUBRIC');
        $signer->setContactInfo('+44 2920 703859');

        // ccreate an OpenSSL module instance
        $module = new \SetaPDF_Signer_Signature_Module_OpenSsl();
        // set the sign certificate
        $module->setCertificate(file_get_contents("/Users/spiro/Sites/projects/certs/certificate.pem"));
        // set the private key for the sign certificate
        $module->setPrivateKey(array(file_get_contents("/Users/spiro/Sites/projects/certs/key.pem"),""));





        // create a Signature appearance
        $visibleAppearance = new \SetaPDF_Signer_Signature_Appearance_Dynamic($module);
        // choose a document to get the background from and convert the art box to an xObject
        $backgroundDocument = \SetaPDF_Core_Document::loadByFilename(Yii::getAlias('@frontend/web/img/cubric-logo.pdf') );
        $backgroundXObject = $backgroundDocument->getCatalog()->getPages()->getPage(1)->toXObject($document);
        


        // format the date
        $visibleAppearance->setShowFormat(
            \SetaPDF_Signer_Signature_Appearance_Dynamic::CONFIG_DATE, 'd-m-Y H:i:s'
        );
        // disable the distinguished name
        $visibleAppearance->setShow(
            \SetaPDF_Signer_Signature_Appearance_Dynamic::CONFIG_DISTINGUISHED_NAME, false
        );
        // set the background with 50% opacity
        $visibleAppearance->setGraphic($backgroundXObject, .5);
        //$visibleAppearance->setBackgroundLogo($backgroundXObject, .5);
        // sign/certify the document


        


        // define the appearance
        $signer->setAppearance($visibleAppearance);

        $signer->sign($module);

        
      if (file_exists(sprintf('/tmp/subject-%s.png', $hash)))
      ; //   unlink(sprintf('/tmp/subject-%s.png' , $hash)); 
        
        if (file_exists(sprintf('/tmp/researcher-%s.png',$hash)))
        ;   //     unlink(sprintf('/tmp/researcher-%s.png' , $hash)); 


        return true; 
           
    }
    /* ******************************************************************************************************* */ 
    /* ******************************************************************************************************* */ 
    
    /* ******************************************************************************************************* */ 
    
    
  
    /* ******************************************************************************************************* */ 
    
  /* ******************************************************************************************************* */ 
   
  /* ******************************************************************************************************* */ 
    
    /* ******************************************************************************************************* */ 
    
    /* ******************************************************************************************************* */ 
    
    /* ******************************************************************************************************* */ 

}


