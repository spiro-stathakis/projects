<?php

use yii\helpers\Html;

?>
<?php echo $this->render('../default/_stepBar' , ['activeElement'=>4]);?> 
<div class="subjects-index">
<div class="subjects-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
     ]) ?>

</div>
