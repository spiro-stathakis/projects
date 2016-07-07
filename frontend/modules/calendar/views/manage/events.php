<?php use yii\helpers\Url; ?> 
<?php use yii\bootstrap\Html; ?> 
<?php use yii\grid\GridView; ?> 

 <div class="row">
            <div class="col-sm-6-offset col-sm-offset-2 col-md-7 col-md-offset-2 main">
            	<h4> Please select a calendar to update:</h4>
            	<?= GridView::widget([
   				 'dataProvider' => $dataProvider,

    				'columns' => [
        			
        			     ['attribute' => 'event_title',],
                         [
                            'attribute' => 'start_date',
                            'header'=>'Event start',
                            'value' => function ($data) {
                                    return yii::$app->DateComponent->timestampToUkDateTime($data['start_timestamp']); // $data['name'] for array data, e.g. using SqlDataProvider.
                            },
                           
                         ],
        			     [
                            'attribute' => 'end_date',
                            'header'=>'End start',
                            'value' => function ($data) {
                                    return yii::$app->DateComponent->timestampToUkDateTime($data['end_timestamp']); // $data['name'] for array data, e.g. using SqlDataProvider.
                            },
                           
                         ],
                         [
                        'header'=>'Options',
                        'class' => 'yii\grid\ActionColumn',
                        'template'=>'{update} {delete}', 
                        'buttons' => [
                            'update' => function ($url, $model) {
                                return Html::a(sprintf(
                                    '<span class="fa fa-search"></span>%s', 'Update event'), $url, [
                                    'title' => Yii::t('app', 'Update'),
                                    'class'=>'btn btn-primary btn-xs',                                  
                                ]);
                            },
                            'delete' => function ($url, $model) {
                                return Html::a(sprintf(
                                    '<span class="fa fa-search"></span>%s', 'Delete event'), $url, [
                                    'title' => Yii::t('app', 'Delete'),
                                    'class'=>'btn btn-primary btn-xs', 
                                    'data-confirm' => 'Are you sure you want to delete this item?', 
                                    'data-method' =>'POST'                                 
                                ]);
                            },
                        ],
                        'urlCreator' => function ($action, $model, $key, $index) {
                                if ($action === 'update') {
                                    if (yii::$app->CalendarComponent->canUpdateEvent($model))
                                        return Url::to(['event-entry/update', 'ee_id'=>$model['event_entry_id']]);
                                }
                                if ($action === 'delete') {
                                    if (yii::$app->CalendarComponent->canUpdateEvent($model))
                                        return Url::to(['event-entry/delete', 'ee_id'=>$model['event_entry_id']]);
                                }
                                return ''; 
                            }
                        ],

        			]
				]); ?>
			</div>
</div>