<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\SubjectsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<?php echo $this->render('../default/_stepBar' , ['activeElement'=>3]);?> 
<div class="subject-search">
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
    <?= Html::activeDropDownList( $model, 'dob_yyyy' ,  $model->years , []); ?> 
    <?= Html::activeDropDownList($model,  'dob_mm',  $model->months , []); ?> 
    <?= Html::activeDropDownList( $model, 'dob_dd',  $model->days , []); ?> 
    

    <?php // echo $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'telephone') ?>

    <?php // echo $form->field($model, 'address') ?>

    <?php // echo $form->field($model, 'gp_opt_id') ?>

    <?php // echo $form->field($model, 'email_opt_id') ?>

    <?php // echo $form->field($model, 'sex_id') ?>

    <?php // echo $form->field($model, 'sort_order') ?>

    <?php // echo $form->field($model, 'status_id') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>


    <?php ActiveForm::end(); ?>

</div>
