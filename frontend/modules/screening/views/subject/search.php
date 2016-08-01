<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\SubjectsSearch */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
            <div class="col-sm-7-offset col-sm-offset-1 col-md-8 col-md-offset-1 main">
                <?php echo $this->render('../default/_stepBar' , ['activeElement'=>3]);?> 
            <div>
<div>



<div class="row">
            <div class="col-sm-6-offset col-sm-offset-2 col-md-7 col-md-offset-2 main">
    <p>
       Please ensure details are entered in exactly as they should be. The search will not return partial or near matches.  
    </p>
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'post',
    ]); ?>

 
    <?//= $form->field($model, 'id') ?>

    <?//= $form->field($model, 'cubric_id') ?>

    <?= $form->field($model, 'first_name') ?>

    <?= $form->field($model, 'last_name') ?>

    <?= Html::tag('label', 'Date of Birth') ?>
    <?= Html::activeDropDownList( $model, 'dob_yyyy' ,  $model->years , []); ?> 
     <?= Html::tag('label', '/') ?>
    <?= Html::activeDropDownList($model,  'dob_mm',  $model->months , []); ?> 
     <?= Html::tag('label', '/') ?>
    <?= Html::activeDropDownList( $model, 'dob_dd',  $model->days , []); ?> 
     <?= Html::tag('label', '(YYYY/MM/DD)') ?>
    <p>&nbsp;</p>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>


    <?php ActiveForm::end(); ?>

</div>
</div>