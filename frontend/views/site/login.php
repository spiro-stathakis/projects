<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\packages\LoginUiAsset; 

LoginUiAsset::register($this); 
$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="site-login">
   
  <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
 <div class="container">
                <div class="row vertical-offset-100">
                    <div class="col-md-4 col-md-offset-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">                                
                                <div class="row-fluid user-row">
                                    <img src="/img/cubric-logo-120.png" class="img-responsive" alt="CUBRIC login"/>
                                    Login
                                </div>
                            </div>
                            <div class="panel-body">
                                
                                    <fieldset>
                                        <label class="panel-login">
                                            <div class="login_result"></div>
                                        </label>
                                        <?= $form->field($model, 'username', ['options'=>['placeholder'=>'Username']]) ?>
                                        <?= $form->field($model, 'password', ['options'=>['placeholder'=>'Password']])->passwordInput() ?>
                                        <?= $form->field($model, 'rememberMe')->checkbox() ?>

                                        <div class="form-group">
                                            <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                                        </div>



                                    </fieldset>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    <?php ActiveForm::end(); ?>

</div>
