<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap5\ActiveForm;
$this->title = 'Regístarse';
$this->params['pageTitle'] = 'CREA UNA CUENTA';
?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data','id' => 'leadform',]]); ?>
    <div class="row register-form">
        <div class="row px-0 mx-0">
            <div class="col-lg-6 mb-2 mb-lg-0">
                <?= $form->field($model, 'Name')->textInput()->label('Nombre*'); ?>
            </div>
            <div class="col-lg-6">
                <?= $form->field($model, 'UserName')->textInput()->label('Nombre de usuario*'); ?>
            </div>
        </div>
        <div class="col-12">
            <?= $form->field($model, 'Email')->textInput()->label('Correo electrónico*'); ?>
        </div>
        <div class="row px-0 mx-0">
            <div class="col-lg-6 mb-2 mb-lg-0">
                <?= $form->field($model, 'UserPassword')->passwordInput()->label('Contraseña*'); ?>
            </div>
            <div class="col-lg-6">
                <?= $form->field($model, 'rUserPassword')->passwordInput()->label('Repetir contraseña*'); ?>
            </div>
        </div>
        <div class="row px-0 mx-0">
            <div class="col-lg-6 mb-2 mb-lg-0">
                <?= $form->field($model, 'CountryID', ['labelOptions' => ['data-section' => '', 'data-value' => '']])->dropDownList($contryList, ['class' => 'w-100 form-select', 'options' => [$countryCode => ['Selected' => true]]]) ?>
            </div>
            <div class="col-lg-6">
                <?= $form->field($model, 'NumberPhone')->input('number')->label('Teléfono*'); ?>
            </div>
        </div>
        <div class="col-12 mt-3">
            <div class="row d-flex justify-content-center">
                <?= Html::submitButton('REGISTRAR', ['class' => 'btn py-2 mt-3', 'style' => 'width: fit-content; background: #FF004D; color: #fff; padding: 0 6rem; font-size: 14px; border-radius: 4px;', 'name' => 'signup-button']); ?>
            </div>
        </div>
    </div>
<?php ActiveForm::end(); ?>