
<h4>Managers</h4> 
<?php use yii\bootstrap\Html; ?> 
			<?=Html::beginForm('managers'); ?> 
			
			These are the managers for the group
			<p>&nbsp;</p>
		<?=Html::dropDownList('managers',
						array_keys(\yii::$app->CollectionComponent->managerList($collectionModel->id)), 
 					\yii::$app->CollectionComponent->managerList($collectionModel->id) , 
					['multiple'=>'multiple','id'=>'manager-select','style'=>'width:80%']
		);?> 
<?=\yii\helpers\Html::endForm(); ?> 