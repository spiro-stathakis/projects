<?php

/* @var $this yii\web\View */


//use yii\grid\GridView;
 
use frontend\packages\AdminDashboardAsset;
use yii\helpers\Html;


$this->title = 'The Admin dashboard';
$this->params['breadcrumbs'][] = $this->title;
?>

    <h4><?= Html::encode($this->title) ?></h4>


<?php AdminDashboardAsset::register($this);?> 


<div class="row">
<div class="col-sm-4 col-md-6 main">

<?=Yii::$app->controller->renderPartial('_project-grid-view', 
                ['projectDataProvider'=>$projectDataProvider, 'projectSearch'=>$projectSearch]);
                ?>  
</div>

<div class="col-sm-3 col-md-5 main">
<?=Yii::$app->controller->renderPartial('_invoice-grid-view', 
                ['invoiceDataProvider'=>$invoiceDataProvider, 'invoiceSearch'=>$invoiceSearch]);?> 

</div>


</div>

