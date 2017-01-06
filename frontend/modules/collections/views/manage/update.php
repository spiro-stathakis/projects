
<?php use yii\helpers\Html;?>
<?php use yii\helpers\Url;?> 
<?php use rmrevin\yii\fontawesome\FA;?> 
<?php rmrevin\yii\fontawesome\AssetBundle::register($this); ?> 



<div class="collections-manage-update">
    	<div class="row">
        	<div class="row">
 				<div class="col-sm-6 col-sm-offset-2 col-md-6 col-md-offset-2">
            		<h2><?=$collectionModel->title;?></h2> 
            	
               		<a href="<?=Url::to(['/calendar/manage/create', 'col'=>$collectionModel->id]);?>" class="btn btn-success btn-lg">
    					<span class="glyphicon glyphicon-calendar"></span> New calendar
  					</a>
  					<a href="/calendar/manage/create" class="btn btn-success btn-lg">
    					<span class="glyphicon glyphicon-calendar"></span> New screening form
  					</a>
				</div>
			</div>	

 			<div class="col-sm-6 col-sm-offset-2 col-md-6 col-md-offset-2 main">
                 		<?= $this->render('_form', ['model' => $collectionModel,]);?>
			</div>
            
                 
						
			
			<div class="col-sm-3 col-md-3" style="border-left:1px solid #c0c0c0;">
					<?=FA::icon('users')?> 
                		<?=Html::a('members' , ['manage/members','id'=>$collectionModel->id]); ?> 
                
					<?=$this->render('_calendars',['collectionModel'=>$collectionModel]); ?>
					<?=$this->render('_electronicforms',['collectionModel'=>$collectionModel]); ?> 
					<?=$this->render('_projects',['collectionModel'=>$collectionModel]); ?>
			</div>

	</div>
</div>




<div class="collection-update">

    <h1><?= Html::encode($this->title) ?></h1>

    

</div>
