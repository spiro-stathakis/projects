<?php use yii\helpers\Html;  ?> 
<div class="screening-default-index">
    <h1><?= Yii::t('app', 'Screeing form module');?></h1>
    <p>
        Your user account is able to create the following screening forms: 
    </p>
    <p>
    
    <?php foreach($screeningList as $key=>$list): ?> 
    	<?=sprintf('<h4>%s</h4>',$key);?> 
    	<?php foreach($list as $item): ?> 
    		<?= Html::a($item['screening_form_name'], ['default/project', 'screening_form_id' => $item['screening_form_id']], ['class' => 'btn btn-primary']) ?>
    	<?php endforeach; ?> 

    <?php endforeach; ?> 

    </p>
</div>
