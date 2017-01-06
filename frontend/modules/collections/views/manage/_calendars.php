<?php use yii\bootstrap\Html; ?> 
<?php use yii\helpers\Url ?> 

<h4>Calendars</h4> 


<?php foreach($collectionModel->calendars as $cal): ?> 
	<?=Html::a($cal->title)?> 
	<br /> 
<?php endforeach; ?> 