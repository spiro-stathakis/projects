<?php use yii\helpers\Html;  ?> 
<?php echo $this->render('../default/_stepBar' , ['activeElement'=>0]);?> 

   <div class="screening-default-form">
    <p>
       Please select a screening form: 
    </p>
    <p>
    
    <?php foreach($screeningList as $key=>$list): ?> 
    	<?=sprintf('<h4>%s</h4>',$key);?> 
    	<?php foreach($list as $item): ?> 
    		<?= Html::a($item['screening_form_name'], ['default/resource', 'screening_form_id' => $item['screening_form_id']], ['class' => 'btn btn-primary']) ?>
    	<?php endforeach; ?> 

    <?php endforeach; ?> 

    </p>

</div>