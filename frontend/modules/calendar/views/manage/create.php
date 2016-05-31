<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\modules\calendar\models\Calendar */

$this->title = Yii::t('app', 'New calendar');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Calendars'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="calendar-create">

    

          <ul class="nav nav-sidebar">
         	 <?= $this->render('_form', [
        		'model' => $model,
    		]); ?>
   		</ul> 
</div>
