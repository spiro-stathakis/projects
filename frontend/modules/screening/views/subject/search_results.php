<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\SubjectsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="subjects-search">

    <?php $form = ActiveForm::begin([
        'action' => ['search'],
        'method' => 'post',
    ]); ?>

    <?//= $form->field($model, 'id') ?>

    <?//= $form->field($model, 'cubric_id') ?>

    <?= $form->field($model, 'first_name') ?>

    <?= $form->field($model, 'last_name') ?>

    <?= $form->field($model, 'dob') ?>

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
