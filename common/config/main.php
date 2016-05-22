<?php
return [
 	'bootstrap' => ['log'],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [

         
    
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
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=projects',
            'username' => 'projects',
            'password' => 'projects',
            'charset' => 'utf8',
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
        'SecurityComponent'=> [
            'class'=>'common\components\SecurityComponent', 
        ],
        'CalendarComponent'=> [
            'class'=>'common\components\CalendarComponent', 
        ],  
        'resourcecomponent'=> [
            'class'=>'common\components\ResourceComponent', 
        ],   
        'datecomponent'=> [
            'class'=>'common\components\DateComponent', 
        ],        
        'CollectionComponent'=> [
            'class'=>'common\components\CollectionComponent', 
        ],

        'project'=> [
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
