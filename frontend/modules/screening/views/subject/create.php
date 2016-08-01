<?php

use yii\helpers\Html;

?>
<div class="row">
            <div class="col-sm-7-offset col-sm-offset-1 col-md-8 col-md-offset-1 main">
			<?php echo $this->render('../default/_stepBar' , ['activeElement'=>4]);?> 
			</div>
</div>

<div class="row">
            <div class="col-sm-6-offset col-sm-offset-2 col-md-7 col-md-offset-2 main">
    <h4><?= Html::encode($this->title) ?></h4>

    <?= $this->render('_form', [
        'model' => $model,
     ]) ?>

</div>
</div>