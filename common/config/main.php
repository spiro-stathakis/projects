<?php
return [
 	'bootstrap' => ['log'],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
     'modules'=>[
            'gii'=>[
                'class'=>'yii/gii/Module', 
                'allowedIPs'=>['*']
            ],
            'admin' => [
                'class' => 'app\modules\admin\Module',
             
            ],
            'calendar' => [
                'class' => 'app\modules\calendar\Module',
             
            ],
            'datecontrol' =>  [
                'class' => '\kartik\datecontrol\Module'
            ], 
            'screening' => [
                'class' => 'app\modules\screening\Module',
            ],
            'collections' => [
                'class' => 'app\modules\collections\Module',
            ],
            'gridview' =>  [
                'class' => '\kartik\grid\Module'
            ],
    ],
    
    'components' => [

        'user' => [
            'identityClass' => 'common\models\UserIdentity',
            'enableAutoLogin' => true,
        ],

        

    
    
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                    'categories' => [
                            'yii\db\*',
                            'yii\web\HttpException:*',
                    ],
                ],
            ],
        ],
       
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'ReadHttpHeader'=>[
            'class'=>'common\components\ReadHttpHeader',
        ],

        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],

        // ...
         'PdfComponent'=> [
            'class'=>'common\components\PdfComponent', 
        ], 
        'AjaxResponse'=> [
            'class'=>'common\components\AjaxResponse', 
        ], 
        'SecurityComponent'=> [
            'class'=>'common\components\SecurityComponent', 
        ],
        'CalendarComponent'=> [
            'class'=>'common\components\CalendarComponent', 
        ],  
        'resourcecomponent'=> [
            'class'=>'common\components\ResourceComponent', 
        ],   
        'DateComponent'=> [
            'class'=>'common\components\DateComponent', 
        ],        
        'CollectionComponent'=> [
            'class'=>'common\components\CollectionComponent', 
        ],

        'ProjectComponent'=> [
            'class'=>'common\components\ProjectComponent', 
        ], 
         
        'ScreeningForm'=> [
            'class'=>'common\components\ScreeningFormComponent', 
        ], 
        'jsconfig'=> [
            'class'=>'common\components\JsConfig', 
        ], 
        'screeningquestion' => [
            'class' => 'common\components\ScreeningQuestionComponent', 
        ],
        'screeningresponse' => [
            'class' => 'common\components\ScreeningResponseComponent', 
        ],
         'UserComponent' => [
            'class' => 'common\components\UserComponent', 
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
];
