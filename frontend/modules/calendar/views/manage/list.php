<?php use yii\helpers\Url; ?> 
<?php use yii\bootstrap\Html; ?> 


 <div class="row">
            <div class="col-sm-6-offset col-sm-offset-2 col-md-7 col-md-offset-2 main">
            	<h4> Please select a calendar to update:</h4>
            	<p>&nbsp;</p>
				<ul> 
				<?php foreach ($managementList as $key=>$value):?>
				<li><?=Html::a($value, Url::to(['update', 'id'=>$key]));?></li>
				<?php endforeach; ?>  
				</ul>
			</div>
</div>