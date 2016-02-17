<?php 
namespace common\components; 
use Yii; 
use yii\base\Object;


class ResourceComponent extends Object
{

	
    private $_myResources; 
    private $_allResources; 
    
	
	/* ******************************************************************************************************* */ 
    /* ******************************************************************************************************* */ 
    /* ******************************************************************************************************* */ 
   
    /* ******************************************************************************************************* */ 
    public function init()
    {
      
        return parent::init(); 
    }
    /* ******************************************************************************************************* */ 
    public function isManager($resource_id)
    {
        $return = false; 
        foreach($this->myResources as $collection)
            if ($collection['member_type_id'] == Types::$member_type['manager']['id'] && 
                $collection['resource_id'] == $resource_id 
            )
                $return = true; 
        
        return $return; 
    }
    /* ******************************************************************************************************* */ 
    /* ******************************************************************************************************* */ 
    public function isMember($resource_id)
    {
        $return = false; 
        foreach($this->myResources  as $collection)
            if ($collection['member_type_id'] == Types::$member_type['member']['id'] && 
                $collection['resource_id'] == $resource_id 
            )
                $return = true; 
        
        return $return; 


    }
    /* ******************************************************************************************************* */ 
    public function getMyResourcesByCollection($collection_id)
    {
            $arr = []; 
            if ($this->_myResources == null) 
                    $this->_myResources = $this->_getMyScreeningForms(); 
            
            foreach($this->_myResources as $res)
                    if ($res['collection_id'] == $collection_id)
                        $arr[] = $res; 
        
            return $arr; 

    }
    
	
    /* ******************************************************************************************************* */ 
    public function getAllResources()
	{
         if ($this->_allResources == null) 
            $this->_allResources = $this->_getAllResources(); 

        return $this->_allResources; 

	}
	/* ******************************************************************************************************* */ 
    public function  getMyResources()
	{

        if ($this->_myResources == null) 
            $this->_myResources = $this->_getMyScreeningForms(); 

        return $this->_myResources; 
    }
	/* ******************************************************************************************************* */ 
    /* ******************************************************************************************************* */ 
    
    public function canUse($resource_id)
    {
        return ($this->isMember($resource_id) || $this->isManager($resource_id)); 

    }
    /* ******************************************************************************************************* */ 
    private function _getAllResources()
    {
            $this->_allResources   = (new \yii\db\Query())
                    ->select([
                        'r.id as resource_id' , 'r.title as resource_title', 
                        'c.id as collection_id','c.title as collection_title' , 'c.description as collection_description',
                        'rct.name as collection_type_name',  
                        'rct.id as collection_type_id', 
                        'rmt.name as member_type_name'])
                    ->from('resource r')
                    ->join('INNER JOIN','collection c' , 'r.collection_id=c.id')
                    ->join('INNER JOIN','ref_collection_type rct', 'c.collection_type_id=rct.id')
                    ->join('INNER JOIN','ref_member_type rmt', 'uc.member_type_id=rmt.id')
                    ->all();

         return  $this->_allResources ; 

    }
    /* ******************************************************************************************************* */ 
    private function _getMyScreeningForms()
    {
            $this->_myResources   = (new \yii\db\Query())
                    ->select([
                        'r.id as resource_id' , 
                        'r.title as resource_title' , 'r.description as resource_description',
                        'c.id as collection_id','c.title as collection_title' , 'c.description as collection_description',
                        'rct.name as collection_type_name',  
                        'rct.id as collection_type_id', 
                        'uc.member_type_id', 
                        'rmt.name as member_type_name', 
                        'uc.expiry'])
                    ->from('resource r')
                    ->join('LEFT JOIN','collection c' , 'r.collection_id=c.id')
                    ->join('LEFT JOIN','ref_collection_type rct', 'c.collection_type_id=rct.id')
                    ->join('LEFT JOIN','user_collection uc', 'uc.collection_id=c.id')
                    ->join('LEFT JOIN','ref_member_type rmt', 'uc.member_type_id=rmt.id')
                    ->where('uc.status_id=:status_active AND uc.user_id=:user_id AND uc.expiry > UNIX_TIMESTAMP()')
                    ->addParams([':status_active'=>Types::$status['active']['id'], 
                                 ':user_id'=>\Yii::$app->user->identity->id 
                        ])
                    ->all();
             return  $this->_myResources ; 
         

    }
    /* ******************************************************************************************************* */ 

}