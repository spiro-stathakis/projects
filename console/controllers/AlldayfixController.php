<?php 
namespace console\controllers;

use yii\console\Controller;
use common\components\Types; 
use frontend\modules\calendar\models\EventEntry; 
use common\models\UserIdentity;

class AlldayfixController extends Controller
{
    public $message;
    
    /* ********************************************************************* */
    public function options()
    {
        return ['message'];
    }
    
    /* ********************************************************************* */
    public function optionAliases()
    {
        return ['m' => 'message'];
    }
    
    /* ********************************************************************* */
    public function actionIndex()
    {
        return $this->_fixAllDayEvents();
    }

    /* ********************************************************************* */
    private function _fixAllDayEvents()
    {
        foreach($this->_getData() as $e)
        {
            $eeModel = EventEntry::findOne($e['event_entry_id']); 
            $startDate = date('d-m-Y',$eeModel->start_timestamp); 
            $dateArray = explode('-', $startDate);
            $endDate = date('d-m-Y', $eeModel->end_timestamp); 
            $newStartTimestamp = mktime(7,0,0,$dateArray[1] , $dateArray[0] , $dateArray[2]); 
            $newEndTimestamp = mktime(21,0,0,$dateArray[1] , $dateArray[0] , $dateArray[2]); 
            
            $eeModel->start_timestamp = $newStartTimestamp; 
            $eeModel->end_timestamp = $newEndTimestamp; 
            //if (! $eeModel->save())
             //   print_r($eeModel->getErrors()); 
                    
        }   

    }
    /* ********************************************************************* */
    private function _getData()
    {

        $data   = (new \yii\db\Query())
            ->select(['ee.id as event_entry_id' , 'ee.start_timestamp', 'ee.end_timestamp'])
            ->from('event_entry ee')
            ->where(
                    '(ee.all_day_option_id= :true)')
             ->addParams([':true'=>Types::$boolean['true']['id'],])
            ->all();

     return  $data; 
    }

    /* ********************************************************************* */
}
