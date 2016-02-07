
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
    private function _getMyCalendars()
    {
            $this->_myScreeningForms   = (new \yii\db\Query())
                    ->select([
                    	'cal.id as calendar_id', 'c.id as collection_id', 
                    	'cal.title as calendar_title',
                    	'c.name  as collection_name',
                    	'' 

                    	from calendar cal inner join collection c on cal.collection_id=c.id right join collection_collection cc on cc.parent_collection_id = c.id right join user_collection uc on cc.child_collection_id=uc.collection_id where cal.title is not null and uc.user_id=44 and uc.member_type_id=3

                        's.id as screening_form_id' , 's.name as screening_form_name', 
                        's.title as screening_form_title' , 's.description as screening_form_description',
                        'c.id as collection_id','c.name as collection_name' , 'c.description as collection_description',
                        'rct.name as collection_type_name',  
                        'rct.id as collection_type_id', 
                        'uc.member_type_id', 
                        'rmt.name as member_type_name', 
                        'uc.expiry'])
                    ->from('screening_form s')
                    ->join('LEFT JOIN','collection c' , 's.collection_id=c.id')
                    ->join('LEFT JOIN','ref_collection_type rct', 'c.collection_type_id=rct.id')
                    ->join('LEFT JOIN','user_collection uc', 'uc.collection_id=c.id')
                    ->join('LEFT JOIN','ref_member_type rmt', 'uc.member_type_id=rmt.id')
                    ->where('uc.status_id=:status_active AND uc.user_id=:user_id AND uc.expiry > UNIX_TIMESTAMP()')
                    ->addParams([':status_active'=>Types::$status['active']['id'], 
                                 ':user_id'=>\Yii::$app->user->identity->id 
                        ])
                    ->all();
             return  $this->_myScreeningForms ; 
         

    }
    /* ******************************************************************************************************* */ 

}