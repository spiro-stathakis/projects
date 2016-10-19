<?php

use yii\bootstrap\Html;

use kartik\form\ActiveForm;
use kartik\builder\Form;
use kartik\switchinput\SwitchInput;
use yii\helpers\Url; 



/* @var $this yii\web\View */
/* @var $model common\models\Subjects */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="subjects-form">

            <?php 
            $form = ActiveForm::begin([
                            'type'=>ActiveForm::TYPE_VERTICAL, 
                            'formConfig'=>['labelSpan'=>3],
                           // 'enableAjaxValidation' => true,
                            'id'=>'frmBookingForm', 
                          
                             
                
            ]);

            
            echo Form::widget([
                'model'=>$model,
                'form'=>$form,
                'columns'=>2,
                'attributes'=>[       // 2 column layout
                    'first_name'=>['type'=>Form::INPUT_TEXT, 'options'=>['placeholder'=>'First name']],
                    'dob'=>[
                                'type'=>Form::INPUT_WIDGET, 
                                'widgetClass'=>'\kartik\datecontrol\DateControl',
                                
                            ],
                    
                    ]
            ]);

            echo Form::widget([
                'model'=>$model,
                'form'=>$form,
                'columns'=>2,
                'attributes'=>[       // 2 column layout
                    'last_name'=>['type'=>Form::INPUT_TEXT, 'options'=>['placeholder'=>'Last name']],
                    'telephone'=>['type'=>Form::INPUT_TEXT, 'options'=>['placeholder'=>'Telephone']],
                    
                    ]
            ]);

             echo Form::widget([
                'model'=>$model,
                'form'=>$form,
                'columns'=>3,
                'attributes'=>[       // 2 column layout
                    'email'=>['type'=>Form::INPUT_TEXT, 'options'=>['placeholder'=>'Email']],
                    
                    'address'=>['type'=>Form::INPUT_TEXTAREA, 
                                    'options'=>['placeholder'=>'Address...'],
                                    'columnOptions'=>['colspan'=>2],
                                ]
                   
                    ]
            ]);
            
            echo Form::widget([
                'model'=>$model,
                'form'=>$form,
                'columns'=>3,
                'attributes'=>[    
                    
                    'gp_opt_id'=>[  'type'=>Form::INPUT_DROPDOWN_LIST, 
                                    'items'=>['0'=>''] +$model->booleanOptions, 
                                        'options'=>['id'=>'gp_opt_id','placeholder'=>'GP details','style'=>'width:100px'], 
                                        
                                ], 
                    'email_opt_id'=>['type'=>Form::INPUT_DROPDOWN_LIST, 
                                        'items'=>['0'=>''] + $model->booleanOptions,
                                        'options'=>['id'=>'email_opt_id','placeholder'=>'Email opt','style'=>'width:100px'],    
                                ],
                            
                    'sex_id'=>['type'=>Form::INPUT_DROPDOWN_LIST, 
                                        'items'=>['0'=>''] +$model->booleanOptions,
                                        'options'=>['id'=>'sex_id','placeholder'=>'Sex opt','style'=>'width:100px'],    
                            
                            ],

                    ]
            ]);


   
   ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
<?php \kartik\form\ActiveForm::end(); ?>

</div>
