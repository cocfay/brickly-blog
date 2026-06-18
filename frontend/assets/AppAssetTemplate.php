<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAssetTemplate extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css',
        'css/template/animate.min.css',
        'css/template/light-bootstrap-dashboard.css?v=2.0.0',
        'css/template/pe-icon-7-stroke.css',
        'css/template/demo.css',
        'js/sweetalert-master/dist_f/sweetalert.css',
    ];
    public $js = [
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js',
        /* 'js/template/core/popper.min.js',
        'js/template/core/bootstrap.min.js',
        'js/template/plugins/bootstrap-switch.js',
        'js/template/chartist.min.js',
        'js/template/bootstrap-notify.js', */
        'js/template/light-bootstrap-dashboard.js?v=2.0.0',
        'js/template/demo.js',
        'js/sweetalert-master/dist_f/sweetalert.min.js',
        'js_util/alerts.js',
        'js/comboBox/jquery.selectlistactions.js'

        
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
    ];
}
