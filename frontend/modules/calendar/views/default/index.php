<?php 
use common\components\CalendarWidget;
use yii\helpers\Html; 
use yii\helpers\Url;
echo $this->render('_eventModal');
?> 
<p>&nbsp;</p>

<p>&nbsp;</p>
<?= CalendarWidget::widget(['view'=>$this, 'jsonUri'=>Url::to(['/calendar/list/events'])]); ?>
       
