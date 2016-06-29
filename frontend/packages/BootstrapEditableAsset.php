<?php 

namespace frontend\packages;

use yii\web\AssetBundle;

class BootstrapEditableAsset  extends AssetBundle 
{
	
	public $basePath = '@webroot';
    public $baseUrl = '@web';
	public $css = [
		'css/bootstrap-editable.css'
	];
	public $js = [
		'js/app/bootstrap-editable.js'
	]; 
	public $depends =[
		'yii\bootstrap\BootstrapAsset',
	]; 


} 
