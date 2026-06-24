<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap5\ActiveForm;
use common\components\chosen\Chosen;

$this->title = 'Usuarios';
$isNewRecord = $ModelAccount->isNewRecord;
$backUrl = $UserData->TypeUser == 2 ? Url::to('/my-account#nav-users') : Url::to(['/usuario']);
$avatars = [
    'avatar1.png',
    'avatar2.png',
    'avatar3.png',
    'avatar4.png',
    'avatar5.png',
    'avatar6.png',
    'avatar7.png',
    'avatar8.png',
    'avatar9.png',
];
?>

<div class="container-fluid px-0 cpanel-form-page cpanel-user-form-page">
    <div class="cpanel-page-heading">
        <div>
            <h1><?= $isNewRecord ? 'Crear usuario' : 'Actualizar usuario'; ?></h1>
            <p class="cpanel-page-subtitle">Configura el acceso, datos personales y avatar del nuevo usuario.</p>
        </div>
        <a href="<?= $backUrl ?>" class="cpanel-back-link" title="Atr&aacute;s">
            <i class="fa-solid fa-arrow-left"></i> Atr&aacute;s
        </a>
    </div>

    <div class="cpanel-form-shell">
        <?php $form = ActiveForm::begin(['id' => 'form-user', 'method' => 'post', 'enableClientValidation' => true, 'enableAjaxValidation' => true]) ?>

        <div class="cpanel-form-section">
            <div class="cpanel-section-heading">
                <span class="cpanel-section-icon"><i class="fa-solid fa-lock"></i></span>
                <div class="cpanel-section-copy">
                    <h2 class="cpanel-section-title">Datos de acceso</h2>
                    <p>Define las credenciales y el tipo de cuenta</p>
                </div>
                <span class="cpanel-section-line"></span>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="cpanel-icon-field">
                        <i class="fa-regular fa-user"></i>
                        <?= $form->field($ModelUserAccount, 'UserName')->textInput(['maxlength' => true]); ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="cpanel-icon-field">
                        <i class="fa-solid fa-lock"></i>
                        <?= $form->field($ModelUserAccount, 'UserPassword')->passwordInput(['maxlength' => true]); ?>
                        <span class="cpanel-field-action-icon"><i class="fa-regular fa-eye"></i></span>
                    </div>
                </div>
                <?php if ($UserData->TypeUser == 1): ?>
                    <div class="col-md-4">
                        <?= $form->field($ModelUserAccount, 'TypeUser')->dropDownList($aTypeUsers, ['class' => 'typemenu form-control']) ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="cpanel-form-section">
            <div class="cpanel-section-heading">
                <span class="cpanel-section-icon"><i class="fa-regular fa-user"></i></span>
                <div class="cpanel-section-copy">
                    <h2 class="cpanel-section-title">Informaci&oacute;n personal</h2>
                    <p>Completa los datos personales del usuario</p>
                </div>
                <span class="cpanel-section-line"></span>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="cpanel-icon-field">
                        <i class="fa-regular fa-user"></i>
                        <?= $form->field($ModelUserAccount, 'Name')->textInput(['maxlength' => true]); ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="cpanel-icon-field">
                        <i class="fa-regular fa-envelope"></i>
                        <?= $form->field($ModelUserAccount, 'Email')->textInput(['type' => 'email', 'maxlength' => true]); ?>
                    </div>
                </div>
                <?php if ($UserData->TypeUser !== 2): ?>
                    <div class="col-md-4">
                        <?= $form->field($ModelByRole, 'RoleID')->widget(Chosen::classname(), [
                            'items' => $ItemsRole,
                            'allowDeselect' => true,
                            'disableSearch' => true,
                            'clientOptions' => [
                                'search_contains' => true,
                                'max_selected_options' => 2,
                            ],
                            'options' => [
                                'multiple' => true,
                                'data-placeholder' => 'Seleccione alguna opcion',
                            ],
                        ])->label('Rol'); ?>
                    </div>
                <?php else: ?>
                    <?= $form->field($ModelByRole, 'RoleID')->hiddenInput(['value' => 19])->label(false) ?>
                <?php endif ?>
            </div>
        </div>

        <div class="cpanel-form-section">
            <div class="cpanel-section-heading">
                <span class="cpanel-section-icon"><i class="fa-regular fa-face-smile"></i></span>
                <div class="cpanel-section-copy">
                    <h2 class="cpanel-section-title">Avatar</h2>
                    <p>Selecciona el avatar que representar&aacute; al usuario</p>
                </div>
                <span class="cpanel-section-line"></span>
            </div>
            <div class="cpanel-avatar-grid">
                <?php foreach ($avatars as $avatarIndex => $avatar): ?>
                    <label class="cpanel-avatar-option" for="user-avatar-<?= $avatarIndex ?>">
                        <img src="<?= Url::to('@raizweb'); ?>/images/profile/<?= $avatar ?>" alt="" class="rounded-circle">
                        <?= Html::activeRadio($ModelUserAccount, 'PhotoUrl', [
                            'id' => 'user-avatar-'.$avatarIndex,
                            'label' => false,
                            'value' => $avatar,
                            'uncheck' => null,
                        ]); ?>
                    </label>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="cpanel-form-actions">
            <?= Html::submitButton($isNewRecord ? '<i class="fa-solid fa-user-plus"></i> Crear nuevo usuario' : '<i class="fa-solid fa-floppy-disk"></i> Actualizar usuario', [
                'class' => 'btn btn-primary click-confirm',
                'tittle-alert' => $isNewRecord ? 'Crear usuario' : 'Actualizar usuario',
                'text-alert' => $isNewRecord ? 'Crear un nuevo usuario. Desea continuar?' : 'Actualizar usuario ['.$ModelUserAccount->UserName.']. Deseas continuar?',
            ]) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>

<?php
if (Yii::$app->session->hasFlash('success')):
    $this->registerJS('
        $(document).ready(function(){
            _Message("success","Exito","'.Yii::$app->session->getFlash('success').'");
        });
    ');
endif;

if (Yii::$app->session->hasFlash('error')):
    $this->registerJS('
        $(document).ready(function(){
            _Message("error","Error","'.Yii::$app->session->getFlash('error').'");
        });
    ');
endif;
?>
