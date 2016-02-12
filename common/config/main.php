<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
    	'calendarcomponent'=> [
            'class'=>'common\components\CalendarComponent', 
        ],   
        'datecomponent'=> [
            'class'=>'common\components\DateComponent', 
        ],        
        'collection'=> [
            'class'=>'common\components\CollectionComponent', 
        ],

        'project'=> [
            'class'=>'common\components\ProjectComponent', 
        ], 
         
        'screeningform'=> [
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
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
         'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
    ],
];
