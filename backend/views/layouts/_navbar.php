<?php 
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
 NavBar::begin([
        'brandLabel' => 'CUBRIC - Back office',

        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-custom navbar-fixed-top',
        ],
    ]);
    
    $menuItems[]=  ['label' => 'Home', 'url' => ['/']];
    $menuItems[]=  ['label' => 'Collections' ,'url'=> ['/collections']];
   
   
    if (Yii::$app->user->isGuest) {
        
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
        $menuItems[] = [
            'label' => 'Logout (' . Yii::$app->user->identity->user_name . ')',
            'url' => ['/site/logout'],
            'linkOptions' => ['data-method' => 'post']
        ];
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();