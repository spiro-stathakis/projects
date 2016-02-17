<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;



/* @var $this yii\web\View */
/* @var $model common\models\Subjects */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="subjects-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'dob')->textInput() ?>
    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'telephone')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'sex_id')->dropDownList($model->sexOptions, []) ?>


    <?= $form->field($model, 'gp_opt_id')->dropDownList($model->booleanOptions, []) ?>

    <?= $form->field($model, 'email_opt_id')->dropDownList($model->booleanOptions, []) ?>

    <?= $form->field($model, 'sex_id')->dropDownList($model->sexOptions, []) ?>

    <?= Html::hiddenInput('project_id', $project_id);?>
    <?= Html::hiddenInput('resource_id', $resource_id);?>
    <?= Html::hiddenInput('screening_form_id', $screening_form_id);?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
