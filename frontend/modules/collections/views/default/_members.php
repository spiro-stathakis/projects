
<h4>Membership managment</h4> 
<?php use yii\bootstrap\Html; ?> 
			<?=\yii\helpers\Html::beginForm('submit'); ?> 
			
			Please type the names of the users you would like to add into this group into the box below. 

			<p>&nbsp;</p>
		<?=Html::dropDownList('members',
						array_keys(\yii::$app->CollectionComponent->memberList($collectionModel->id)), 
 					\yii::$app->CollectionComponent->memberList($collectionModel->id) , 
					['multiple'=>'multiple','id'=>'member-select','style'=>'width:80%']
		);?> 
<?=\yii\helpers\Html::endForm(); ?> 