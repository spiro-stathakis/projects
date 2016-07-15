<?php 

namespace frontend\packages;

use yii\web\AssetBundle;

class BootstrapDatePickerAsset  extends AssetBundle 
{
	
	public $basePath = '@webroot';
    	public $baseUrl = '@web';
	public $css = [
		
	]; 
	public $js = [
		'js/app/bootstrap-datepicker.js',
		
	]; 
	public $depends =[
		'yii\web\YiiAsset', 
		'yii\bootstrap\BootstrapAsset',
		'common\packages\AppJsAsset',
		
	]; 


} 
