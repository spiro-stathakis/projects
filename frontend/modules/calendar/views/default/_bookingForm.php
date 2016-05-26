 <?php

use yii\bootstrap\Html;
use kartik\form\ActiveForm;
use kartik\builder\Form;
use kartik\widgets\SwitchInput;
use yii\helpers\Url; 

use frontend\packages\BootstrapTreeviewAsset;

?>
<?php BootstrapTreeviewAsset::register($this);?> 

			<?php 
			$form = ActiveForm::begin([
							'type'=>ActiveForm::TYPE_HORIZONTAL, 
							'formConfig'=>['labelSpan'=>3],
							'enableAjaxValidation' => true,
							'id'=>'frmBookingForm', 
							 
			    
			]);
			echo Form::widget([
			    'model'=>$model,
			    'form'=>$form,
			    'columns'=>3,
			    'attributes'=>[       // 2 column layout
			        'title'=>['type'=>Form::INPUT_TEXT, 'options'=>['placeholder'=>'Event title...']],
			        'description'=>['type'=>Form::INPUT_TEXTAREA, 
			        				'options'=>['placeholder'=>'Enter username...'],
			        				'columnOptions'=>['colspan'=>2],
									]
							]
			]);

			echo Form::widget([
			    'model'=>$model,
			    'form'=>$form,
			    'columns'=>2,
			    'attributes'=>[    
			        
			    	'calendar_id'=>[	'type'=>Form::INPUT_DROPDOWN_LIST, 
            							'items'=>array_merge(['0'=>''],yii::$app->CalendarComponent->myCalendarList), 
            							'options'=>['id'=>'calendar_id','placeholder'=>'Select a calendar'], 
            							
            					], 
			     	'project_id'=>['type'=>Form::INPUT_DROPDOWN_LIST, 
			     						'items'=>array_merge(['0'=>''],yii::$app->ProjectComponent->myProjectList),
			     						'options'=>['id'=>'project_id','placeholder'=>'Select a project'],    
			    				]
			    			]
			]);



			echo Form::widget([     // nesting attributes together (without labels for children)
			    'model'=>$model,
			    'form'=>$form,
			    'columns'=>2,
			    'attributes'=>[
			        'start_date' => [
			                    'type'=>Form::INPUT_WIDGET, 
			                    'widgetClass'=>'\kartik\datecontrol\DateControl',
			                    'options'=>['options'=>['id'=>'start_date']],  
			        ],
			        'all_day_option_id'=>['type'=>Form::INPUT_DROPDOWN_LIST,
			        					  'items'=>$model->allDayOptions, 
			        ]
				 ]
			]);

			echo Form::widget([     // nesting attributes together (without labels for children)
			   'model'=>$model,
			   'form'=>$form,
			   'columns'=>2,
			   'attributes'=>[
			        'start_time'=>[
			                    'type'=>Form::INPUT_WIDGET, 
			                    'widgetClass'=>'\kartik\time\TimePicker', 
			                    'options'=>[
			                    			'pluginOptions'=>['showMeridian'=>false], 
			                    			'options'=>['id'=>'start_time'],
			                    			], 

			                   
			                    ],
			       'end_time'=>[
			                    'type'=>Form::INPUT_WIDGET, 
			                    'widgetClass'=>'\kartik\time\TimePicker', 
			                    'options'=>[
			                    			'pluginOptions'=>['showMeridian'=>false], 
			                    			'options'=>['id'=>'end_time'],
			                    			], 

			                   
			                    ],
			        ],

			       

				
			]);





?>
<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
<?php \kartik\form\ActiveForm::end(); ?>
	
