<?php 
use frontend\packages\CalendarJsAsset;

use yii\helpers\Url;
use yii\web\JsExpression;

CalendarJsAsset::register($this);

echo $this->render('_eventModal');
?> 

<?= \yii2fullcalendar\yii2fullcalendar::widget(array(
         'ajaxEvents' => Url::to(['/calendar/list/events']),
         'options'=>[
                'lang'=>'', 
                
         ] , 
         'clientOptions'=>[ 'weekends' => true,
        					'defaultView' => 'agendaWeek',
        					'editable' => true,

                            'dayClick' => new JsExpression("function(date, jsEvent, view){ $.app.cal.dayClick(date, jsEvent, view)}"),
                            'eventClick' => new JsExpression("function(date, jsEvent, view){ $.app.cal.eventClick(date, jsEvent, view)}"),

        					], 
        'header' => [
        			'center'=>'title',
        			'left'=>'prev,next today',        
        			'right'=>'month,agendaWeek,agendaDay'
    			],
          
      ));
?>
