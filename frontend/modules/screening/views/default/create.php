<?php
use yii\helpers\Html;
use kartik\detail\DetailView; 
use yii\bootstrap\Carousel; 

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


<?php foreach ($screening_questions as $ques): ?> 

		<?php if (strlen($ques['caption'])> 0):?> 
			<br /> 
			<h4><?php echo $ques['caption']; ?></h4> 

		<?php endif; ?>  
		<ul> 
		<li> <?php echo $ques['content']; ?></li>
		</ul> 

		 
<?php endforeach; ?> 