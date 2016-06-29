 <?php

use yii\bootstrap\Html;
use kartik\form\ActiveForm;
use kartik\builder\Form;
use kartik\widgets\SwitchInput;
use yii\helpers\Url; 

//use frontend\packages\BootstrapTreeviewAsset;
use frontend\packages\BootstrapEditableAsset; 
BootstrapEditableAsset::register($this);
?>

<div class="row">
      <div class="col-sm-3 col-md-2">
      	Title 
      </div>
      <div class="col-sm-3 col-md-2">
      	<span id='span-event-title'></span>

      </div>
      <div class="col-sm-3 col-md-2">
      	Description 
      </div>
      <div class="col-sm-3 col-md-2">
      	<span id='span-event-description'></span> 

      </div>
</div> 


<div class="row">
      <div class="col-sm-3 col-md-2">
      	Calendar 
      </div>
      <div class="col-sm-3 col-md-2">
      	<span id='span-event-calendar'></span>
      </div>
      <div class="col-sm-3 col-md-2">
      	Project 
      </div>
      <div class="col-sm-3 col-md-2">
      	<span id='span-event-project'></span> 
      </div>
</div>

<div class="row">
      <div class="col-sm-3 col-md-2">
      	Date 
      </div>
      <div class="col-sm-3 col-md-2">
      	<span id='span-event-date'></span>
      </div>
      <div class="col-sm-3 col-md-2">
      	From  
      </div>
      <div class="col-sm-3 col-md-2">
      	<span id='span-event-from'></span>
      	To 
      	<span id='span-event-to'></span> 
      </div>
</div>

<div class="row">
      <div class="col-sm-3 col-md-2">
      	Created by 
      </div>
      <div class="col-sm-3 col-md-2">
      	<span id='span-event-create'></span>
      </div>
      <div class="col-sm-3 col-md-2">
      	Date  
      </div>
      <div class="col-sm-3 col-md-2">
      	<span id='span-event-create-date'></span>
      	
      </div>
</div>







