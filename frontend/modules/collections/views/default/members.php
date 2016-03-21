<?php use yii\web\JsExpression;?> 
<?php use yii\bootstrap\Html; ?> 
<?php use frontend\packages\Select2Asset; ?> 
<?php use yii\helpers\Url; ?> 
<?php use common\components\Types; ?> 

<?php 
// Configure the select2.js code with appropriate settings 
\yii::$app->jsconfig->addData('searchUri', Url::to(['default/ajaxsearchusers'])); 
\yii::$app->jsconfig->addData('targetId', '#member-select'); 
\yii::$app->jsconfig->addData('collectionId', $collectionModel->id); 
\yii::$app->jsconfig->addData('addUri', Url::to(['default/ajaxadduser'])); 
\yii::$app->jsconfig->addData('removeUri', Url::to(['default/ajaxremoveuser'])); 
\yii::$app->jsconfig->addData('memberType', Types::$member_type['member']['id']); 
Select2Asset::register($this); 
?> 



<?=\yii\helpers\Html::beginForm('submit'); ?> 

<?=sprintf('<h4>Add remove members to: %s</h4>' , $collectionModel->title); ?> 
Please type the names of the users you would like to add into this group into the box below. 

<p>&nbsp;</p>
<?=Html::dropDownList('members',
         array_keys(\yii::$app->CollectionComponent->ajaxCollectionMembers($collectionModel->id)), 
             \yii::$app->CollectionComponent->ajaxCollectionMembers($collectionModel->id) , 
            ['multiple'=>'multiple','id'=>'member-select','style'=>'width:80%']
);?> 

<?=\yii\helpers\Html::endForm(); ?> 


