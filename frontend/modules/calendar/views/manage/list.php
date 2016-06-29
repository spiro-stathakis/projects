<?php use yii\helpers\Url; ?> 
<?php use yii\bootstrap\Html; ?> 
<?php use yii\grid\GridView; ?> 
 <div class="row">
            <div class="col-sm-6-offset col-sm-offset-2 col-md-7 col-md-offset-2 main">
            	<h4> Please select a calendar to update:</h4>
            	<?= GridView::widget([
   				 'dataProvider' => $dataProvider,
    				'columns' => [
        			
        			[	'attribute' => 'calendar_title',],
        			[
            			'header'=>'Options',
            			'class' => 'yii\grid\ActionColumn',
            			'template'=>'{view} {update}', 
            			'buttons' => [
							'view' => function ($url, $model) {
                				return Html::a(sprintf(
                					'<span class="fa fa-search"></span>%s', 'List events'), $url, [
                            		'title' => Yii::t('app', 'View'),
                            		'class'=>'btn btn-primary btn-xs',                                  
                				]);
            				},
            				'update' => function ($url, $model) {
                				return Html::a(sprintf(
                					'<span class="fa fa-search"></span>%s', 'Calendar settings'), $url, [
                            		'title' => Yii::t('app', 'View'),
                            		'class'=>'btn btn-primary btn-xs',                                  
                				]);
            				},
						],
						'urlCreator' => function ($action, $model, $key, $index) {
            					if ($action === 'view') {
                					return Url::to(['manage/events', 'id'=>$model['calendar_id']]);
                				}
                				if ($action === 'update') {
                					return Url::to(['update', 'id'=>$model['calendar_id']]);
                				}
        					}
        			],

        			]
				]); ?>
			</div>
</div>