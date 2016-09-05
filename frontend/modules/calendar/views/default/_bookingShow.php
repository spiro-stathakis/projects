 <?php

use yii\bootstrap\Html;
use kartik\form\ActiveForm;
use kartik\builder\Form;
use kartik\widgets\SwitchInput;
use yii\helpers\Url; 

//use frontend\packages\BootstrapTreeviewAsset;
use frontend\packages\BootstrapEditableAsset; 
//use frontend\packages\BootstrapDatePickerAsset;

BootstrapEditableAsset::register($this);
//BootstrapDatePickerAsset::register($this); 
?>

<div class="row">
      <div class="col-sm-2 col-md-1">
      	<strong>Title</strong> 
      </div>
      <div class="col-sm-5 col-md-4">
      	<span id='span-event-title'></span>

      </div>
      <div class="col-sm-2 col-md-1">
      	<strong>Description</strong>
      </div>
      <div class="col-sm-5 col-md-4">
      	<span id='span-event-description'></span> 

      </div>
</div> 


<div class="row">
      <div class="col-sm-2 col-md-1">
      	<strong>Calendar</strong> 
      </div>
      <div class="col-sm-5 col-md-4">
      	<span id='span-event-calendar'></span>
      </div>
      <div class="col-sm-2 col-md-1">
      	<strong>Project</strong> 
      </div>
      <div class="col-sm-5 col-md-4">
      	<span id='span-event-project'></span> 
      </div>
</div>

<div class="row">
      <div class="col-sm-2 col-md-1">
      	<strong>Date</strong> 
      </div>
      <div class="col-sm-5 col-md-4">
      	<span id='span-event-date'></span>
      </div>
      <div class="col-sm-2 col-md-1">
      	<strong>From</strong>  
      </div>
      <div class="col-sm-5 col-md-4">
      	<span id='span-event-from'></span>
      	<strong>To</strong> 
      	<span id='span-event-to'></span> 
      </div>
</div>
<p>&nbsp;</p>
<div class="row small">
      <div class="col-sm-6 col-md-4">
      	Created by 
      <span id='span-event-create'></span>
      on  
      <span id='span-event-create-date'></span>
      	
      </div>
</div>







