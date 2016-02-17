<?php

use yii\helpers\Html;

?>
<?php echo $this->render('../default/_stepBar' , ['activeElement'=>4]);?> 
<div class="subjects-index">
<div class="subjects-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'screening_form_id'=>$screening_form_id,
        'resource_id'=>$resource_id,
        'project_id'=>$project_id,
    ]) ?>

</div>
