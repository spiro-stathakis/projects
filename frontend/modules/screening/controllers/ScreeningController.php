<?php 
namespace app\modules\screening\controllers;
use yii; 
abstract class ScreeningController extends \common\components\XController
{
	private $_screeningSession = [
									'subject_hash'=>null,
									'screening_hash'=>null,
									'screening_form_id'=>null,
									'subject_hash'=>null,
									'resource_id'=>null,  
									'project_id'=>null,  
									];
	
	/* ************************************************************************************************************************* */
	/* ************************************************************************************************************************* */
	public function resetScreeningSession()
	{
			foreach($this->_screeningSession as $k=>$v)
				$this->setScreeningSession($k,null); 


	}
	/* ************************************************************************************************************************* */
	public function init()
	{
		if (yii::$app->session->get('screeningSession') === null)
            yii::$app->session->set('screeningSession' , $this->_screeningSession);
        

        return parent::init(); 

	}
	/* ************************************************************************************************************************* */
	protected function setScreeningSession($name,$value)
	{
			if (array_key_exists($name, $this->_screeningSession) === false)
				throw new \yii\web\HttpException(500, 'Invalid key in screening session structure.' );

			$this->_screeningSession = Yii::$app->session->get('screeningSession');
            $this->_screeningSession[$name] = $value; 
            yii::$app->session->set('screeningSession' , $this->_screeningSession);
    }
	/* ************************************************************************************************************************* */
	protected function getScreeningSession($name)
	{
			if (array_key_exists($name, $this->_screeningSession) === false)
				throw new \yii\web\HttpException(500, 'Invalid key in screening session structure.');
			
			$this->_screeningSession = Yii::$app->session->get('screeningSession');
			
			return $this->_screeningSession[$name]; 

	}
	/* ************************************************************************************************************************* */
	
}