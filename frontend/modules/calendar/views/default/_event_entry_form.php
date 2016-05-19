<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\calendar\models\EventEntry */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="event-entry-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'event_id')->textInput() ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'booking_status_id')->textInput() ?>

    <?= $form->field($model, 'start_timestamp')->textInput() ?>

    <?= $form->field($model, 'end_timestamp')->textInput() ?>

    <?= $form->field($model, 'all_day_option_id')->textInput() ?>

    <?= $form->field($model, 'confirm_by')->textInput() ?>

    <?= $form->field($model, 'confirm_date')->textInput() ?>

    <?= $form->field($model, 'sort_order')->textInput() ?>

    <?= $form->field($model, 'status_id')->textInput() ?>

    <?= $form->field($model, 'old_id')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'created_by')->textInput() ?>

    <?= $form->field($model, 'updated_by')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
