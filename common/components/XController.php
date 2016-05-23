<?php
namespace common\components;

//use Yii;
//use yii\base\InvalidParamException;
//use yii\web\BadRequestHttpException;
//use yii\filters\VerbFilter;
//use yii\filters\AccessControl;



/**
 * Site controller
 */
abstract class XController extends \yii\web\Controller
{
    /**
     * @inheritdoc
     */
    protected $collectionComponent;
  
    /* ******************************************************************************************************* */ 
   
    /* ******************************************************************************************************* */ 
    
    public function init()
    {


        \yii::$app->jsconfig->addData('g', \yii::$app->user->isGuest); 
        \yii::$app->language = 'en-gb'; 
        $this->collectionComponent = \yii::$app->CollectionComponent;
        $this->enableCsrfValidation = false;
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
