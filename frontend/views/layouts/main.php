<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;

use yii\widgets\Breadcrumbs;
use frontend\packages\AppAsset;
use frontend\packages\AppJsAsset;
use common\widgets\Alert;

AppAsset::register($this);
AppJsAsset::register($this);
$this->registerJs(" $.app.mc = ". Yii::$app->jsconfig->data. ";", \yii\web\View::POS_END, 'my-options');

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?=Yii::$app->controller->renderPartial('//layouts/_navBar'); ?>  

   
   

   <div class="container">
               
                <?= Alert::widget() ?>
                <?= $content ?>
    </div>
</div>
   
<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; CUBRIC <?= date('Y') ?></p>

        <p class="pull-right">Cardiff University</p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
