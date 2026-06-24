<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap5\ActiveForm;

date_default_timezone_set('America/Guatemala');
$ActualDate = new \DateTime();

$this->registerCss('
    .mycard-summary{
        background: var(--mycard-bg); 
        width: min(600px, 100%);
        border-radius: 4px;
        color: var(--bs-dark);
    }
    .mycard-summary .list{
        margin-top: 0.6rem;
        padding-bottom: 0.6rem;
        border-bottom: 1.2px solid var(--bs-highlight-color);
    }
    .mycard-summary a{
        cursor: pointer;
    }
    .mycard-summary button{
        color: var(--bs-dark);
    }
    .mycard-summary button i{
        color: var(--mycard-color-a);
    }
');
?>

<div class="d-flex flex-column flex-lg-row mt-4 gap-5">
    <div class="mycard-summary pt-3 pb-4 px-4">
        <div class="mb-4 fs-4">Datos de la cuenta</div>
        <div class="d-flex justify-content-between align-items-center list">
            <div class="d-flex align-items-center gap-2">
                <i class="fa fa-user" style="color: #4A4187"></i>
                <?= $UserData->Name ?? 'Nombre completo'; ?>
            </div>
            <div>
                <button class="btn btn-small" onClick="$('#change-name').modal('show');">Editar <i class="ms-2 fa fa-edit"></i></button>
            </div>
        </div>
        <div class="d-flex justify-content-between align-items-center list">
            <div class="d-flex align-items-center gap-2">
                <i class="fa fa-envelope" style="color: #4A4187"></i>
                <?= $UserData->Email ?? 'Correo electrónico'; ?>
            </div>
            <div>
                <button class="btn btn-small" onClick="$('#change-email').modal('show');">Editar <i class="ms-2 fa fa-edit"></i></button>
            </div>
        </div>
        <div class="d-flex justify-content-between align-items-center list">
            <div class="d-flex align-items-center gap-2">
                <i class="fa fa-mobile" style="color: #4A4187"></i>
                <?= $UserData->NumberPhone ?? 'Teléfono'; ?>
            </div>
            <div>
                <button class="btn btn-small" onClick="$('#change-number-phone').modal('show');">Editar <i class="ms-2 fa fa-edit"></i></button>
            </div>
        </div>
        <div class="d-flex justify-content-between align-items-center list">
            <div class="d-flex align-items-center gap-2">
                <i class="fa fa-earth-americas" style="color: #4A4187"></i>
                <?= $UserData->country->Name ?? 'País'; ?>
            </div>
            <div>
                <button class="btn btn-small" onClick="$('#change-country').modal('show');">Editar <i class="ms-2 fa fa-edit"></i></button>
            </div>
        </div>
    </div>

    <div class="mycard-summary pt-3 pb-4 px-4">
        <div class="mb-4 fs-4">Datos de facturación</div>
        <div class="d-flex justify-content-end align-items-center">
            <button class="btn btn-small" onClick="$('#change-billing-info').modal('show');">Editar <i class="ms-2 fa fa-edit"></i></button>
        </div>
        <div class="d-flex justify-content-between align-items-center list mt-0">
            <div class="d-flex align-items-center gap-2">
                <i class="fa fa-user" style="color: #4A4187"></i>
                <?= isset($UserData->billingInfo->Name) ? $UserData->billingInfo->Name : 'Nombre'; ?>
            </div>
        </div>
        <div class="d-flex justify-content-between align-items-center list">
            <div class="d-flex align-items-center gap-2">
                <i class="fa fa-id-card" style="color: #4A4187"></i>
                <?= isset($UserData->billingInfo->NIT) ? $UserData->billingInfo->NIT : 'NIT'; ?>
            </div>
        </div>
        <div class="d-flex justify-content-between align-items-center list">
            <div class="d-flex align-items-center gap-2">
                <i class="fa fa-envelope" style="color: #4A4187"></i>
                <?= isset($UserData->billingInfo->Email) ? $UserData->billingInfo->Email : 'Correo electónico'; ?>
            </div>
        </div>
        <div class="d-flex justify-content-between align-items-center list">
            <div class="d-flex align-items-center gap-2">
                <i class="fa fa-house-chimney-user" style="color: #4A4187"></i>
                <?= isset($UserData->billingInfo->Address) ? $UserData->billingInfo->Address : 'Dirección'; ?>
            </div>
        </div>
    </div>
</div>
<div class="d-flex gap-5 flex-column flex-lg-row mt-5">

    <div class="mycard-summary pt-3 pb-4 px-4">
        <div class="mb-4 fs-4">Datos de la cuenta</div>
        <div class="d-flex justify-content-between align-items-center list">
            <div class="d-flex align-items-center gap-2">
                <i class="fa fa-user" style="color: #4A4187"></i>
                <?= $UserData->UserName;?> <img src="<?= Url::to('@raizweb');?>/images/profile/<?=  $UserData->PhotoUrl; ?>" alt="" style="height:25px; margin-left:10px;" class="rounded-circle">
            </div>
            <div>
                <button class="btn btn-small" onClick="$('#change-username').modal('show');">Editar <i class="ms-2 fa fa-edit"></i></button>
            </div>
        </div>
        <div class="d-flex justify-content-between align-items-center list">
            <div class="d-flex align-items-center gap-2">
                <i class="fa-solid fa-lock" style="color: #4A4187"></i>
                xxxxxxxxxxx
            </div>
            <div>
                <button class="btn btn-small" onClick="$('#change-password').modal('show');">Editar <i class="ms-2 fa fa-edit"></i></button>
            </div>
        </div>
    </div>

    <div class="mycard-summary pt-3 pb-4 px-4">
        <div class="mb-4 fs-4">Logo de la compañia</div>
        <?php $form = ActiveForm::begin(['options' => ['class' => 'form-img']]) ?>
        <div class="mt-4 position-relative" style="width: 120px;">
            <img src="<?= !is_null($UserData->ImgCompany) ? Yii::getAlias('@web') .'/images/'. $UserData->ImgCompany : 'https://cdn.pixabay.com/photo/2016/01/03/00/43/upload-1118929_1280.png' ?>" alt="logo compañia" srcset="" style="width: 120px; object-fit: cover;">
            <?= $form->field($UserData, 'ImgCompany')->fileInput(['class' => 'form-control imgCompany position-absolute w-100 h-100 top-0 opacity-0'])->label(false) ?>
        </div>
        
        <!-- <button type="submit">enviar</button> -->
        <?php ActiveForm::end() ?>
    </div>
</div>

<?php
    $js = <<<JS
            const form = document.querySelector('.form-img')
            const imgC = document.querySelector('.imgCompany')
            imgC.addEventListener('change', (e) => {
                if(e.target.files[0]){
                    form.submit()
                }
            })
        
    JS;

    $this->registerJS($js);
?>
