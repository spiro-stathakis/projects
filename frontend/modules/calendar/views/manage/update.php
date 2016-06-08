<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\calendar\models\Calendar */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Calendar',
]) . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Calendars'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="calendar-update">

    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
