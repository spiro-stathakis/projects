<?php use yii\web\JsExpression;?> 
<?php use yii\bootstrap\Html; ?> 
<?php use frontend\packages\Select2Asset; ?> 


<?php 
// Configure the select2.js code with appropriate settings 

Select2Asset::register($this); 
?> 



<?=\yii\helpers\Html::beginForm('submit'); ?> 

<?=sprintf('<h4>Add remove members to: %s</h4>' , $collectionModel->title); ?> 
Please type the names of the users you would like to add into this group into the box below. 

<p>&nbsp;</p>
<?=Html::dropDownList('members',
         array_keys(\yii::$app->CollectionComponent->memberList($collectionModel->id)), 
             \yii::$app->CollectionComponent->memberList($collectionModel->id) , 
            ['multiple'=>'multiple','id'=>'member-select','style'=>'width:80%']
);?> 

<?=\yii\helpers\Html::endForm(); ?> 


