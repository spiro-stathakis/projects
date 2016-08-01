<?php use yii\helpers\Html;  ?> 


<div class="row">
            <div class="col-sm-7-offset col-sm-offset-1 col-md-8 col-md-offset-1 main">
                <?php echo $this->render('../default/_stepBar' , ['activeElement'=>2]);?> 
            <div>
<div>


<div class="row">
            <div class="col-sm-6-offset col-sm-offset-2 col-md-7 col-md-offset-2 main">
                <h4>Please select a project: </h4>
    
                <?php foreach($projectList as $project): ?> 
                 
                    <hr> 
                    <?=Html::a($project['collection_title'], ['subject/search','project_id' => $project['project_id']], ['class' => 'btn btn-primary']) ?>
                    <?=sprintf('<br/>%s<br/>%s ',$project['collection_description'] , $project['project_title']);?> 
                    </hr> 
                <?php endforeach; ?> 
    </div>
</div>