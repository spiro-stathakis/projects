<?php
namespace common\components;

//use Yii;
//use yii\base\InvalidParamException;
//use yii\web\BadRequestHttpException;
//use yii\filters\VerbFilter;
//use yii\filters\AccessControl;


use yii; 
use common\components\Types; 
/**
 * Site controller
 */
abstract class XController extends \yii\web\Controller
{
    /**
     * @inheritdoc
     */

  
    /* ******************************************************************************************************* */ 
   
    /* ******************************************************************************************************* */ 
    
    public function init()
    {


        yii::$app->jsconfig->addData('g', yii::$app->user->isGuest); 
        yii::$app->jsconfig->addData('csrfTokenParam',yii::$app->request->csrfParam); 
        yii::$app->jsconfig->addData('csrfToken', yii::$app->request->csrfToken); 

         yii::$app->jsconfig->addData('types_boolean', 
                [
                    'true'=>Types::$boolean['true']['id'],
                    'false'=>Types::$boolean['false']['id']
                ]);
          yii::$app->jsconfig->addData('csrfToken', yii::$app->request->csrfToken); 
        
        yii::$app->language = 'en-gb'; 
        $this->enableCsrfValidation = true;
        return parent::init(); 
    }
    /* ******************************************************************************************************* */ 
    /**
     * @inheritdoc
     */
    public function actions()
    {
       return array_merge(
                parent::actions(), 
                [                
                    'error'=>['class'=>'yii\web\ErrorAction'], 
                ] 
            );

    }

    /* ******************************************************************************************************* */ 
    
}
