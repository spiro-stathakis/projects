<?php
namespace common\components;

use yii\base\Widget;
use yii\helpers\Html;
use frontend\packages\CalendarJsAsset;

use yii\helpers\Url;
use yii\web\JsExpression;



class CalendarWidget extends Widget{
	public $view; 	
	public $jsonUri; 
    private $_css; 
	public function init(){
		parent::init();
		

        foreach(\yii::$app->CalendarComponent->myCalendars as $cal)
            $this->_css .= sprintf('.calendar-%s, *  fc-time-grid-event fc-v-event fc-event fc-start fc-end , 
                .calendar-%s a {background-color:%s;border-color:%s;opacity: 1;} 
                .calendar-%s  .fc-time{opacity:2;background-color:%s}' , 
                $cal['calendar_id'], $cal['calendar_id'], $cal['hex_code'], 
                $cal['hex_code'] , $cal['calendar_id'] ,$cal['hex_code']
                ); 




	}
	
	public function run(){
	
        $this->view->registerCss($this->_css);
		CalendarJsAsset::register($this->view);

		return \yii2fullcalendar\yii2fullcalendar::widget(array(
         'ajaxEvents' => $this->jsonUri,
         'options'=>[
                'lang'=>'en-gb', 
                'timeFormat'=>'H(:mm)', // uppercase H for 24-hour clock
                'aspectRatio'=>1.4, 
                'id'=>'full-calendar', 

                


                
         ] , 
         
         'clientOptions'=>[ 

                        'weekends' => true,
        				'defaultView' => 'agendaWeek',
        				'editable' => false,
                        'dayClick' => new JsExpression("function(date, jsEvent, view){ $.app.cal.dayClick(date, jsEvent, view)}"),
                        'eventClick' => new JsExpression("function(event, jsEvent, view){ $.app.cal.eventClick(event, jsEvent, view)}"),
                        'eventMouseover' => new JsExpression("function(event, jsEvent, view){ $.app.cal.eventMouseover(event, jsEvent, view)}" ),

        					], 
        'header' => [
        			'center'=>'title',
        			'left'=>'prev,next today',        
        			'right'=>'month,agendaWeek,agendaDay'
    			],
          
      ));



	}
}
?>
