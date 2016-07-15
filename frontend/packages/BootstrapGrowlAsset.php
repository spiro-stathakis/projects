<?php 

namespace frontend\packages;

use yii\web\AssetBundle;

class BootstrapGrowlAsset  extends AssetBundle 
{
	
	public $basePath = '@webroot';
    public $baseUrl = '@web';
	public $css = [
	]; 
	public $js = [
		'js/app/bootstrap-growl.js'
	]; 
	public $depends =[
		'yii\web\YiiAsset', 
		'yii\bootstrap\BootstrapAsset',
		'common\packages\AppJsAsset',
	]; 


} 
