<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\color\ColorInput;

/* @var $this yii\web\View */
/* @var $model frontend\modules\calendar\models\Calendar */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="calendar-form">

    <?php $form = ActiveForm::begin(); ?>

   
    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'location')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'collection_id')->dropDownList($model->collectionOptions , []) ?> 

    <?= $form->field($model, 'start_hour')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'start_min')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'end_hour')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'end_min')->textInput(['maxlength' => true]) ?>

    
    <?= $form->field($model, 'hex_code')->widget(ColorInput::classname(), ['options' => ['placeholder' => 'Select color ...'],]);?>

    <?= $form->field($model, 'allow_overlap_option_id')->dropDownList($model->booleanOptions, []) ?>
    <?= $form->field($model, 'read_only_option_id')->dropDownList($model->booleanOptions, []) ?>
   

    <?= $form->field($model, 'advance_limit')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
