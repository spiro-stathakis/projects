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
       
        'mail' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'transport' => [
                 'class' => 'Swift_SmtpTransport',
                 'host' => '127.0.0.1',  // e.g. smtp.mandrillapp.com or smtp.gmail.com
                 'username' => '',
                 'password' => '',
                 'port' => '25', // Port 25 is a very common port too
                 //'encryption' => 'tls', // It is often used, check your provider or mail server specs
             ],
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
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
        'CurlComponent'=> [
            'class'=>'common\components\CurlComponent', 
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
        'ResourceComponent'=> [
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
         
        'LogComponent'=> [
            'class'=>'common\components\LogComponent', 
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
