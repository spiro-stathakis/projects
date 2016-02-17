<?php use yii\helpers\Html;  ?> 
<?php echo $this->render('../default/_stepBar' , ['activeElement'=>1]);?> 
<div class="screening-default-resource">
    <p>
       Please select a scanner: 
    </p>
    
    <?php foreach($resourceList as $key=>$list): ?> 
    	<?=sprintf('<h4>%s</h4>',$key);?> 
    	<?php foreach($list as $item): ?> 
    		<?= Html::a($item['resource_title'], 
                                ['default/project', 'resource_id'=>$item['resource_id'],  
                                                    'screening_form_id'=>$screening_form_id], 
                                                    ['class' => 'btn btn-primary']); ?>
    	<?php endforeach; ?> 

    <?php endforeach; ?> 

    </p>
</div>
