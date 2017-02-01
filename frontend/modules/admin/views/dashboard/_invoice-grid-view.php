<?php use yii\widgets\Pjax; ?> 
<?php use kartik\grid\GridView; ?> 
<?php use  yii\helpers\Html;?> 

<?php Pjax::begin(['id'=>'invoice-pjax' ,
                  'timeout' => false, 
                  'enablePushState' => false, 
                  'clientOptions' => ['method' => 'POST']
                  ]);?>

<?=GridView::widget([
    'id'=>'invoice-grid-view',
    
    'layout'=>"{pager}\n{summary}\n{items}",
    'dataProvider' => $invoiceDataProvider,
    'filterModel' => $invoiceSearch,
    'pjax' => true,
    'bordered' => true,
    'striped' => false,
    'condensed' => true,
    'responsive' => true,
    'showHeader'=>true, 
    'hover' => true,
    
    'showPageSummary' => true,
     'panel' => [
        'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-project"></i> Invoices</h3>',
        'type'=>'primary',
        'footer'=>false
    ],
        // set export properties
    'export'=>[
        'fontAwesome'=>true
    ],
    'toolbar' =>  [
        ['content'=>
            Html::button('<i class="glyphicon glyphicon-plus"></i>', 
                                ['type'=>'button', 'title'=>Yii::t('app', 'Add Invoice'), 'class'=>'btn btn-primary', 
                                    'onclick'=>'alert("This will launch the book creation form.\n\nDisabled for this demo!");'
                                 ]) 
                                . ' '.
            Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['#'] ,['data-pjax'=>0, 'class' => 'btn btn-default', 'title'=>Yii::t('app', 'Reset Grid'), 'onclick'=>'$("#invoice-grid-view").yiiGridView("ajaxUpdate");'])
        ],
        '{export}',
        '{toggleData}'
        
        ],
    'columns' => [

        [
            'class'=>'kartik\grid\ExpandRowColumn',
            'width'=>'50px',
            'value'=>function ($model, $key, $index, $column) {
                    return GridView::ROW_COLLAPSED;
            },
            'detail'=>function ($model, $key, $index, $column) {
                        return Yii::$app->controller->renderPartial('_expand-invoice-view', ['model'=>$model]);
            },
            'headerOptions'=>['class'=>'kartik-sheet-style'] ,
            'expandOneOnly'=>true
        ],

        [
        
        'attribute'=>'project_code',
        'width'=>'100px',
        'value'=>function($data){
                return $data->project->code;
         },
         'contentOptions'=>['style'=>'width: 200px;']
        ],
        [
            'attribute'=>'invoice_number',
            'width'=>'100px'
        ], 
         [
             'attribute'=>'researcher',
             
             'value'=>function($data){
                    return sprintf('%s %s',$data->project->pi->first_name , $data->project->pi->last_name);
             },
             'contentOptions'=>['style'=>'width: 200px;']
          ],
        [
            'attribute'=>'amount',
            'width'=>'150px',
            'hAlign'=>'right',
            'format'=>['decimal', 2],
            'pageSummary'=>true,
            //'pageSummaryFunc'=>GridView::F_AVG
        ],
        [
            'class'=>'kartik\grid\ActionColumn',
            'template' => '{view} {update}',
        ],
    ],
     
    ]);?>
<?php Pjax::end();?> 