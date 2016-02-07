<?php use yii\helpers\Html;  ?> 
<div class="screening-default-index">
    <h1><?= Yii::t('app', 'Screeing form module');?></h1>
    <p>
        Your user account is able to create the following projects: 
    </p>
    <p>
    
    <?php foreach($projectList as $project): ?> 
     
        <hr> 
        <?=Html::a($project['collection_name'], ['subject/search', 'screening_form_id'=>$screening_form_id,'project_id' => $project['project_id']], ['class' => 'btn btn-primary']) ?>
        <?=sprintf('<br/>%s<br/>%s ',$project['collection_description'] , $project['project_name']);?> 
        </hr> 

    <?php endforeach; ?> 

    </p>
</div>
