<?php 
namespace common\components; 
use Yii; 
use yii\base\Object;


class ScreeningForm extends Object
{

	private $_data; 
	
	
	/* ******************************************************************************************************* */ 
    /* ******************************************************************************************************* */ 
    /* ******************************************************************************************************* */ 
    private function _getData()
    {
    		$this->_data   = (new \yii\db\Query())
    				->select([
                        's.id as screening_form_id' , 's.name as screening_form_name', 
                        's.title as screening_form_title' , 's.description as screening_form_description',
                        'c.id as collection_id','c.name as collection_name' , 'c.description as collection_description',
    					'rct.name as collection_type_name',  
    					'rct.id as collection_type_id', 
    					'uc.member_type_id', 
    					'rmt.name as member_type_name', 
    					'uc.expiry'])
    				->from('screening_forms s')
                    ->join('LEFT JOIN','collections c' , 's.collection_id=c.id')
    				->join('LEFT JOIN','ref_collection_type rct', 'c.collection_type_id=rct.id')
    				->join('LEFT JOIN','user_collections uc', 'uc.collection_id=c.id')
                    ->join('LEFT JOIN','ref_member_type rmt', 'uc.member_type_id=rmt.id')
    				->where('uc.status_id=:status_active AND uc.user_id=:user_id AND uc.expiry > UNIX_TIMESTAMP()')
    				->addParams([':status_active'=>Types::$status['active']['id'], 
    							 ':user_id'=>\Yii::$app->user->identity->id 
    					])
    				->all();

         

    }
    /* ******************************************************************************************************* */ 
    public function init()
    {
        if ($this->_data == null)
             $this->_getData(); 
        

        return parent::init(); 
    }
    /* ******************************************************************************************************* */ 
    public function isManager($screening_form_id)
    {
        $return = false; 
        foreach($this->_data as $collection)
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
        foreach($this->_data as $collection)
            if ($collection['member_type_id'] == Types::$member_type['member']['id'] && 
                $collection['collection_id'] == $collection_id 
            )
                $return = true; 
        
        return $return; 


    }
    /* ******************************************************************************************************* */ 
    
    
	
    /* ******************************************************************************************************* */ 
    public function getAllMemberships()
	{
        $return = [];
        foreach($this->_data as $collection)
            if ($collection['member_type_id'] == Types::$member_type['member']['id'])
                $return[] = $collection; 
            
        return $return; 

	}
	/* ******************************************************************************************************* */ 
    public function  getAllManagment()
	{
        $return = [];
        foreach($this->_data as $collection)
            if ($collection['member_type_id'] == Types::$member_type['manager']['id'])
                $return[] = $collection; 
        

       
        return $return; 


	}
	/* ******************************************************************************************************* */ 
    

}