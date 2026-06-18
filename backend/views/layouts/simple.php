<?php
use frontend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;

AppAsset::register($this);
$this->beginPage()
?>	


<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="<?= Yii::getAlias('@raizweb').'/images/icons/favicon.png'?>"/>
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
        <style>
            @font-face {
                font-family: 'product-sans';
                src: url('<?= Yii::getAlias('@web')?>/css/fonts/product-sans/ProductSans-Regular.ttf');
            }
            body{
                font-family: 'product-sans', Arial, monospace;
                background: url(<?= Yii::getAlias('@web').'/images/login/fondo.png'?>) no-repeat center center fixed; 
                -webkit-background-size: cover;
                -moz-background-size: cover;
                -o-background-size: cover;
                background-size: cover;
                height: 100vh;
                position: relative;
            }
            .display-block{
                display: block;
            }
            .display-hide{
                display: none;
            }
            .content-registro{
                width: <?= str_contains($_SERVER['REQUEST_URI'], '/site/') ? '30' : '25' ?>%;
                /* float: right;
                margin-top: 1%; */
                position: absolute;
                top: 50%;
                left: 78%;
                transform: translate(-50%, -50%);
                background: #fff;
                box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);
                border-radius: 6px;
            }
            .register-left {
                display: flex;
                flex-direction: column;
                color: #000;
                align-items: center;
                /* margin: 1rem 0; */
                /* justify-content: center; */
            }
            .register-left p {
                font-weight: 600;
                margin-top: 0;
                padding: 0;
                padding-left: 1rem;
                margin-bottom: 0;
            }
            .register-left img {
                margin-top: 0;
                margin-bottom: 0;
                width: 25%;
                -webkit-animation: none;
                animation: none;
                margin-bottom: 0;
            }
            .register-right{
                background: #fff;
            }
            .register .register-form {
                padding: 0;
                margin-top: 7%;
                /* text-align: center; */
            }
            .btnRegister {
                width: 70%;
                border-radius: 5px;
                padding: 0.5rem 2rem;
                margin: 1rem auto 2rem;
            }
            .copy{
                margin-top: 3rem;
            }
            /* @media screen and (min-width:768px) and (max-width: 991px){
                .content-registro {
                    width: 50%;
                }
            } */
            @media screen and (max-width: 1337px){
                .content-registro {
                    width: 80%;
                    position: relative;
                    top: 0;
                    left: 0;
                    transform: none;
                    margin-top: 1.5rem;
                }
                .container.register.content-registro {
                    /* float: initial;
                    width: 95%;
                    margin-top: 15%; */
                    /* padding: 2rem; */
                    /* margin-bottom: 2rem; */
                }
            }

            @media screen and (max-width: 540px){
                body { 
                    background: url(<?= Yii::getAlias('@web').'/images/login/fondo_movil.png'?>) no-repeat center center fixed; 
                }
                .content-registro {
                    width: 98%;
                }
            }
        </style>
    </head>
    <body>
    <?php $this->beginBody() ?>
    	<div class="container">
            <div class="container register content-registro px-5 pb-5">

                <div class="row">
                    <div class="col-12 mt-5 register-left">
                        <a href="<?= Url::to(["/"]) ?>"><img src="<?= Yii::getAlias('@raizweb').'/images/logo.png'?>" style="width: 140px;" alt="" class="d-block mb-2" /></a>
                        <div class="mt-5 text-center fs-5"><?= $this->params['pageTitle'] ?? '' ?></div>
                    </div>
                    <div class="col-md-12 register-right">
                        
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">

                             <div class="row d-flex justify-content-center my-4">
                                <!--- <?= yii\authclient\widgets\AuthChoice::widget([
                                    'baseAuthUrl' => ['site/auth-social'],
                                    'popupMode' => false,
                                    'options' => [ 'class' => 'd-flex justify-content-center' ]
                                ]); ?>
                                --->
                            
                                <?php $authChoice = yii\authclient\widgets\AuthChoice::begin([
                                    'baseAuthUrl' => ['site/auth-social'],
                                    'popupMode' => false,
                                    'options' => [ 'class' => 'd-flex justify-content-center flex-column' ]
                                ]); ?>
                                <?php foreach($authChoice->getClients() as $client):  ?>
                                    <?php if($client->getName() === 'google'): ?>
                                        <a href="<?= $authChoice->createClientUrl($client); ?>" class="btn btn-light d-flex justify-content-center align-items-center gap-3"> <span class="auth-icon google" style="margin: 0;"></span>Continuar con Google </a>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                                <?php yii\authclient\widgets\AuthChoice::end(); ?>
                            </div>
                            <hr class="mb-4">

                                <?= $content ?>

    	                    </div>	
                        </div>

                    </div>

                </div>
            </div>

        </div>

         <?= Yii::$app->RecoverPass->modal(); ?>

        <?php 
        $this->registerJS("
        
            $('#formUserName').on('keyup change',function(e){
                let usName = $(this).val();
                $.get('".Url::to(['checkusetaf'])."',{id:usName}, function(r){
                    if(r.status){
                        console.log('Usa AUTH');
                        $('.showCodeAuth').css({'display':'block'});
                        $('#formCodeAuth').attr('disabled',false);
                    }else{
                        console.log('NO Usa AUTH');

                        $('.showCodeAuth').css({'display':'none'});
                        $('#formCodeAuth').attr('disabled',true);
                    }
                })
            });
        
        ");
        
        ?>
    <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>