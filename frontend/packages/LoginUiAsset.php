<?php 

namespace frontend\packages;

use yii\web\AssetBundle;

class LoginUiAsset  extends AssetBundle 
{
	//public $sourcePath ='@frontend/css'; 
	public $basePath = '@frontend';
	public $baseUrl = '@web';  
	public $css = [
			'css/login.css'
	]; 
	public $js = []; 
	public $depends =[
		'yii\web\YiiAsset', 
		'yii\bootstrap\BootstrapAsset' 	
	]; 


} 
