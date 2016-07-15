<?php use yii\web\JsExpression;?> 
<?php use yii\bootstrap\Html; ?> 
<?php use frontend\packages\Select2Asset; ?> 
<?php use yii\helpers\Url;?> 


<?php 
// Configure the select2.js code with appropriate settings 

Select2Asset::register($this); 
?> 

	
	<div class="row">
 			
            <div class="col-sm-6 col-sm-offset-3  col-md-6 col-md-offset-3 ">
            	<h2><?=$collectionModel->title;?></h2> 
               <a href="<?=Url::to(['/calendar/manage/create', 'col'=>$collectionModel->id]);?>" class="btn btn-success btn-lg">
    					<span class="glyphicon glyphicon-calendar"></span> New calendar
  				</a>
  				<a href="/calendar/manage/create" class="btn btn-success btn-lg">
    					<span class="glyphicon glyphicon-calendar"></span> New screening form
  				</a>
			</div>
			

	</div>	

 	<div class="row">
 			<div class="col-sm-3 col-md-3" style="border-right:1px solid #c0c0c0;">
					<?=$this->render('_projects',['collectionModel'=>$collectionModel]); ?>
					
			</div>
            
			 <div class="col-sm-6  col-md-6 ">
                 
						<?=$this->render('_managers',['collectionModel'=>$collectionModel]); ?> 
						<?=$this->render('_members',['collectionModel'=>$collectionModel]); ?> 
			</div>
            
                 
						
			
			<div class="col-sm-3 col-md-3" style="border-left:1px solid #c0c0c0;">
					<?=$this->render('_calendars',['collectionModel'=>$collectionModel]); ?>
					<?=$this->render('_electronicforms',['collectionModel'=>$collectionModel]); ?> 
			</div>

	</div>



