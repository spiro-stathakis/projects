 <?php

use yii\bootstrap\Html;
use kartik\form\ActiveForm;
use kartik\builder\Form;

use frontend\packages\DatePickerAsset;

?>
<?php  DatePickerAsset::register($this); ?> 

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
            							'items'=>yii::$app->CalendarComponent->myCalendarList, 
            							
            					], 
			     	'project_id'=>['type'=>Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter password...']],    
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
			        'all_day_option_id'=>['type'=>Form::INPUT_CHECKBOX]
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
	
