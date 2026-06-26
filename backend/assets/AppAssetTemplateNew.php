<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAssetTemplateNew extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'js/sweetalert-master/dist_f/sweetalert.css',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css',
        'css/cpanel-modern.css'
    ];
    public $js = [
        'js/sweetalert-master/dist_f/sweetalert.min.js',
        'js_util/alerts.js',
        'https://code.jquery.com/ui/1.14.1/jquery-ui.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\web\JqueryAsset',
        'yii\bootstrap5\BootstrapAsset',
        'yii\bootstrap5\BootstrapPluginAsset'
    ];
}
