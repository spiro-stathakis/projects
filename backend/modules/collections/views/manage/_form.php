<?php

use kartik\color\ColorInput;

use yii\bootstrap\Html;
use kartik\form\ActiveForm;
use kartik\builder\Form;
use kartik\widgets\SwitchInput;
use yii\helpers\Url; 

/* @var $this yii\web\View */
/* @var $model frontend\modules\calendar\models\Calendar */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="collection-form">
    <div class="row">
            <div class="col-sm-6-offset col-sm-offset-2 col-md-7 col-md-offset-2 main">
            <div></div>
            <h2><?= Html::encode($this->title) ?></h2>
                    <?php $form = ActiveForm::begin(); ?>
                    <?=Form::widget([
                            'model'=>$model,
                            'form'=>$form,
                            'columns'=>2,
                            'attributes'=>[       // 2 column layout
                                'title'=>['type'=>Form::INPUT_TEXT, 'options'=>['placeholder'=>'Collection title...']],
                                'alias'=>['type'=>Form::INPUT_TEXT, 
                                                'options'=>['placeholder'=>'Collection alias'],
                                                ]
                                        ]
                    ]);?> 

                    <?=Form::widget([
                            'model'=>$model,
                            'form'=>$form,
                            'columns'=>3,
                            'attributes'=>[       // 2 column layout
                                'description'=>['type'=>Form::INPUT_TEXTAREA, 
                                                'options'=>['placeholder'=>'Collection description'],
                                                'columnOptions'=>['colspan'=>3],
                                                ]
                                        ]
                    ]);?>


                   <?=Form::widget([     // nesting attributes together (without labels for children)
                       'model'=>$model,
                       'form'=>$form,
                       'columns'=>3,
                       'attributes'=>[
                            'collection_type_id'=>[
                                        'type'=>Form::INPUT_DROPDOWN_LIST, 
                                        'items'=>$model->collectionTypeOptions,  
                                        'options'=>[], 

                                       
                                        ],
                           'public_option_id'=>[
                                        'type'=>Form::INPUT_DROPDOWN_LIST, 
                                        'items'=>$model->booleanOptions, 
                                        'options'=>[], 

                                       
                                        ],
                             'membership_duration'=>['type'=>Form::INPUT_TEXT, 
                                                  'options'=>['placeholder'=>'Decide a member list']
                                            ],
                                        
                            ]
                    ]);?>


                    
                    

                    
                    <div class="form-group">
                        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                    </div>
                    <?php ActiveForm::end(); ?>
            </div>
     
            
    </div>     
</div>




   
