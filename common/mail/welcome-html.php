<?php use yii\helpers\Url; ?> 
<?php use yii\helpers\Html; ?> 


Dear <?=$user_name?>, 

<br /> 

You have been registered with the CUBRIC projects database.  You can access the system here: 
<p>
<?=Html::a(Url::to('/','https'),Url::to('/','https'));?> 
</p>


 