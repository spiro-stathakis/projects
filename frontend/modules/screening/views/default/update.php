<?php
//use yii\helpers\Html;
use kartik\detail\DetailView; 
use yii\bootstrap\Html;
use yii\helpers\Url; 

?> 
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


<?php echo Html::beginForm(Url::to(['default/subsign', 'hash'=>$hash]),'post'); ?> 

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