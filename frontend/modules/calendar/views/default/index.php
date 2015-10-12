<?php 
use frontend\packages\CalendarJsAsset;

use yii\helpers\Url;

CalendarJsAsset::register($this);
?> 

<?= \yii2fullcalendar\yii2fullcalendar::widget(array(
         'ajaxEvents' => Url::to(['/calendar/list/events']),
         'options'=>[
                'lang'=>'', 
                'utc'=>true, 
         ] , 
         'clientOptions'=>[ 'weekends' => true,
        					'default' => 'month',
        					'editable' => true,
        					], 
        'header' => [
        			'center'=>'title',
        			'left'=>'prev,next today',        
        			'right'=>'month,agendaWeek,agendaDay'
    			],
          
      ));
?>
