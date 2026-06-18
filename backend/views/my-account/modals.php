<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap5\Modal;
use yii\bootstrap5\ActiveForm;

?>
<?php 
Modal::begin([
            'title' => "Actualizar nombre",
            'id' => "change-name"
    ]);
   $form =  Activeform::begin(['id'=>"name-update", 'enableClientValidation' => true, 'enableAjaxValidation' => true]);
?>

        <div class="row">
            <div class="col-md-12">
                <?= $form->field($UserData,'Name')->textInput([]);?>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-md-12 d-flex justify-content-end">
                <?= Html::submitButton("Actualizar",['class'=>'btn', 'style' => 'background-color: var(--bg-bottom-primary); color: #fff;']);?>
            </div>
        </div>

<?php 
    Activeform::end();
Modal::end(); 
?>

<?php 
Modal::begin([
            'title' => "Actualizar email",
            'id' => "change-email"
    ]);
   $form =  Activeform::begin(['id'=>"email-update", 'enableClientValidation' => true, 'enableAjaxValidation' => true]);
?>

        <div class="row">
            <div class="col-md-12">
                <?= $form->field($UserData,'Email')->textInput(['type'=>'email']);?>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-md-12 d-flex justify-content-end">
                <?= Html::submitButton('Actualizar',['class'=>'btn', 'style' => 'background-color: var(--bg-bottom-primary); color: #fff;']);?>
            </div>
        </div>

<?php 
    Activeform::end();
Modal::end(); 
?>


<?php 
Modal::begin([
            'title' => "Actualizar número de teléfono",
            'id' => "change-number-phone"
    ]);
   $form =  Activeform::begin(['id'=>"phone-number-update"]);
?>

        <div class="row">
            <div class="col-md-12">
                <!-- 'pattern'=>"[0-9]{3} [0-9]{3} [0-9]{4}" -->
                <?= $form->field($UserData,'NumberPhone')->textInput(['type'=>'tel','id'=>'numberPhoneModal','placeholder'=>'1112223333', 'onkeypress' => "return /\d/.test(event.key)"]);?>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-md-12 d-flex justify-content-end">
                <?= Html::submitButton('Actualizar',['class'=>'btn', 'style' => 'background-color: var(--bg-bottom-primary); color: #fff;']);?>
            </div>
        </div>

<?php 
    Activeform::end();
Modal::end(); 
?>

<?php 
Modal::begin([
            'title' => "Actualizar nombre de usuario",
            'id' => "change-username"
    ]);
   $form =  Activeform::begin(['id'=>"username-update",'enableClientValidation' => true, 'enableAjaxValidation' => true]);
?>

        <div class="row">
            <div class="col-md-12">
                <?= $form->field($UserData,'UserName')->textInput([]);?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                Avatar
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 d-flex align-items-center gap-3 mb-4">
                    <img src="<?= Url::to('@raizweb');?>/images/profile/avatar1.png" alt="" style="height:60px;" class="rounded-circle">
                    <?= $form->field($UserData,'PhotoUrl')->radio(['label'=>'','id'=>'1av','value' =>'avatar1.png', 'uncheck' => null]); ?>
            </div>
            <div class="col-md-4 d-flex align-items-center gap-3 mb-4">
                <img src="<?= Url::to('@raizweb');?>/images/profile/avatar2.png" alt="" style="height:60px;" class="rounded-circle">
                <?= $form->field($UserData,'PhotoUrl')->radio(['label'=>'','id'=>'2av','value' =>'avatar2.png', 'uncheck' => null]); ?>
            </div>
            <div class="col-md-4 d-flex align-items-center gap-3 mb-4">
                <img src="<?= Url::to('@raizweb');?>/images/profile/avatar3.png" alt="" style="height:60px;" class="rounded-circle">
                <?= $form->field($UserData,'PhotoUrl')->radio(['label'=>'','id'=>'3av','value' =>'avatar3.png', 'uncheck' => null]); ?>
            </div>
            <div class="col-md-4 d-flex align-items-center gap-3 mb-4">
                <img src="<?= Url::to('@raizweb');?>/images/profile/avatar4.png" alt="" style="height:60px;" class="rounded-circle">
                <?= $form->field($UserData,'PhotoUrl')->radio(['label'=>'','id'=>'4av','value' =>'avatar4.png', 'uncheck' => null]); ?>
            </div>
            <div class="col-md-4 d-flex align-items-center gap-3 mb-4">
                <img src="<?= Url::to('@raizweb');?>/images/profile/avatar5.png" alt="" style="height:60px;" class="rounded-circle">
                <?= $form->field($UserData,'PhotoUrl')->radio(['label'=>'','id'=>'5av','value' =>'avatar5.png', 'uncheck' => null]); ?>
            </div>
            <div class="col-md-4 d-flex align-items-center gap-3 mb-4">
                <img src="<?= Url::to('@raizweb');?>/images/profile/avatar6.png" alt="" style="height:60px;" class="rounded-circle">
                <?= $form->field($UserData,'PhotoUrl')->radio(['label'=>'','id'=>'6av','value' =>'avatar6.png', 'uncheck' => null]); ?>
            </div>
            <div class="col-md-4 d-flex align-items-center gap-3 mb-4">
                <img src="<?= Url::to('@raizweb');?>/images/profile/avatar7.png" alt="" style="height:60px;" class="rounded-circle">
                <?= $form->field($UserData,'PhotoUrl')->radio(['label'=>'','id'=>'7av','value' =>'avatar7.png', 'uncheck' => null]); ?>
            </div>
            <div class="col-md-4 d-flex align-items-center gap-3 mb-4">
                <img src="<?= Url::to('@raizweb');?>/images/profile/avatar8.png" alt="" style="height:60px;" class="rounded-circle">
                <?= $form->field($UserData,'PhotoUrl')->radio(['label'=>'','id'=>'8av','value' =>'avatar8.png', 'uncheck' => null]); ?>
            </div>
            <div class="col-md-4 d-flex align-items-center gap-3 mb-4">
                <img src="<?= Url::to('@raizweb');?>/images/profile/avatar9.png" alt="" style="height:60px;" class="rounded-circle">
                <?= $form->field($UserData,'PhotoUrl')->radio(['label'=>'','id'=>'9av','value' =>'avatar9.png', 'uncheck' => null]); ?>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-md-12 d-flex justify-content-end">
                <?= Html::submitButton('Actualizar',['class'=>'btn click-confirm', 'tittle-alert'=>'¿Esta seguro?' ,'text-alert'=>'se cerrara la session al cambiar el nombre de usuario', 'style' => 'background-color: var(--bg-bottom-primary); color: #fff;']);?>
            </div>
        </div>

<?php 
    Activeform::end();
Modal::end(); 
?>

<?php 
Modal::begin([
            'title' => "Actualizar contraseña",
            'id' => "change-password"
    ]);
   $form =  Activeform::begin(['id'=>"password-update",'enableClientValidation' => true, 'enableAjaxValidation' => true]);
?>

        <div class="row">
            <div class="col-md-12">
                <?= $form->field($UserData,'UserPassword')->textInput(['type'=>'password']);?>
            </div>
            <div class="col-md-12">
                <?= $form->field($UserData,'rUserPassword')->textInput(['type'=>'password']);?>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-md-12 d-flex justify-content-end">
                <?= Html::submitButton('Actualizar',['class'=>'btn', 'style' => 'background-color: var(--bg-bottom-primary); color: #fff;']);?>
            </div>
        </div>

<?php 
    Activeform::end();
Modal::end(); 
?>

<?php 
Modal::begin([
            'title' => "Actualizar país",
            'id' => "change-country"
    ]);
   $form =  Activeform::begin(['id'=>"country-update", 'enableClientValidation' => true, 'enableAjaxValidation' => true]);
?>

        <div class="row">
            <div class="col-md-12">
                <?= $form->field($UserData,'CountryID')->dropdownList(
                    ArrayHelper::map(\common\models\Countries::find()->all(), 'CountryID', 'Name'),
                    ['prompt'=>"Seleccione..."]);?>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-md-12 d-flex justify-content-end">
                <?= Html::submitButton( "Actualizar",['class'=>'btn', 'style' => 'background-color: var(--bg-bottom-primary); color: #fff;']);?>
            </div>
        </div>

<?php 
    Activeform::end();
Modal::end(); 
?>


<?php 
Modal::begin([
            'title' => "Actualizar dirección",
            'id' => "change-address"
    ]);
   $form =  Activeform::begin(['id'=>"address-update"]);
?>

        <div class="row">
            <div class="col-md-12">
                <?= $form->field($UserData,'Address')->textarea([]);?>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-md-12 d-flex justify-content-end">
                <?= Html::submitButton('Actualizar',['class'=>'btn', 'style' => 'background-color: var(--bg-bottom-primary); color: #fff;']);?>
            </div>
        </div>

<?php 
    Activeform::end();
Modal::end(); 
?>

<?php 
Modal::begin([
            'title' => "Actualizar datos de facturación",
            'id' => "change-billing-info"
    ]);
   $form =  Activeform::begin(['id'=>"billinginfo-update"]);
?>

        <div class="row">
        <div class="col-md-6">
                <?= $form->field($BillingInfo,'Name')->textInput([]);?>
            </div><div class="col-md-6">
                <?= $form->field($BillingInfo,'NIT')->textInput([]);?>
            </div>
            <div class="col-md-12">
                <?= $form->field($BillingInfo,'Email')->textInput(['type'=>'email']);?>
            </div>
            <div class="col-md-12">
                <?= $form->field($BillingInfo,'Address')->textarea([]);?>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-md-12 d-flex justify-content-end">
                <?= Html::submitButton('Actualizar',['class'=>'btn', 'style' => 'background-color: var(--bg-bottom-primary); color: #fff;']);?>
            </div>
        </div>

<?php 
    Activeform::end();
Modal::end(); 
?>


<?php 
Modal::begin([
            'title' => "Activar Google 2AF",
            'id' => "change-thwofactor-auth"
    ]);
   $form =  Activeform::begin(['id'=>"twofactor-auth-update",'action'=>Url::to(['/my-account#nav-security'])]);
        if($UserData->TwoFactorActive == 0):
?>

            <div class="row">
                <div class="col-md-6 d-flex justify-content-center align-items-center" style="flex-direction:column;">
                    <img src="<?= $QR; ?>" />
                    <span style="font-size:12px">O ingresa la clave secreta en la app</span>
                    <span><?= $secrectTwoFactor; ?></span>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12 mb-3">
                        <label for="" class="form-label">Codigo del google 2AF</label>
                        <input type="number" required="true" class="form-control" name="TwoAuthFactor[code]">
                    </div>
                    <div class="col-md-12">
                        <label for="" class="form-label">Ingresa tu contraseña</label>
                        <input type="password" required="true" class="form-control" name="TwoAuthFactor[password]">
                        <input type="hidden" required="true" class="form-control" name="TwoAuthFactor[secrect]" value="<?= $secrectTwoFactor; ?>">
                    </div>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-md-12 d-flex justify-content-end">
                    <?= Html::submitButton('Activar',['class'=>'btn', 'style' => 'background-color: var(--bg-bottom-primary); color: #fff;']);?>
                </div>
            </div>
        <?php else: ?>

            <div class="row">
                <div class="col-md-12">
                    <label for="" class="form-label">Codigo del google 2AF</label>
                    <input type="number" required="true" class="form-control" name="TwoAuthFactor[code]">
                </div>
                <div class="col-md-12">
                    <label for="" class="form-label">Ingresa tu contraseña</label>
                    <input type="password" required="true" class="form-control" name="TwoAuthFactor[password]">
                    <input type="hidden" required="true" class="form-control" name="TwoAuthFactor[desactive]" value="dissable">
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-md-12 d-flex justify-content-end">
                    <?= Html::submitButton('Desactivar',['class'=>'btn btn-danger']);?>
                </div>
            </div>

<?php 
        endif;
    Activeform::end();
Modal::end(); 
?>



<?php
$this->registerJS('
/* $("#numberPhoneModal").on("keydown",function(evt){
    if (evt.ctrlKey) { return; }
    if (evt.key.length > 1) { return; }
    if (/[0-9.]/.test(evt.key)) { return; }
    evt.preventDefault();
});
$("#numberPhoneModal").on("keyup change",function(e){
    let digits = $(this).val().replace(/\D/g,"");
    const areaCode = digits.substring(0,3);
    const prefix = digits.substring(3,6);
    const suffix = digits.substring(6,10);
    let numPars = "";
    if(digits.length > 6) {numPars= `${areaCode} ${prefix} ${suffix}`;}
    else if(digits.length > 3) {numPars = `${areaCode} ${prefix}`;}
    else if(digits.length > 0) {numPars = `${areaCode}`;}

    $(this).val(numPars);
}); */
');