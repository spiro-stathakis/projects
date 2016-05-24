<?php
use kartik\datecontrol\Module;
return [
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'support@example.com',
    'user.passwordResetTokenExpire' => 3600,
    
    // other settings
    'dateControlDisplay' => [
            Module::FORMAT_DATE => 'dd-MM-yyyy',
            Module::FORMAT_TIME => 'HH:mm:ss',
            Module::FORMAT_DATETIME => 'dd-MM-yyyy HH:mm:ss', 
    ],
        
        // format settings for saving each date attribute (PHP format example)
    'dateControlSave' => [
            Module::FORMAT_DATE => 'php:d-m-Y', // saves as unix timestamp
            Module::FORMAT_TIME => 'php:H:i:s',
            Module::FORMAT_DATETIME => 'php:d-m-Y H:i:s',
    ]
   
    
];
