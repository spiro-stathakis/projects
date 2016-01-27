<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'modules'=>[
        'gii'=>[
            'class'=>'yii/gii/Module', 
            'allowedIPs'=>['*']
        ],
        'calendar' => [
            'class' => 'app\modules\calendar\Module',
        ],
        'screening' => [
            'class' => 'app\modules\screening\Module',
        ],

    ], 
    'components' => [
        'collection'=> [
            'class'=>'common\components\Collection', 
        ], 
        'screeningform'=> [
            'class'=>'common\components\ScreeningForm', 
        ], 
        'jsconfig'=> [
            'class'=>'common\components\JsConfig', 
        ], 
        'screeningquestion' => [
            'class' => 'common\components\ScreeningQuestion', 
        ],
        'screeningresponse' => [
            'class' => 'common\components\ScreeningResponse', 
        ],
        'user' => [
            'identityClass' => 'common\models\UserIdentity',
            'enableAutoLogin' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        
    ],
    'params' => $params,
];
