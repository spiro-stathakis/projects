<?php

namespace app\modules\admin\controllers;
use Yii;
use common\components\XController;
use common\components\Types; 
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url; 
use yii\helpers\Json; 

class UserController extends XController
{

	/**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                        'class' => AccessControl::className(),
                        'rules' => [
                                    ['actions' => ['create',
                                                 ], 
                                        'allow' => true, 'roles' => ['admin_role'],], 
                        ],
            ],
        ];
        
    }

 /* ********************************************************************** */ 
 public function init()
 {
    if (! Yii::$app->user->isGuest){
            yii::$app->jsconfig->addData('allCalendars', yii::$app->CalendarComponent->allCalendars);
            yii::$app->jsconfig->addData('ldapSearchUserUri', Url::to('/admin/ajax/ldapsearchuser') );
            yii::$app->jsconfig->addData('createUserUri', Url::to('/admin/ajax/createuser') );
            
    }
    return parent::init(); 
 }
 /* ********************************************************************** */ 
 public function actionCreate()
 {
        return $this->render('create'); 
 }
 /* ********************************************************************** */ 
    public function actionIndex()
    {
        return $this->render('index');
    }

}
