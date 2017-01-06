<?php 

use kartik\grid\GridView; 
use yii\helpers\Html; 
use yii\helpers\Url; 
use rmrevin\yii\fontawesome\FA;
rmrevin\yii\fontawesome\AssetBundle::register($this);
?> 



<div class="collections-default-index">
    
    <div class="row">
        <div class="row">
            
            <div class="col-sm-6 col-sm-offset-2  col-md-6 col-md-offset-2 ">
                <p> &nbsp;</p>
               <a href="<?=Url::to(['/collections/manage/create']);?>" class="btn btn-success btn-lg">
                        <span class="glyphicon glyphicon-groups"></span> New collection
                </a>
            </div>
    </div>  
            <div class="col-sm-6 col-sm-offset-2 col-md-7 col-md-offset-2 main">
                 <div></div>
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
                                                    return sprintf('%s %s&nbsp;&nbsp;&nbsp;%s %s',
                                                    FA::icon('cog'),
                                                    Html::a('settings' , ['manage/update','id'=>$model['collection_id']]),
                                                    FA::icon('users'),
                                                    Html::a('members' , ['manage/members','id'=>$model['collection_id']])
                                                    
                                                        ); 
                                                    
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
        </div> 
    </div>
