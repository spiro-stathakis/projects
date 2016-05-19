<?php 

namespace frontend\packages;

use yii\web\AssetBundle;

class DatePickerAsset  extends AssetBundle 
{
	
	public $basePath = '@webroot';
    	public $baseUrl = '@web';
	public $css = [
		'css/bootstrap-datetimepicker.min.css'
	]; 
	public $js = [
		'js/app/bootstrap-datetimepicker.min.js',
		
	]; 
	public $depends =[
		'yii\web\YiiAsset', 
		'yii\bootstrap\BootstrapAsset',
		'frontend\packages\AppJsAsset',
		'frontend\packages\MomentJsAsset'
	]; 


} 
