<?php 
namespace frontend\controllers;
//use Yii; 

use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use common\components\XController;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii; 
use yii\data\ActiveDataProvider;
use  yii\data\SqlDataProvider; 
use yii\data\ArrayDataProvider;

class DashboardController extends XController
{
	public function init()
    {
    	\Yii::$container->set('yii\grid\ActionColumn', [
        'contentOptions' => ['style' => ['white-space' => 'nowrap']],
		]);
        return parent::init();
    }
    /* ************************************************************************************ */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index','projects'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
             
        ];
    }

    /* ************************************************************************************ */
	public function actionIndex()
	{


        $projectSearch = new \common\models\ProjectSearch();  
        $projectDataProvider = $projectSearch->search(Yii::$app->request->queryParams);

        $invoiceSearch = new \common\models\InvoiceSearch(); 
        $invoiceDataProvider = $invoiceSearch->search(Yii::$app->request->queryParams);
		
        return $this->render('index',
						[
						'projectSearch'=>$projectSearch,
                        'projectDataProvider'=>$projectDataProvider, 
                        'invoiceSearch'=>$invoiceSearch, 
                        'invoiceDataProvider'=>$invoiceDataProvider, 
						]); 
	
	}
	/* ************************************************************************************ */
	/*
	public function actions()
    {
        return parent::actions(); 
    }
    */ 
    /* ************************************************************************************ */
    /* Private functions - move to a component file if it gets out of hand ! 
    /* ************************************************************************************ */
    

    /* ************************************************************************************ */
    
    
    /* ************************************************************************************ */

}
