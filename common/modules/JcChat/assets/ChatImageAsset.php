<?php

    namespace common\modules\JcChat\assets;

    use yii\web\AssetBundle;

    class ChatImageAsset extends AssetBundle
    {

        public $sourcePath = '@common/modules/JcChat/images'; // Path to your module's assets
        public $baseUrl = '@web/assets'; // Base URL for published assets
        public $css = [];
        public $js = [];
         public $publishOptions = [
            'forceCopy' => YII_ENV_DEV, // Set to true in development for easier updates
        ];
        public $depends = [
            'yii\web\YiiAsset',
        ];


    }