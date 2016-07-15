<?php 

namespace common\packages;

use yii\web\AssetBundle;

class MomentJsAsset  extends AssetBundle 
{
	
	public $sourcePath = '@common/web';
	public $css = [
		
	]; 
	public $js = [
		'js/app/moment-with-locales.js',
		
	]; 
	public $depends =[
		'yii\web\YiiAsset', 
		'yii\bootstrap\BootstrapAsset',
		
		
	]; 


} 
