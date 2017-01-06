<?php use yii\bootstrap\Html; ?> 
<?php use yii\helpers\Url; ?> 

<h4>Electronic forms</h4> 




<?php foreach($collectionModel->screeningForms as $forms): ?> 
	<?=Html::a($forms->title)?> 
	<br /> 
<?php endforeach; ?> 