<?php 

namespace frontend\packages;

use yii\web\AssetBundle;

class BootstrapTreeviewAsset  extends AssetBundle 
{
	
	public $basePath = '@webroot';
    	public $baseUrl = '@web';
	public $css = [
		'css/bootstrap-treeview.css'
	]; 
	public $js = [
		'js/app/bootstrap-treeview.js',
		
	]; 
	public $depends =[
		'yii\web\YiiAsset', 
		'yii\bootstrap\BootstrapAsset',
		'frontend\packages\AppJsAsset',
		
	]; 


} 
