
<?php \frontend\packages\StepBarAsset::register($this); ?> 
<?php $activeList = yii::$app->ScreeningForm->getStepBar($activeElement); ?> 


 <h2><?= Yii::t('app', 'CUBRIC - Electronic screening');?></h2>
		
    <ul class="nav nav-pills nav-wizard">

    <?php $css = ($activeElement == 6 ) ? 'class="disabled"': '' ?>  
   <?=( $activeElement == 0  && $activeElement != 6) ?  '<li class="active">' : '<li>' ; ?> 
        <a <?=$css;?> href="#"><?=$activeList[0]['label'];?></a>
        <div class="nav-arrow"></div>
    </li>

    <?php $css = ($activeElement < 1 ||  $activeElement == 6 ) ? 'class="disabled"': '' ?>  
     <?=($activeElement == 1 ) ? '<li class="active">' : '<li>' ; ?> 
        <div class="nav-wedge"></div>
         <a <?=$css;?> href="#">Scanner</a>
        <div class="nav-arrow"></div>
    </li> 

    <?php $css = ($activeElement < 2  ||  $activeElement == 6) ? 'class="disabled"': '' ?>  
     <?=($activeElement == 2) ?  '<li class="active">' : '<li>' ; ?> 
        <div class="nav-wedge"></div>
        <a <?=$css;?> href="#"><?=$activeList[2]['label'];?></a>
        <div class="nav-arrow"></div>
    </li>

    <?php $css = ($activeElement < 3  ||  $activeElement == 6) ? 'class="disabled"': '' ?>  
     <?= ($activeElement == 3) ?  '<li class="active">' : '<li>' ; ?> 
        <div class="nav-wedge"></div>
        <a <?=$css;?> href="#">Register participant</a>
        <div class="nav-arrow"></div>
    </li>

    <?php $css = ($activeElement < 4  ||  $activeElement == 6) ? 'class="disabled"': '' ?>  
     <?= ($activeElement == 4) ?  '<li class="active">' : '<li>' ; ?> 
       <div class="nav-wedge"></div>
       <a <?=$css;?> href="#">Screening</a>
        <div class="nav-arrow"></div>
    </li>


    <?php $css = ($activeElement < 5  ||  $activeElement == 6) ? 'class="disabled"': '' ?>  
     <?= ($activeElement == 5) ?  '<li class="active">' : '<li>' ; ?> 
        <div class="nav-wedge"></div>
         <a <?=$css;?> href="#">Signature</a>
        <div class="nav-arrow"></div>
    </li>


    <?php $css = ($activeElement < 6) ? 'class="disabled"': '' ?>  

    <?= ($activeElement == 6) ?  '<li class="active">' : '<li>' ; ?> 
        <div class="nav-wedge"></div>
        <a <?=$css;?> href="#">Finish</a>
    </li>


</ul>
        
    