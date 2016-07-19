<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Collection */

$this->title = Yii::t('app', 'New Collection');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Collections'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="collection-create">

    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
