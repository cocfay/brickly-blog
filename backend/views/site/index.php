<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Inicio de Sesión';
$web = Yii::getAlias('@web');
$logo = Yii::getAlias('@raizweb') . '/images/logos/logo_negro.png';
?>

<style>
    @font-face {
        font-family: 'Red Hat Display';
        src: url('../css/fonts/RedHatDisplay-VariableFont_wght.woff2') format('woff2'),
            url('../css/fonts/RedHatDisplay-VariableFont_wght.ttf') format('truetype');
        font-weight: 500 900;
        font-style: normal;
        font-display: swap;
    }


    body {
        font-family: 'Red Hat Display', Arial, sans-serif;
        background: #f5f6f8 !important;
        min-height: 100vh;
    }

    .display-block { display: block; }
    .display-hide { display: none; }

    .cpanel-login-shell {
        position: fixed;
        inset: 0;
        width: 100vw;
        min-height: 100vh;
        background:
            radial-gradient(circle at top left, rgba(17, 17, 17, .08), transparent 32rem),
            linear-gradient(135deg, #f7f8fa 0%, #ffffff 48%, #eef1f5 100%);
        overflow-y: auto;
        z-index: 1;
    }

    .cpanel-login-navbar {
        position: sticky;
        top: 0;
        z-index: 10;
        background: #111;
        color: #fff;
        box-shadow: 0 6px 18px rgba(0, 0, 0, .12);
    }

    .cpanel-login-navbar-inner {
        min-height: 68px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 2rem;
    }

    .cpanel-login-navbar img {
        width: 120px;
        max-height: 42px;
        object-fit: contain;
        filter: brightness(0) invert(1);
    }

    .cpanel-login-navbar-badge {
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        font-size: 14px;
        color: rgba(255, 255, 255, .86);
    }

    .cpanel-login-content {
        min-height: calc(100vh - 68px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 3rem 1rem;
    }

    .cpanel-login-card {
        width: 100%;
        max-width: 430px;
        background: #fff;
        border: 1px solid rgba(17, 17, 17, .08);
        border-radius: 24px;
        box-shadow: 0 22px 70px rgba(17, 17, 17, .12);
        overflow: hidden;
    }

    .cpanel-login-card-header {
        padding: 2.25rem 2rem 1rem;
        text-align: center;
    }

    .cpanel-login-icon {
        width: 58px;
        height: 58px;
        border-radius: 18px;
        margin: 0 auto 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #111;
        color: #fff;
        font-size: 24px;
        box-shadow: 0 14px 30px rgba(17, 17, 17, .18);
    }

    .cpanel-login-title {
        margin: 0;
        font-size: 25px;
        font-weight: 700;
        color: #111;
    }

    .cpanel-login-subtitle {
        margin: .55rem auto 0;
        max-width: 310px;
        color: #6b7280;
        font-size: 14px;
        line-height: 1.5;
    }

    .cpanel-login-form {
        padding: 1.25rem 2rem 2rem;
    }

    .cpanel-login-form .form-label,
    .cpanel-login-form label {
        color: #111;
        font-size: 14px;
        font-weight: 600;
        margin-bottom: .45rem;
    }

    .cpanel-login-form .form-control {
        min-height: 46px;
        border-radius: 999px !important;
        border: 1px solid #d6d9df;
        color: #111;
        padding: .65rem 1rem;
        background: #fff;
        transition: border-color .15s ease, box-shadow .15s ease;
    }

    .cpanel-login-form .form-control:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, .18);
    }

    .cpanel-login-form .form-group,
    .cpanel-login-form .mb-3 {
        margin-bottom: 1rem;
    }

    .cpanel-login-alert {
        border: 0;
        border-radius: 16px;
        background: #fff1f2;
        color: #be123c;
        font-size: 14px;
        padding: .85rem 1rem;
    }

    .cpanel-login-submit {
        width: 100%;
        min-height: 46px;
        border: 1px solid #111;
        border-radius: 999px;
        background: #111;
        color: #fff;
        font-size: 14px;
        font-weight: 700;
        letter-spacing: .04em;
        text-transform: uppercase;
        transition: transform .15s ease, background .15s ease, box-shadow .15s ease;
        box-shadow: 0 12px 24px rgba(17, 17, 17, .16);
    }

    .cpanel-login-submit:hover,
    .cpanel-login-submit:focus {
        background: #2d2d2d;
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 16px 30px rgba(17, 17, 17, .2);
    }

    .cpanel-login-footer {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: .5rem;
        padding-top: 1.25rem;
        color: #8a8f98;
        font-size: 13px;
    }

    .cpanel-login-footer span {
        width: 4px;
        height: 4px;
        border-radius: 50%;
        background: #c9ced6;
    }

    @media (max-width: 576px) {
        .cpanel-login-navbar-inner { padding: 0 1rem; }
        .cpanel-login-navbar-badge span { display: none; }
        .cpanel-login-content { align-items: flex-start; padding-top: 2rem; }
        .cpanel-login-card { border-radius: 20px; }
        .cpanel-login-card-header,
        .cpanel-login-form { padding-left: 1.35rem; padding-right: 1.35rem; }
    }
</style>

<div class="cpanel-login-shell">
    <!-- <header class="cpanel-login-navbar">
        <div class="cpanel-login-navbar-inner">
            <a href="<?= Yii::getAlias('@raizweb') ?>" aria-label="Ir al sitio principal">
                <img src="<?= $logo ?>" alt="Logo">
            </a>
            <div class="cpanel-login-navbar-badge">
                <i class="fa-regular fa-circle-user"></i>
                <span>Panel Administrativo</span>
            </div>
        </div>
    </header> -->

    <main class="cpanel-login-content">
        <section class="cpanel-login-card" aria-label="Inicio de sesión del cpanel">
            <div class="cpanel-login-card-header">
                <div class="cpanel-login-icon">
                    <i class="fa-solid fa-lock"></i>
                </div>
                <h1 class="cpanel-login-title">Acceso al cpanel</h1>
                <p class="cpanel-login-subtitle">Ingresa tus credenciales para administrar el contenido y las herramientas del proyecto.</p>
            </div>

            <div class="cpanel-login-form">
                <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'id' => 'leadform']]); ?>

                    <?php if ($model->getErrors()): ?>
                        <div class="alert cpanel-login-alert" role="alert">
                            <i class="fa-solid fa-circle-exclamation me-2"></i>
                            <?= Html::encode($model->getErrors('error')[0] ?? 'Usuario o contraseña incorrectos.') ?>
                        </div>
                    <?php endif; ?>

                    <?= $form->field($model, 'username')->textInput([
                        'maxlength' => true,
                        'class' => 'form-control',
                        'autocomplete' => 'username',
                        'placeholder' => 'usuario@correo.com',
                    ])->label('Usuario o correo electrónico'); ?>

                    <?= $form->field($model, 'password')->passwordInput([
                        'maxlength' => true,
                        'class' => 'form-control',
                        'autocomplete' => 'current-password',
                        'placeholder' => 'Tu contraseña',
                    ])->label('Contraseña'); ?>

                    <div class="cf-turnstile mb-3 d-flex justify-content-center" data-sitekey="<?= Yii::$app->params['turnstile.siteKey'] ?>"></div>

                    <?= Html::submitButton('Ingresar', [
                        'class' => 'btn cpanel-login-submit mt-2',
                        'name' => 'login-button',
                    ]); ?>

                    <div class="cpanel-login-footer">
                        <strong><?= date('Y'); ?></strong>
                        <span></span>
                        <small>© Copyright</small>
                    </div>

                <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
                <?php ActiveForm::end(); ?>
            </div>
        </section>
    </main>
</div>

<?= Yii::$app->RecoverPass->modal(); ?>
