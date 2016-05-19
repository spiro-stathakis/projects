<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\modules\calendar\models\Calendar */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Calendars'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="calendar-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'collection_id',
            'title',
            'description',
            'location',
            'start_hour',
            'start_min',
            'end_hour',
            'end_min',
            'hex_code',
            'project_option_id',
            'allow_overlap_option_id',
            'read_only_option_id',
            'advance_limit',
            'old_id',
            'sort_order',
            'status_id',
            'created_at',
            'updated_at',
            'created_by',
            'updated_by',
        ],
    ]) ?>

</div>
