<?php 
namespace common\components; 
use Yii; 
use yii\base\Object;


class CalendarComponent extends Object
{

	

    private $_myCalendars; 
    private $_myCalendarCollections; 
    
	
	/* ******************************************************************************************************* */ 
    /* ******************************************************************************************************* */ 
    /* ******************************************************************************************************* */ 
   
    /* ******************************************************************************************************* */ 
    public function init()
    {
      
        return parent::init(); 
    }
    /* ******************************************************************************************************* */ 
    public function isManager($screening_form_id)
    {
        $return = false; 
        foreach($this->myScreeningForms as $collection)
            if ($collection['member_type_id'] == Types::$member_type['manager']['id'] && 
                $collection['screening_form_id'] == $screening_form_id 
            )
                $return = true; 
        
        return $return; 
    }
    /* ******************************************************************************************************* */ 
    /* ******************************************************************************************************* */ 
    public function getEvents($start,$end)
    {
        return $this->_getEvents($start, $end); 
        
    }
    /* ******************************************************************************************************* */ 
    /* ******************************************************************************************************* */ 
    public function isMember($collection_id)
    {
        $return = false; 
        foreach($this->myScreeningForms  as $collection)
            if ($collection['member_type_id'] == Types::$member_type['member']['id'] && 
                $collection['collection_id'] == $collection_id 
            )
                $return = true; 
        
        return $return; 


    }
    /* ******************************************************************************************************* */ 
    
    
	
    /* ******************************************************************************************************* */ 
    public function getAllScreeningForms()
	{
         if ($this->_allScreeningForms == null) 
            $this->_allScreeningForms = $this->_allMyScreeningForms(); 

        return $this->_allScreeningForms; 

	}
	/* ******************************************************************************************************* */ 
    public function  getMyCalendars()
	{

        if ($this->_myCalendars == null) 
            $this->_myCalendars = $this->_getMyCalendars(); 

        return $this->_myCalendars; 
    }
	/* ******************************************************************************************************* */ 
    
    /* ******************************************************************************************************* */ 
    private function _getAllScreeningForms()
    {
            $this->_allScreeningForms   = (new \yii\db\Query())
                    ->select([
                        's.id as screening_form_id' , 's.name as screening_form_name', 
                        's.title as screening_form_title' , 's.description as screening_form_description',
                        'c.id as collection_id','c.name as collection_name' , 'c.description as collection_description',
                        'rct.name as collection_type_name',  
                        'rct.id as collection_type_id', 
                        'rmt.name as member_type_name'])
                    ->from('screening_form s')
                    ->join('LEFT JOIN','collection c' , 's.collection_id=c.id')
                    ->join('LEFT JOIN','ref_collection_type rct', 'c.collection_type_id=rct.id')
                    ->join('LEFT JOIN','ref_member_type rmt', 'uc.member_type_id=rmt.id')
                    ->all();

         return  $this->_allScreeningForms ; 

    }
    /* ******************************************************************************************************* */ 
    

    private function _getEvents($start, $end)
         {
            $data   = (new \yii\db\Query())
                ->select([
                    'e.id as event_id' , 'e.title as event_title',
                    'e.description as event_description' , 'e.calendar_id', 
                    'e.project_id' , 'e.all_day_option_id', 
                    'ee.id as event_entry_id' , 'ee.title as event_entry_title', 
                    'ee.description as event_entry_description', 'ee.booking_status_id', 
                    'ee.start_timestamp' , 'ee.end_timestamp' , 'ee.all_day_option_id' , 
                    'p.code as hex_code', 
                    ])
                ->from('event e')
                ->join('LEFT JOIN','calendar c' , 'e.calendar_id=c.id')
                ->join('LEFT JOIN', 'event_entry ee' , 'ee.event_id=e.id')
                ->join('LEFT JOIN','ref_booking_status rbs', 'ee.booking_status_id=rbs.id')
                ->join('LEFT JOIN','palette p', 'c.palette_id=p.id')
                ->where('ee.start_timestamp >= :start AND ee.end_timestamp <= :end')
                 ->addParams([':start'=>$start, 
                             ':end'=>$end 
                        ])
                ->all();

         return  $data; 

        }
    /* ******************************************************************************************************* */ 
    
    private function _getMyCalendars()
    {

        $select =       ['cal.id as calendar_id', 'cal.collection_id', 
                        'cal.title as calendar_title',
                        'col.title  as collection_title',
                        'p.code as hex_code']; 

            $query1   = (new \yii\db\Query())
                    ->select($select)
                    ->from('calendar cal')
                    ->join('INNER JOIN','collection col' , 'cal.collection_id=col.id')
                    ->join('INNER JOIN','user_collection uc', 'uc.collection_id=col.id')
                    ->join('INNER JOIN','palette p', 'cal.palette_id=p.id')
                    ->join('LEFT JOIN','calendar_subscription cs', 'cs.calendar_id=cal.id')
                    ->where('(uc.status_id=:status_active) 
                            AND 
                            (uc.expiry = 0 OR uc.expiry > UNIX_TIMESTAMP()) 
                            AND 
                            (uc.member_type_id=:mem_type_manager OR uc.member_type_id=:mem_type_member)
                            AND  
                            
                            uc.user_id=:user_id')
                    ->addParams([':status_active'=>Types::$status['active']['id'], 
                                 ':mem_type_manager'=>Types::$member_type['manager']['id'], 
                                ':mem_type_member'=>Types::$member_type['member']['id'], 
                                ':user_id'=>\Yii::$app->user->identity->id 
                        ]);

            $query2   = (new \yii\db\Query())
                    ->select($select)
                    ->from('calendar cal')
                    ->join('INNER JOIN','collection col' , 'cal.collection_id=col.id')
                    ->join('INNER JOIN','user_collection uc', 'uc.collection_id=col.id')
                    ->join('INNER JOIN','palette p', 'cal.palette_id=p.id')
                    ->join('LEFT JOIN','calendar_subscription cs', 'cs.calendar_id=cal.id')
                    ->where('(uc.status_id=:status_active) 
                            AND 
                            (uc.expiry = 0 OR uc.expiry > UNIX_TIMESTAMP()) 
                            AND 
                            (uc.member_type_id=:mem_type_manager OR uc.member_type_id=:mem_type_member)
                            AND 
                            uc.user_id=:user_id')
                    ->addParams([':status_active'=>Types::$status['active']['id'], 
                                 ':mem_type_manager'=>Types::$member_type['manager']['id'], 
                                ':mem_type_member'=>Types::$member_type['member']['id'], 
                                ':user_id'=>\Yii::$app->user->identity->id 
                        ]);
                $unionQuery = (new \yii\db\Query())
                    ->from(['union_query' => $query1->union($query2)])
                    ->all();

             return  $unionQuery; 
         

    }
    /* ******************************************************************************************************* */ 

}