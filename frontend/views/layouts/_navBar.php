<?php 
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
 NavBar::begin([
        'brandLabel' => 'CUBRIC',

        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    
    $menuItems[]=  ['label' => 'Home', 'url' => ['/']];
    $menuItems[]=  ['label' => 'Collections' ,'url'=> ['/collections']];
   

    $menuItems[]=  ['label' => 'Booking system',  'items'=>[
                        ['label' => 'View calendars', 'url' => ['/calendar']],
                        ['label' => 'Edit a calendar', 'url' => ['/calendar/list'] , 'visible'=>Yii::$app->user->can('editCalendar')],
                        ['label' => 'Create a calendar', 'url' => ['/calendar/create'] , 'visible'=>Yii::$app->user->can('createCalendar')],

    ]];

    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
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