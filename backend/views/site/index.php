<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap5\ActiveForm;
$this->title = 'Inicio de Sesión';
?>

<style type="text/css">
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
    }
    .display-block{
        display: block;
    }
    .display-hide{
        display: none;
    }
    .content-registro{
        width: 25%;
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
<div class="container register content-registro px-4">
    <div class="row">
        <div class="col-12 mt-5 register-left mb-4">
            <img src="https://www.weclickdigital.com/images/logo.png" style="width: 140px;" alt="" class="d-block mb-2" alt="logo"/>
            <div class="mt-3">Panel Administrativo</div>
            <!-- <input type="submit" name="" value="Login"/><br/> -->
        </div>
        <div class="col-md-12 register-right">
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data','id' => 'leadform',]]); ?>
                    <div class="row register-form">
                        <div class="col-md-12">
                            <div class="form-group">
                                <?= $form->field($model, 'username')->textInput(['maxlength' => true, 'class'=>'form-control',])->label('Usuario o Correo Electrónico'); ?>
                            </div>
                            <div class="form-group">
                                <?= $form->field($model, 'password')->passwordInput(['maxlength' => true, 'class'=>'form-control'])->label('Contraseña'); ?> 
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row" style="display: flex; flex-direction: column;">
                                <?= Html::submitButton('INGRESAR', ['class' => 'btn py-2 mt-3 btnRegister', 'name' => 'login-button', 'style' => 'width: fit-content; background: #FF004D; color: #fff; padding: 0 6rem; font-size: 14px; border-radius: 4px;']); ?>
                            </div>
                        </div>
                        <div class="col-md-12 d-flex justify-content-center">
                            <!-- <div class="alert alert-danger <?= $model->getErrors()? 'display-block' :'display-hide' ; ?> ">
                                <button class="close" data-close="alert"></button>
                                <span><?= $model->getErrors()? $model->getErrors('error')[0] :'' ; ?> </span>
                            </div>
                            <?= $form->field($model, 'rememberMe')->checkbox(); ?>
                            <br>
                            <?= Yii::$app->RecoverPass->toRecoverPass(); ?> -->
                            <p class="copy"><?= date('Y'); ?> © Copyright</p>
                        </div>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

 <?= Yii::$app->RecoverPass->modal(); ?>