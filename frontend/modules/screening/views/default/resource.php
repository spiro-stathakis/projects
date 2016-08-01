<?php use yii\helpers\Html;  ?> 

<div class="row">
            <div class="col-sm-7-offset col-sm-offset-1 col-md-8 col-md-offset-1 main">
                <?php echo $this->render('../default/_stepBar' , ['activeElement'=>1]);?> 
            </div>
</div>

<div class="row">
            <div class="col-sm-6-offset col-sm-offset-2 col-md-7 col-md-offset-2 main">
    <h4>
       Please select a scanner: 
    </h4>
    
    <?php foreach($resourceList as $key=>$list): ?> 
    	<?=sprintf('<h4>%s</h4>',$key);?> 
    	<?php foreach($list as $item): ?> 
    		<?= Html::a($item['resource_title'],['default/project', 'resource_id'=>$item['resource_id']],  
                                                                        ['class' => 'btn btn-primary']); ?>
    	<?php endforeach; ?> 

    <?php endforeach; ?> 

    </p>
</div>
</div>

