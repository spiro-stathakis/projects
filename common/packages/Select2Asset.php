<?php 

namespace common\packages;

use yii\web\AssetBundle;

class Select2Asset  extends AssetBundle 
{
	
	public $sourcePath = '@common/web';
	public $css = [
		'css/select2.css'
	]; 
	public $js = [
		'js/select2.full.js',
		'js/app/select2.js'
	]; 
	public $depends =[
		'yii\web\YiiAsset', 
		'common\packages\AppJsAsset',
	]; 


} 
