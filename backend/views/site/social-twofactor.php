<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
$this->title = 'Bienvenido';
?>

<style type="text/css">
    body { 
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
        width: 30%;
        float: right;
        margin-top: 10%;
        background: #fff;
        box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);
        border-radius: 6px;
    }
    .register-left {
        display: flex;
        flex-direction: column;
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
    @media screen and (min-width:768px) and (max-width: 991px){
        .content-registro {
            width: 50%;
        }
    }
    @media screen and (max-width: 767px){
        body { 
            background: url(<?= Yii::getAlias('@web').'/images/login/fondo_movil.png'?>) no-repeat center center fixed; 
        }
        .container.register.content-registro {
            float: initial;
            width: 95%;
            margin-top: 15%;
            padding: 2rem;
            margin-bottom: 2rem;
        }
    }
</style>
<div class="container register content-registro px-5 pb-5">

    <div class="row">
        <div class="col-12 mt-5 register-left">
            <img src="<?= Yii::getAlias('@raizweb').'/images/logo.png'?>" style="width: 140px;" alt="" class="d-block mb-2" />
            <div class="mt-5 text-center fs-5">Verificación de 2 pasos</div>
            <!-- <input type="submit" name="" value="Login"/><br/> -->
        </div>
        <div class="col-md-12 register-right">
            
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data','id' => 'leadform',]]); ?>
                    <div class="row register-form">
                            <div class="col-12 mb-3">
                                <?= $form->field($loginModel, 'username', [
                                    'template' => '
                                    <label class="form-label text-start">Usuario</label>
                                    <div class="position-relative">
                                        <i class="fa-solid fa-user me-1 position-absolute top-50 start-0 translate-middle ms-3" style="color: #7C29F0;"></i>
                                        {input}
                                    </div>
                                    {error}{hint}
                                    ',
                                    'inputOptions' => [
                                        'maxlength' => true,
                                        'style' => 'padding-left: 35px;',
                                        'class' => 'form-control w-100',
                                        'id' => 'formUserName',
                                        'autocomplete' => 'off',
                                        'readonly' =>true
                                    ],
                                   
                                ])->label(false); ?>
                            </div>
                            <div class="col-12">
                                <div class="form-group showCodeAuth mt-2" style="display:block;">
                                    <?= $form->field($loginModel, 'twoFactorAuthCode')->textInput(['type' => 'number','class'=>'form-control','id'=>'formCodeAuth']); ?>
                                </div>
                            </div>
                            <div class="col-12 mt-3 mb-4">
                                <div class="row d-flex justify-content-center">
                                    <?= Html::submitButton('INGRESAR', ['class' => 'btn py-2 mt-3', 'style' => 'width: fit-content; background: #FF004D; color: #fff; padding: 0 6rem; font-size: 14px; border-radius: 4px;', 'name' => 'login-button']); ?>
                                </div>
                                
                            </div>
                           
                    </div>
                    <?php ActiveForm::end(); ?>
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