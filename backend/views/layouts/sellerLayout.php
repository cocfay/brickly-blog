<?php
use backend\assets\AppAssetTemplateNew;
use yii\helpers\Html;
use yii\helpers\Url;
AppAssetTemplateNew::register($this);
$UserData = Yii::$app->AccessControl->Verify([]);
?>	

<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="<?= Yii::getAlias("@web") ?>/images/favicon.png"/>
    <title><?= Html::encode($this->title) ?></title>
    <head>
        <?php $this->head() ?>
    </head>
    <?php $this->beginBody() ?>
    <body style="background: #fff;">
        <div class="position-relative">
            <img src="<?= Yii::getAlias("@web") . '/images/seller/banner.png' ?>" class="w-100 d-none d-lg-block" alt="banner">
            <img src="<?= Yii::getAlias("@web") . '/images/seller/banner_movil.png' ?>" class="w-100 d-block d-lg-none" alt="banner">
            <div class="position-absolute top-0 start-0 w-100 h-100">
                <div class="row mx-0 h-100">
                    <div class="col-4"></div>
                    <div class="col-8 fw-bold text-white d-flex justify-content-start align-items-center">
                        <div>
                            <div class="text-center text-uppercase" style="font-size: clamp(16px, 3.5vw, 42px)">¿Eres un vendedor freelance excepcional?</div>
                            <div class="text-uppercase text-center mt-3 mt-lg-0" style="font-size: clamp(14px, 3vw, 34px)">¡queremos conocerte!</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container my-5">
            <?= $content;  ?>     
        </div>   
    </body>
    <?php $this->endBody() ?>
</html>
<?php $this->endPage() ?>