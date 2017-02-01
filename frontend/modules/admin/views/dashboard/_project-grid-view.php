<?php use yii\widgets\Pjax; ?> 
<?php use kartik\grid\GridView; ?>  
<?php use  yii\helpers\Html;?> 

<?php Pjax::begin(['id'=>'project-pjax' ,
                  'timeout' => false, 
                  'enablePushState' => false, 
                  'clientOptions' => ['method' => 'POST']
                  ]);?>


<?=GridView::widget([
    'class' => 'kartik\grid\SerialColumn',
	'id'=>'project-grid-view',
	'layout'=>"{pager}{summary}{items}",
    'exportConversions'=>['skip-export-html',], 
   'dataProvider' => $projectDataProvider,
    'filterModel' => $projectSearch,
    //'caption'=>Yii::t('app', 'Projects'),
    'pjax' => true,
    'bordered' => true,
    'striped' => false,
    'condensed' => true,
    'responsive' => true,
    'showHeader'=>true, 
    'hover' => true,
    'showPageSummary' => true,
    'panel' => [
        'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-project"></i> Projects</h3>',
        'type'=>'success',
        'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> Create Country', ['create'], ['class' => 'btn btn-success']),
        //'after'=>Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset Grid', ['index'], ['class' => 'btn btn-info']),
        'footer'=>false
    ],
    /*
    'panel' => [
        'type' => GridView::TYPE_PRIMARY
    ],
     */ 
    'toolbar' =>  [
        ['content'=>
            Html::button('<i class="glyphicon glyphicon-plus"></i>', 
                                ['type'=>'button', 'title'=>Yii::t('app', 'Add Project'), 'class'=>'btn btn-success', 
                                    'onclick'=>'alert("This will launch the book creation form.\n\nDisabled for this demo!");'
                                 ]) 
                                . ' '.
            Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['#'] ,['data-pjax'=>0, 'class' => 'btn btn-default', 'title'=>Yii::t('app', 'Reset Grid'), 'onclick'=>'$("#project-grid-view").yiiGridView("ajaxUpdate");'])
        ],
        '{export}',
        '{toggleData}'
        
        ],
        
          // set export properties
    'export'=>[
        'fontAwesome'=>true
    ],

    'columns' => [
         
          
          [
             'attribute'=>'code',
             'contentOptions'=>['style'=>'width: 90px;']
          ],
          [
             'attribute'=>'title',
             'contentOptions'=>['style'=>'width: 480px;']
          ],
          [
             'attribute'=>'researcher',
             
             'value'=>function($data){
                    return sprintf('%s %s',$data->pi->first_name , $data->pi->last_name);
             },
             'contentOptions'=>['style'=>'width: 200px;']
          ],
         
        [
        	'class'=>'kartik\grid\ActionColumn',
        	'template' => '{view} {update}',
            'urlCreator' => function($action, $model, $key, $index) { return '#'; },
            'contentOptions'=>['style'=>'width: 50px;']
        ],
        

    ],
	
	]);?>
<?php Pjax::end();?> 