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
   
    if (Yii::$app->user->can('admin_role'))
        $menuItems[]=       ['label' => 'Admins.',  'items'=>[
                                            ['label' => 'Manage users', 'url' => ['/admin/user/create']
                                        ],
                            ]];
    $menuItems[]=       ['label' => 'Bookings',  'items'=>[
                        ['label' => 'View bookings', 'url' => ['/calendar']],
                        ['label' => 'Manage calendars', 'url' => ['/calendar/manage/list'] , 'visible'=>Yii::$app->user->can('editCalendar')],
                        ['label' => 'New calendar', 'url' => ['/calendar/manage/create'] , 'visible'=>Yii::$app->user->can('createCalendar')],


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