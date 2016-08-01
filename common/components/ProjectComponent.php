<?php 
namespace common\components; 
use Yii; 
use yii\base\Object;
use common\components\Types; 
use yii\bootstrap\Html;


class ProjectComponent extends Object
{

	private $_myProjects; 
    private $_allProjects;  
	private $_userId; 
	
	/* ******************************************************************************************************* */ 
    /* ******************************************************************************************************* */ 
    /* ******************************************************************************************************* */ 
    /* ******************************************************************************************************* */ 
    /* ******************************************************************************************************* */ 
    public function init()
    {
        if (! yii::$app->user->isGuest)
            $this->_userId = yii::$app->user->id; 

        return parent::init(); 
    }
    /* ******************************************************************************************************* */ 
    
    /* ******************************************************************************************************* */ 
    public function getMyProjects()
	{
        if ($this->_myProjects === null)
        {
              if (Yii::$app->user->can('core_staff_role'))
                    $this->_myProjects = $this->allProjects; 
              else 
                    $this->_myProjects = $this->_myProjects();  
        }
        return $this->_myProjects;
    }
	/* ******************************************************************************************************* */ 
    public function canUse($project_id)
    {

            if (Yii::$app->user->can('core_staff_role'))
                return true; 
            else 
                return ($this->isMember($project_id) || $this->isManager($project_id)); 
    }
    /* ******************************************************************************************************* */ 
    public function isMember($project_id)
    {

        $return  = false; 
        foreach($this->myProjects as $project)
            if ( $project['project_id'] == $project_id ) 
                $return = true; 

        return true; 

    }
    /* ******************************************************************************************************* */ 
    public function getMyProjectCollectionList()
    {
        $list = []; $out = []; 
        if (Yii::$app->user->can('core_staff_role'))
            $list = $this->allProjects; 
        else 
            $list = $this->myProjects; 
        foreach ($list as $project) 
            $out[$project['project_id']] = $project['project_title']; 

        return $out; 
        
    }
    /* ******************************************************************************************************* */ 
    
    public function getMyProjectList()
    {
        $list = []; $out = []; 
        if (Yii::$app->user->can('core_staff_role'))
            $list = $this->allProjects; 
        else 
            $list = $this->myProjects; 

        
        if (count($list) > 0)
            foreach ($list as $project) 
                $out[$project['project_id']] = $project['project_title']; 

        return $out; 
        
    }
    /* ******************************************************************************************************* */ 
    public function getAllProjects()
    {
        if ($this->_allProjects === null)
            $this->_allProjects =  $this->_allProjects(); 

        return $this->_allProjects; 
    }
    /* ******************************************************************************************************* */ 
    /* private functions */ 
    /* ******************************************************************************************************* */ 
   /* ******************************************************************************************************* */ 
   
   private  function _allProjects() 
    {

            return (new \yii\db\Query())
                    ->select([
                            'c.title as collection_title','c.description as collection_description',
                            'p.id as project_id','p.title as project_title','p.code as project_code'
                           ])
                    ->from('collection c')
                    ->join('LEFT JOIN','project p' , 'p.collection_id=c.id')
                    ->orderBy('p.created_at DESC')
                    ->all();

         

    }
   /* ******************************************************************************************************* */ 
     private  function _myProjects() 
    {

            return (new \yii\db\Query())
                    ->select([
                            'c.title as collection_title','c.description as collection_description',
                            'p.id as project_id','p.title as project_title','p.code as project_code', 
                            'uc.member_type_id'
                             ])
                    ->from('collection c')
                    ->join('LEFT JOIN','user_collection uc' , 'uc.collection_id=c.id')
                    ->join('INNER JOIN','project p' , 'p.collection_id=c.id')
                    ->where('uc.status_id=:status_active AND uc.user_id=:user_id')
                    ->addParams([':status_active'=>Types::$status['active']['id'], 
                                 ':user_id'=>$this->_userId 
                        ])
                    ->all();

         

    }
    /* ******************************************************************************************************* */ 
    /* ******************************************************************************************************* */ 
    /* ******************************************************************************************************* */ 
    /* ******************************************************************************************************* */ 
    

}