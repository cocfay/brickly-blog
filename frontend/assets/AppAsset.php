<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css',
        'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.css',
        'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.css',
        'https://cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/alertify.min.css',
        'https://cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/themes/bootstrap.min.css',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css',
        'https://unpkg.com/aos@2.3.1/dist/aos.css',
        'css/animaciones.css',
        'css/template/gap.css',
        'css/home.css',
        'css/porfolio.css',
        'css/site.css',
    ];
    public $js = [
        /* 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js', */
        'https://www.google.com/recaptcha/api.js?render=6LeKNtcqAAAAAKoOTJiylGVGWAq-jRLrj5lGnmrW',
        'https://kit.fontawesome.com/5d79548a92.js',
        'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.js',
        'https://cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/alertify.min.js',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js',
        //'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js',
        'https://unpkg.com/aos@2.3.1/dist/aos.js',
        'js/animaciones.js',
        'js/credits.js',
        'js/translate.js',
        //'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/js/bootstrap.bundle.min.js', // Añadir Bootstrap JS
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
    ];

    /* public function init() { parent::init(); // Desregistrar jQuery 
    \Yii::$app->assetManager->bundles['yii\web\JqueryAsset'] = false; } */

}
