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

        //'request'=>['enableCsrfValidation'=>false],        
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
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                  
            ],
        ],
        
    ],
    'params' => $params,
];
