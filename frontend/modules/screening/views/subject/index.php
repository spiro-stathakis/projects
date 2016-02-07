<?php

use yii\helpers\Html;
use yii\helpers\Url; 
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SubjectsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Subjects');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subjects-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Subjects'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    



   <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            'cubric_id',
            'first_name',
            'last_name',
            'dob',
            // 'email:email',
            // 'telephone',
            // 'address',
            // 'gp_opt_id',
            // 'email_opt_id:email',
            // 'sex_id',
            // 'sort_order',
            // 'status_id',
            // 'created_at',
            // 'updated_at',
            // 'created_by',
            // 'updated_by',

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
                                    $url = Url::to(['/screening/default/create','project_id'=>\Yii::$app->screeningform->project_id, 'screening_form_id'=>\Yii::$app->screeningform->screening_form_id, 'subject'=>$model->hash]); // your own url generation logic
                                    return $url;
                                }
                            }    
                        ],
            ],
        ]); ?>

</div>
