<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\calendar\models\CalendarSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="calendar-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'collection_id') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'description') ?>

    <?= $form->field($model, 'location') ?>

    <?php // echo $form->field($model, 'start_hour') ?>

    <?php // echo $form->field($model, 'start_min') ?>

    <?php // echo $form->field($model, 'end_hour') ?>

    <?php // echo $form->field($model, 'end_min') ?>

    <?php // echo $form->field($model, 'palette_id') ?>

    <?php // echo $form->field($model, 'project_option_id') ?>

    <?php // echo $form->field($model, 'allow_overlap_option_id') ?>

    <?php // echo $form->field($model, 'read_only_option_id') ?>

    <?php // echo $form->field($model, 'advance_limit') ?>

    <?php // echo $form->field($model, 'old_id') ?>

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
