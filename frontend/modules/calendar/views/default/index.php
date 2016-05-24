<?php 
use common\components\CalendarWidget;

use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\bootstrap\Html; 
use frontend\modules\calendar\models\Booking; 





echo $this->render('_bookingModal', ['model'=>$bookingModel]);
?> 
<p>&nbsp;</p>

<p>&nbsp;</p>

<div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
         		<div id='tree'> 
         		     
    					
         		</div>
		</ul> 
        </div>
 
 		<div class="col-sm-9  col-md-10  main">
			<?= CalendarWidget::widget(['view'=>$this, 'jsonUri'=>Url::to(['/calendar/ajax/listevents'])]); ?>
		</div>
</div>     
