<?php

use yii\helpers\Html;
use yii\helpers\Url; 
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SubjectsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


?>
<?php echo $this->render('../default/_stepBar' , ['activeElement'=>4]);?> 
<div class="subjects-index">

    

<?php if ($dataProvider->totalCount === 0):  ?>

<h4> Could not find a record. What would you like to do? </h4>
<?= Html::beginForm ( ['create'], 'post' );?>
<?= Html::hiddenInput('first_name', $searchModel->first_name);?>
<?= Html::hiddenInput('last_name', $searchModel->last_name);?>
<?= Html::hiddenInput('dob', $searchModel->dob);?>




<?= Html::submitButton (sprintf('Create %s %s record entry', $searchModel->first_name , $searchModel->last_name), ['class'=>'btn btn-primary']); ?>
<h4> Or </h4>
<?= Html::a(Yii::t('app', 'Search again'), ['/screening'], ['class' => 'btn btn-success']) ?>




<?= Html::endForm();?>

 <p></p>


<?php endif; ?> 

    
<?php if ($dataProvider->totalCount > 0):  ?>


       <?= GridView::widget([
            'dataProvider' => $dataProvider,
            //'filterModel' => $searchModel,
            'columns' => [
                'cubric_id',
                'first_name',
                'last_name',
                'dob',
                [
                'class' => 'yii\grid\ActionColumn', 
                'template'=>'{screen}&nbsp',
                                'buttons'=>[
                                  'screen' => function ($url, $model) {     
                                    return Html::a('<span class="glyphicon glyphicon-list-alt"></span>', $url, [
                                            'title' => Yii::t('yii', 'Start screening process'),
                                    ]);                                
                
                                  }
                            ], 
                               'urlCreator' => function ($action, $model, $key, $index) {
                                   if ($action === 'screen') {
                                    $url = Url::to(['/screening/default/create',
                                        'project_id'=>\yii::$app->ScreeningForm->project_id, 
                                        'screening_form_id'=>\yii::$app->ScreeningForm->screening_form_id,
                                        'resource_id'=>\yii::$app->ScreeningForm->resource_id,
                                        'subject'=>$model->hash]); // your own url generation logic
                                        return $url;
                                    }
                                }    
                            ],
                ],
            ]); ?>

<?php endif; ?> 

</div>
