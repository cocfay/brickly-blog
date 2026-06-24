<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAssetReset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'https://cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/alertify.min.css',
        'https://cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/themes/bootstrap.min.css',
    ];
    public $js = [
        'https://www.google.com/recaptcha/api.js?render=6LeKNtcqAAAAAKoOTJiylGVGWAq-jRLrj5lGnmrW',
        'https://kit.fontawesome.com/5d79548a92.js',
        'https://cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/alertify.min.js',
        'js/credits.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
    ];

    /* public function init() { parent::init(); // Desregistrar jQuery 
    \Yii::$app->assetManager->bundles['yii\web\JqueryAsset'] = false; } */

}
