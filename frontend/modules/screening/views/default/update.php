<?php
//use yii\helpers\Html;
use kartik\detail\DetailView; 
use yii\bootstrap\Html;
use yii\helpers\Url; 

?> 
<div class="row">
            <div class="col-sm-7-offset col-sm-offset-1 col-md-8 col-md-offset-1 main">
				<?php echo $this->render('../default/_stepBar' , ['activeElement'=>4]);?> 
			</div>
</div 

<p>&nbsp;</p>

<div class="row">
            <div class="col-sm-6-offset col-sm-offset-2 col-md-7 col-md-offset-2 main">
<?= DetailView::widget([
        'model' => $subject_model,
        'attributes' => [
        	[
        		'group'=>true,
        		'label'=>'Participant information', 
        		'rowOptions'=>['class'=>'info']
        	], 
        	[
        		'columns'=> [
        			[
        				'attribute'=>'cubric_id', 
        				'valueColOptions'=>['style'=>'width:20%']
        			], 
        			[
        				'attribute'=>'first_name', 
        				'label'=>'name', 
        				'value'=>sprintf('%s %s', $subject_model->first_name, $subject_model->last_name), 
        				'valueColOptions'=>['style'=>'width:60%']
			        ], 
			        [
			        	'attribute'=>'dob', 
			        	'label'=>'DOB', 
			        	'valueColOptions'=>['style'=>'width:20%']
			        ], 
			        
			    ],
			],
		]
	]);
?> 


<?php echo Html::beginForm(Url::to(['default/update']),'post'); ?> 

<?php foreach ($screening_questions as $ques): ?> 
		<fieldset> 
		<?php if (strlen($ques['caption'])> 0):?> 
			
			<legend><?php echo $ques['caption']; ?></legend> 

		<?php endif; ?>  
		<ul style='list-style-type:none'> 
		 <?php echo sprintf('<li>%s. %s</li>', $count , $ques['content']); ?>
		 <?php echo  \yii::$app->screeningresponse->renderHtmlInput($ques['input_type_id'],$ques); ?> 

		</ul>

		 <?php $count++; ?> 
		 </fieldset>
<?php endforeach; ?>



<?php echo Html::submitButton(); ?> 
<?php echo Html::endForm(); ?> 

</div>
</div>