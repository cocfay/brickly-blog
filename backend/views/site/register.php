<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap5\Button;
use yii\bootstrap5\ActiveForm;
/*$this->title = 'Registro';*/
?>

<style type="text/css">
    body { 
      /* background: url(<?= Yii::getAlias('@web').'/images/bg.jpg'?>) no-repeat center center fixed;  */
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
        width: 90%;
        height: 87%;
        margin-top: 10%;
        background: #fff;
        box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);
    }
    .register-left {
        display: flex;
        flex-direction: row;
        color: #000;
        align-items: center;
        margin: 1rem 0;
        justify-content: center;
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
        width: 50%;
        -webkit-animation: none;
        animation: none;
        margin-bottom: 0;
    }
    .register-right{
        background: #fff;
    }
    .register .register-form {
        padding: 0;
        margin-top: 10%;
        text-align: center;
    }
    .btnRegister {
        width: 70%;
        border-radius: 5px;
        padding: 0.5rem 2rem;
        margin: 1rem auto 2rem;
        background-color: #000000;
        color:#fff;
    }
    .copy{
        margin-top: 2rem;
    }
     .img{
        width: 62.2%;
        height: 100%;
        float: right;
    }
    .com{
        float: left;
        height: 100%;
        width: 37%;
    }
    @media screen and (min-width:768px) and (max-width: 991px){
        .content-registro {
            width: 50%;
        }
    }
    @media screen and (max-width: 767px){
        .container.register.content-registro {
            float: initial;
            width: 95%;
            margin-top: 25%;
            padding: 2rem;
            margin-bottom: 2rem;
        }
    }
</style>
    <div class="container register content-registro">
        <div class="com">
            <div class="row">
                <div class="col-md-12 register-left"> 
                    <img src="<?= Yii::getAlias('@web').'/images//Iconos-tiquetas/LogoTemporal.png'?>" alt=""/ onClick='return test()'>
                    <!-- <p><?= $NameProyectLG; ?></p> -->
                    <!-- <input type="submit" name="" value="Login"/><br/> -->
                </div>
            </div>
            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data','id' => 'leadform']]); ?>
            <div class="row">
                <div class="col-md-12">
                    <?= $form->field($model, 'UserName')->textInput(['maxlength' => true,'class'=>'form-control','placeholder'=>"Correo Electrónico"])->label(false); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <?= $form->field($model, 'Password')->passwordInput(['maxlength' => true,'class'=>'form-control','placeholder'=>"Contraseña"])->label(false); ?> 
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="row" style="display: flex; flex-direction: column;">
                        <?= Html::submitButton('Ingresar', ['class' => 'btnRegister', 'name' => 'login-button']); ?>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="alert alert-danger <?= $model->getErrors()? 'display-block' :'display-hide' ; ?> ">
                        <button class="close" data-close="alert"></button>
                        <span><?= $model->getErrors()? $model->getErrors('error')[0] :'' ; ?> </span>
                    </div>
                    <div style="width:100%;display:flex;justify-content:center">
                        <?= $form->field($model, 'RememberMe')->checkbox(); ?>
                    </div>
                    <br>
                    <div class="col-md-12">
                        <center>
                            <div class="fb-login-button" data-width="500" data-size="large" data-button-type="login_with" data-layout="default" data-auto-logout-link="false" data-use-continue-as="true" data-scope="public_profile" onlogin="checkLoginState();"></div>
                        </center>
                    </div>
                    <div class="col-md-12">
                        <center>
                            <div id="googlesesion" style="margin-top:10px"></div> 
                        </center>
                    </div>
                    <br>
                    <div style="text-align:center">
                        ¿Aún no tienes una cuenta? <a href="<?=Yii::getAlias('@web'); ?>/users/register">Regístrate Aquí</a>
                    </div>
                    <p class="copy" style="text-align:center">2022 © Copyright.</p>
                </div>
            </div>
        </div>
        <div class="img">
            <img src="<?= Yii::getAlias('@web').'/images//Fotos/Imagen login pop up.png'?>">
        </div>
            <?php ActiveForm::end(); ?>
            
            
            <?php $form = ActiveForm::begin(['action' =>['login'], 'id' => 'leadform1', 'method' => 'post']); ?>

            <?= $form->field($model, 'Email')->hiddeninput(['id'=>'formemail'])->label(false); ?>

            <?= $form->field($model, 'Name')->hiddeninput(['id'=>'formname'])->label(false); ?>

            <?= $form->field($model, 'Method')->hiddeninput(['id'=>'formmethod', 'value' => 1])->label(false);?>

            <?php ActiveForm::end(); ?>
    </div>

</div>