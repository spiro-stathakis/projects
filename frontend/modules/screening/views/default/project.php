<?php use yii\helpers\Html;  ?> 
<?php echo $this->render('../default/_stepBar' , ['activeElement'=>2]);?> 
<div class="screening-default-project">
    <p>
       <h4>Please select a project: </h4>
    </p>

    <p>
    
    <?php foreach($projectList as $project): ?> 
     
        <hr> 
        <?=Html::a($project['collection_title'], ['subject/search','project_id' => $project['project_id']], ['class' => 'btn btn-primary']) ?>
        <?=sprintf('<br/>%s<br/>%s ',$project['collection_description'] , $project['project_title']);?> 
        </hr> 

    <?php endforeach; ?> 

    </p>
</div>
