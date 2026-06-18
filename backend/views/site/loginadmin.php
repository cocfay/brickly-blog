<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap5\ActiveForm;
$this->title = 'Iniciar Sesión';
$this->params['pageTitle'] = 'INICIAR SESIÓN';
?>


<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data','id' => 'leadform',]]); ?>
    <div class="row register-form">
        <div class="col-12">
            <?= $form->field($model, 'username', [
                'template' => '
                <label class="form-label text-start">Usuario o correo electrónico</label>
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
                    'autocomplete' => 'off'
                ],
            ])->label(false); ?>
        </div>
        <div class="col-12 mb-3">
            <?= $form->field($model, 'password', [
                'template' => '
                <label class="form-label text-start">Contraseña</label>
                <div class="position-relative">
                    <i class="fa-solid fa-lock me-1 position-absolute top-50 start-0 translate-middle ms-3" style="color: #7C29F0;"></i>
                    {input}
                </div>
                {error}{hint}
                ',
                'inputOptions' => [
                    'type' => 'password',
                    'maxlength' => true,
                    'style' => 'padding-left: 35px;',
                    'class' => 'form-control w-100',
                    'autocomplete' => 'off'
                ],
            ])->label(false); ?> 
        </div>
        <div class="col-12 mt-2">
            <div class="form-group showCodeAuth" style="display:<?= ($model->showTAF == 1)? 'block': 'none'; ?>;">
                <?= $form->field($model, 'twoFactorAuthCode')->textInput(['type' => 'number','class'=>'form-control','id'=>'formCodeAuth','disabled'=>($model->showTAF == 1)? false : true ]); ?>
            </div>
        </div>
        <div class="col-12 mb-3">
            <div class="row d-flex justify-content-center">
                <?= Html::submitButton('INGRESAR', ['class' => 'btn py-2 mt-3', 'style' => 'width: fit-content; background: #FF004D; color: #fff; padding: 0 6rem; font-size: 14px; border-radius: 4px;', 'name' => 'login-button']); ?>
            </div>
        </div>
        <?php $visible = false; if($visible): ?>
        <div class="col-md-12">
            <div class="alert alert-danger <?= $model->getErrors()? 'display-block' :'display-hide' ; ?> ">
                <span><?= $model->getErrors()? $model->getErrors('error')[0] :'' ; ?> </span>
            </div>
            <?= $form->field($model, 'rememberMe')->checkbox(); ?>
            <br>
            <?= Yii::$app->RecoverPass->toRecoverPass(); ?>
            <p class="copy"><?= date('Y'); ?> © Copyright.</p>
        </div>
        <?php endif ?>
        <div class="mt-3 text-center">¿Todavía no tienes cuenta? <a href="<?= Url::to(['signup']) ?>" class="text-decoration-none" style="color: #FF004D">Regístrate</a></div>
    </div>
<?php ActiveForm::end(); ?>
            
