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
         		<div id='div-calendar-list'> 
         		      <?=Html::checkBoxList('calendar-list',
                                        array_keys(yii::$app->CalendarComponent->myCalendarList),
                                        yii::$app->CalendarComponent->theCalendarList,
                                        ['options'=>['seperator'=>'<br/>'],'itemOptions'=>['onclick'=>'alert(\'hello\')'] ]); 

                                        ?> 
    					
         		</div>
		</ul> 
        </div>
 
 		<div class="col-sm-9  col-md-10  main">
			<?= CalendarWidget::widget(['view'=>$this, 'jsonUri'=>Url::to(['/calendar/ajax/listevents'])]); ?>
		</div>
</div>     
