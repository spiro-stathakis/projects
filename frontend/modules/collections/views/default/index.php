<?php 

use kartik\grid\GridView; 
use yii\helpers\Html; 
?> 



<div class="collections-default-index">
    

    <?php  
    
    if ($managerProvider->getCount() > 0):
            echo sprintf('<h4>%s</h4>' , 'Collections I manage.'); 
            echo GridView::widget([
            'dataProvider'=> $managerProvider,
            'responsive'=>true,
            'export'=>false, 
            'hover'=>true,
            'condensed'=>true, 
            'columns' => [
                'collection_title',
                ['attribute' => 'collection_description'],
                ['attribute' => 'collection_type_name', 'header'=>'Type'] ,
                ['header'=>'Options' , 'format'=>'raw', 
                            'value'=>function($model){
                                    return Html::a('memberships' , ['members','id'=>$model['collection_id']]); 
                                    
                            }
            ] ,
             ],
        ]);
    endif; 
?> 

 <?php  
    
    if ($memberProvider->getCount() > 0):
            echo sprintf('<h4>%s</h4>' , 'Collection memberships.'); 
            echo GridView::widget([
            'dataProvider'=> $memberProvider,
            'responsive'=>true,
            'export'=>false, 
            'hover'=>true,
            'condensed'=>true, 
            'columns' => [
                'collection_title',
                ['attribute' => 'collection_description'],
                ['attribute' => 'collection_type_name', 'header'=>'Type'] ,
             ],
        ]);
    endif; 
?> 
</div>
