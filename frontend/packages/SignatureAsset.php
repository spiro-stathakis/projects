<?php 

namespace frontend\packages;

use yii\web\AssetBundle;

class SignatureAsset  extends AssetBundle 
{
	
	public $basePath = '@webroot';
    public $baseUrl = '@web';
	public $css = [
		'css/signature-pad.css'
	]; 
	public $js = [
		'js/app/signature_pad.min.js',
		'js/app/signature.js'
	]; 
	public $depends =[
		'yii\web\YiiAsset', 
		'frontend\packages\AppJsAsset',
	]; 


} 
