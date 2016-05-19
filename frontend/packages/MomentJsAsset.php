<?php 

namespace frontend\packages;

use yii\web\AssetBundle;

class MomentJsAsset  extends AssetBundle 
{
	
	public $basePath = '@webroot';
    public $baseUrl = '@web';
	public $css = [
		
	]; 
	public $js = [
		'js/app/moment-with-locales.js',
		
	]; 
	public $depends =[
		'yii\web\YiiAsset', 
		'yii\bootstrap\BootstrapAsset',
		'frontend\packages\AppJsAsset',
		
	]; 


} 
