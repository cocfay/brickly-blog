<?php
use frontend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap5\Button;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Url;
use common\models\ContactAsesor;
use yii\helpers\ArrayHelper;
use common\models\Countries;
//use manchenkov\yii\recaptcha\ReCaptchaWidget;

AppAsset::register($this);
$this->beginPage();


$infoUs = Yii::$app->LocationLang->info();
$lang = $infoUs->language->LanguageCode;

$metadescription = [
    'es' => 'Software a medida para automatizar procesos y reducir costos. Robustez, seguridad y soporte 24/7. ¡Conoce nuestro portafolio!',
    'en' => 'Custom software to automate processes and reduce costs. Reliability, security, and 24/7 support. Discover our portfolio!',
    'fr' => 'Logiciel sur mesure pour automatiser les processus et réduire les coûts. Fiabilité, sécurité et support 24/7. Découvrez notre portfolio !',
    'it' => 'Software personalizzato per automatizzare i processi e ridurre i costi. Affidabilità, sicurezza e supporto 24/7. Scopri il nostro portfolio!',
    'pt' => 'Software personalizado para automatizar processos e reduzir custos. Confiabilidade, segurança e suporte 24 horas. Conheça nosso portfólio!',
    'de' => 'Maßgeschneiderte Software zur Automatisierung von Prozessen und Kostensenkung. Zuverlässigkeit, Sicherheit und 24/7-Support. Entdecken Sie unser Portfolio!'
];

$metakeybords = [
    'es' => 'Desarrollo, Desarrollo de plataformas, Desarrollo web, Desarrollo móvil, e-commerce, e-commerce, Diseño web, Agencia de marketing para países en español',
    'en' => 'Development, Platform development, Web development, Mobile development, E-commerce, Ecommerce, Web design, Marketing agency for Spanish-speaking countries',
    'fr' => 'Développement, Développement de plateformes, Développement web, Développement mobile, E-commerce, Commerce électronique, Web design, Agence de marketing pour pays hispanophones',
    'it' => 'Sviluppo, Sviluppo piattaforme, Sviluppo web, Sviluppo mobile, E-commerce, Ecommerce, Web design, Agenzia di marketing per paesi di lingua spagnola',
    'pt' => 'Desenvolvimento, Desenvolvimento de plataformas, Desenvolvimento web, Desenvolvimento móvel, E-commerce, Comércio eletrônico, Web design, Agência de marketing para países hispânicos',
    'de' => 'Entwicklung, Plattformentwicklung, Webentwicklung, Mobile-Entwicklung, E-Commerce, Online-Handel, Webdesign, Marketingagentur für spanischsprachige Länder'
];


$modelCA = new ContactAsesor;

$modelCA = new ContactAsesor;
$contryList = Countries::find()->orderBy(['Name' => SORT_ASC])->all();
$cc = Countries::find()->select(['CountryID'])->where(['Abbreviation' => $infoUs->country_code])->one();
$contryList = ArrayHelper::map($contryList, 'CountryID', 'Name');
$countryCode = $cc->CountryID;
?>

<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= $metadescription[$lang] ?>">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <link rel="shortcut icon" href="<?= Yii::getAlias('@web').'/images/icons/favicon.png'?>"/>
    <?php $this->head() ?>
    <?php if(!str_contains($_SERVER['SERVER_NAME'], 'dev.mydesk.digital')): ?>
        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-7GWVFV7Q21"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'G-7GWVFV7Q21');
        </script>
    <?php endif ?>
</head>
<body style="background-color: #1F1E1E; color: #ffffff; overflow-x: hidden;
  width: 100%;">
    
        <div class="menu-fixed d-none d-md-block" style="position: relative; margin: 3rem 0;">
            <div class="container d-flex align-items-center justify-content-between flex-column flex-lg-row">
                <div class="mb-4 mb-lg-0"><a href="<?= Yii::getAlias("@web") ?>/" class="text-decoration-none"><img src="<?= Yii::getAlias("@web") ?>/images/home/logo_white.png" style="width: 150px;" alt="logo"></a></div>
                <div class="d-flex align-items-center text-white fw-bold" style="gap: 1.5rem;">
                    <!-- <a href="<?= Yii::getAlias("@web") ?>/" class="text-decoration-none text-white position-relative" data-section="menu" data-value="home">Inicio</a>
                    <a href="<?= Yii::getAlias("@web") ?>/services" class="text-decoration-none text-white position-relative" data-section="menu" data-value="ser">Servicios</a>
                    <a href="<?= Yii::getAlias("@web") ?>/porfolio" class="text-decoration-none text-white position-relative" data-section="menu" data-value="por">Portafolio</a> -->
                    <a href="<?= Yii::getAlias("@web") ?>/blog" class="text-decoration-none text-white position-relative">Blog</a>
                    <!-- <a href="<?= Yii::getAlias("@web") ?>/vlog" class="text-decoration-none text-white" data-menu="vlog">Vlog</a> -->
                    <div class="select-container">
                        <div class="select">
                            <div class="selected-option">
                                <div class="select-value d-flex align-items-center justify-content-start gap-3"><img src="<?= Yii::getAlias("@web") ?>/images/flagsIcons/<?= $lang == "es" ? "es" : "us" ?>.svg" style="width: 26px; height: 26px;" alt="" srcset=""></div>
                                <div class="arrow-down"><i class="fa-solid fa-chevron-down"></i></div>
                            </div>
                            <div data-toggle="collapsed" class="options">
                                <div class="option d-flex align-items-center justify-content-start gap-3" data-href="<?= Url::to(['/home/lang', 'set' => 'en']) ?>" data-lang="en"><img src="<?= Yii::getAlias("@web") ?>/images/flagsIcons/us.svg" style="width: 26px; height: 26px;" alt="" srcset=""> English</div>
                                <div class="option d-flex align-items-center justify-content-start gap-3" data-href="<?= Url::to(['/home/lang', 'set' => 'es']) ?>" data-lang="es"><img src="<?= Yii::getAlias("@web") ?>/images/flagsIcons/es.svg" style="width: 26px; height: 26px;" alt="" srcset=""> Spanish</div>
                            </div>
                        </div>
                    </div>
                    <!-- <a href="#contact-advisor" class="button-label cursor-hover-item wow animated fadeInUp animated d-flex align-items-center bg-black buttonAsesor"><img src="<?= Yii::getAlias("@web") ?>/images/home/iconasesor.png" style="width:20px; height:18px;" alt="Asesor" srcset=""><span data-section="menu" data-value="car">Contactar a un asesor</span></a> -->
                    <a href="<?= Yii::getAlias("@web") ?>/admin" target="_blank" class="button-label cursor-hover-item wow animated fadeInUp animated d-flex align-items-center" data-wow-delay="0s" style="visibility: visible; animation-delay: 0s; animation-name: fadeInUp;"> <i class="fa-regular fa-circle-user"></i> <span data-section="menu" data-value="login">Iniciar sesión</span></a>
                </div>
            </div>
        </div>
        <div class="container d-flex d-md-none justify-content-between align-items-center my-5">
            <div data-bs-toggle="offcanvas" data-bs-target="#menuResponsive" aria-controls="offcanvasExample"><i class="fa-solid fa-bars text-white fs-2"></i></div>
            <div style="width: 100%" class="position-relative">
                <a href="<?= Yii::getAlias("@web") ?>/" class="text-decoration-none">
                    <img src="<?= Yii::getAlias("@web") ?>/images/home/logo_white.png" alt="logo" class="d-block position-absolute top-50 translate-middle" style="width: 110px; left: calc(100% - 52%);">
                </a>
            </div>
        </div>
    
    <!-- <div class="row justify-content-center justify-content-md-between align-items-center m-auto container my-3">
        <div class="col-md-6 text-center text-md-start">
            <a href="<?= Url::to(['/porfolio']) ?>">
                <img class="imgLogo" src="<?= Yii::getAlias('@web').'/images/logo.png'?>" alt="logo" />
            </a>
        </div>
        <div class="col-md-6 d-flex flex-column flex-md-row justify-content-end align-items-center gap-2 gap-md-4 mt-4 mt-md-0 optionsContacts d-none d-lg-flex"></div>
    </div> -->
    <?php $this->beginBody() ?>

    <?= $content ?>

    <!-- MODAL POPUP CONTACTAR A UN ASESOR -->
    <div class="modal fade" id="FormContactModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="background-color: #232323;color: #ffffff;">
                <div class="modal-body px-4">
                    <i class="fa-solid fa-xmark mb-4 d-flex justify-content-end clearUrls" style="cursor: pointer" data-bs-dismiss="modal" aria-label="Close"></i>
                    <div class="fs-3 fw-bold lh-1 mb-4 mt-0" data-section="menu" data-value="car">Contactar a un asesor</div>
                        <div style="font-size: 14px" data-section="contact" data-value="text12">Llena el siguiente formulario y nos pondremos en contacto contigo. Nos esforzamos por responder todas las consultas dentro de las primeras 24 horas en días hábiles.</div>
                        <div class="row mt-4">
                        <?php $form = ActiveForm::begin(['action' => ['/home/contactasesor'], 'method' => 'post']) ?>
                            <div class="col-12 mb-3">
                                <?= $form->field($modelCA, 'Name', ['labelOptions' => ['style' => 'font-size: 16px;', 'data-section' => 'contact', 'data-value' => 'text10']])->textInput(['maxlength' => 'true', 'class' => 'form-control inputAse', 'style' => 'border-color: #fff; background-color: #1f1f1f; color: #fff;']) ?>
                            </div>
                            <div class="row mb-1">
                                <div class="form-label mb-2" style="font-size: 16px" data-section="contact" data-value="text5">Teléfono *</div>
                                <div class="col-12">
                                    <?= $form->field($modelCA, 'Phone', ['options' => ['class' => 'mb-2']])->textInput(['style' => 'border-color: #fff; background-color: #1f1f1f; color: #fff;', 'maxlength' => 'true', 'class' => 'form-control inputAse'])->label(false) ?>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <?= $form->field($modelCA, 'Country', ['labelOptions' => ['style' => 'font-size: 16px;', 'data-section' => 'contact', 'data-value' => 'text7']])->dropDownList($contryList, ['class' => 'w-100 form-select', 'style' => 'border-color: #fff; background-color: #1f1f1f; color: #fff;', 'options' => [$countryCode => ['Selected' => true]]]) ?>
                            </div>
                            <div class="col-12 mb-3">
                                <?= $form->field($modelCA, 'Email', ['labelOptions' => ['style' => 'font-size: 16px;', 'data-section' => 'contact', 'data-value' => 'text6']])->input('email', ['maxlength' => true, 'class' => 'form-control inputAse', 'style' => 'border-color: #fff; background-color: #1f1f1f; color: #fff;']) ?>
                            </div>
                            <div class="col-12">
                                <?= $form->field($modelCA, 'Consulta', ['labelOptions' => ['style' => 'font-size: 16px;', 'data-section' => 'contact', 'data-value' => 'text11']])->textarea(['maxlength' => true, 'class' => 'form-control inputAse', 'style' => 'min-height: 100px; border-color: #fff; background-color: #1f1f1f; color: #fff;']) ?>
                            </div>
                            <div class="mt-4 col-12 d-flex justify-content-center align-items-center">
                                <button type="submit" class="btn btn-lila"><span data-section="contact" data-value="text9">Enviar</span></button>
                                <input type="hidden" id="recaptcha-token2" name="recaptcha-token">
                            </div>
                        <?php ActiveForm::end() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="formulario position-fixed top-0 end-0 bg-white p-3">
        <div class="text-end buttonAsesor text-body clearUrl" style="cursor: pointer"><i class="fa-solid fa-xmark"></i></div>
        <div class="px-3 mb-5 text-body">
            <div class="fs-3 fw-bold lh-1 mb-4 mt-4" data-section="menu" data-value="car">Contactar a un asesor</div>
            <div style="font-size: 14px" data-section="contact" data-value="text12">Llena el siguiente formulario y nos pondremos en contacto contigo. Nos esforzamos por responder todas las consultas dentro de las primeras 24 horas en días hábiles.</div>
            <div class="row mt-4">
            <?php $form = ActiveForm::begin(['action' => ['/home/contactasesor'], 'method' => 'post']) ?>
                <div class="col-12 mb-3">
                    <?= $form->field($modelCA, 'Name', ['labelOptions' => ['style' => 'font-size: 16px', 'data-section' => 'contact', 'data-value' => 'text10']])->textInput(['maxlength' => 'true', 'class' => 'form-control inputAse']) ?>
                </div>
                <div class="row mb-1">
                    <div class="form-label mb-2" style="font-size: 16px" data-section="contact" data-value="text5">Teléfono *</div>
                    <div class="col-12">
                        <?= $form->field($modelCA, 'Phone', ['options' => ['class' => 'mb-2']])->textInput(['maxlength' => 'true', 'class' => 'form-control inputAse'])->label(false) ?>
                    </div>
                </div>
                <div class="col-12 mb-3">
                    <?= $form->field($modelCA, 'Country', ['labelOptions' => ['style' => 'font-size: 16px', 'data-section' => 'contact', 'data-value' => 'text7']])->dropDownList($contryList, ['class' => 'w-100 form-select', 'options' => [$countryCode => ['Selected' => true]]]) ?>
                </div>
                <div class="col-12 mb-3">
                    <?= $form->field($modelCA, 'Email', ['labelOptions' => ['style' => 'font-size: 16px', 'data-section' => 'contact', 'data-value' => 'text6']])->input('email', ['maxlength' => true, 'class' => 'form-control inputAse']) ?>
                </div>
                <div class="col-12">
                    <?= $form->field($modelCA, 'Consulta', ['labelOptions' => ['style' => 'font-size: 16px', 'data-section' => 'contact', 'data-value' => 'text11']])->textarea(['maxlength' => true, 'class' => 'form-control inputAse', 'style' => 'min-height: 100px']) ?>
                </div>
                <div class="mt-4 col-12 d-flex justify-content-center align-items-center">
                    <button type="submit" class="btn btn-black"><span data-section="contact" data-value="text9">Enviar</span></button>
                    <input type="hidden" id="recaptcha-token" name="recaptcha-token">
                </div>
            <?php ActiveForm::end() ?>
            </div>
        </div>
    </div>

    <footer class="container-fluid bg-black">
        <div class="container py-5">
            <div class="row mx-0">
                <div class="col-lg-6 mb-5 mb-lg-0 d-flex flex-column align-items-center align-items-md-start">
                    <a href="<?= Yii::getAlias("@web") ?>/"><img src="<?= Yii::getAlias("@web") ?>/images/home/logo_white.png" style="width: 150px" alt="logo"></a>
                </div>
                <div class="col-lg-6 fs-4 lh-sm">
                    <span data-section="footer" data-value="text1">¡Estamos listos para iniciar tu proyecto!</span>
                    <div class="mt-2" style="font-size: clamp(16px, 1.1vw, 18px)" data-section="footer" data-value="text2">
                        Nuestro equipo de expertos está preparado
                        <div class="d-inline d-md-block">para trabajar contigo</div>
                    </div>
                    <div class="row mx-0 mt-5" style="font-size: clamp(16px, 1.1vw, 18px)">
                        <div class="col-md-6 px-0 mb-4 mb-md-0">
                            <div class="text-lila mb-2" data-section="footer" data-value="text3">Locación</div>
                            <span data-section="footer" data-value="text4">Ciudad de Guatemala</span>
                        </div>
                        <div class="col-md-6 px-0">
                            <div class="text-lila mb-2" data-section="footer" data-value="text5">Solicita información</div>
                            <span class="user-select-none">info@weclickdigital.com</span>
                        </div>
                        <div class="col-md-6 px-0 mt-3">
                            <div class="text-lila mb-2" data-section="footer" data-value="text6">Síguenos</div>
                            <div class="socalmedias">
                                <a href="https://www.instagram.com/weclick.digital/?igsh=YTJyYjMxaWNrNWsw#" target="_blank" class="text-decoration-none user-select-none"><img src="<?= Yii::getAlias("@web") ?>/images/icons/IGlila.png" alt="Instagram" style="width: 30px;" srcset=""></a>
                                <a href="https://www.facebook.com/WeclickDigital" target="_blank" class="text-decoration-none user-select-none"><img src="<?= Yii::getAlias("@web") ?>/images/icons/FBlila.png" alt="Facebook" style="width: 30px;" srcset=""></a>
                                <a href="https://www.linkedin.com/company/weclick-digital/" target="_blank" class="text-decoration-none user-select-none"><img src="<?= Yii::getAlias("@web") ?>/images/icons/INlila.png" alt="LinkedIn" style="width: 30px;" srcset=""></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mx-0 mt-5">
                <div class="col-12" style="font-size: 16px">
                    <span class="text-lila d-block d-md-inline-block">© Weclick Digital.</span> <span data-section="footer" data-value="text7">Todos los derechos <span class="cdt">reservados</span></span> <?= date("Y") ?>
                </div>
            </div>
        </div>
    </footer>

    <?=  Yii::$app->getModule('jc-chat')->ShowClient(); ?>

    <a href="https://api.whatsapp.com/send?phone=50258634559&amp;text=<?= urlencode('Hola, quiero contactar a un asesor.') ?>" class="whatsapp-button" target="_blank">
        <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg"  alt="WhatsApp" width="30">
    </a>

    <?php $this->endBody() ?>

    <!-- MENU DE LA VERSION MOVIL -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="menuResponsive" aria-labelledby="offcanvasExampleLabel" style="background-color: rgb(31, 30, 30); color: rgb(255, 255, 255);">
        <div class="offcanvas-header justify-content-between">
            <div class="select-container">
                <div class="select">
                    <div class="selected-option">
                        <div class="select-value d-flex align-items-center justify-content-start gap-3"><img src="<?= Yii::getAlias("@web") ?>/images/flagsIcons/<?= $lang == "es" ? "es" : "us" ?>.svg" style="width: 26px; height: 26px;" alt="" srcset=""></div>
                        <div class="arrow-down"><i class="fa-solid fa-chevron-down"></i></div>
                    </div>
                    <div data-toggle="collapsed" class="options">
                        <div class="option d-flex align-items-center justify-content-start gap-3" data-href="<?= Url::to(['/home/lang', 'set' => 'en']) ?>" data-lang="en"><img src="<?= Yii::getAlias("@web") ?>/images/flagsIcons/us.svg" style="width: 26px; height: 26px;" alt="" srcset=""> English</div>
                        <div class="option d-flex align-items-center justify-content-start gap-3" data-href="<?= Url::to(['/home/lang', 'set' => 'es']) ?>" data-lang="es"><img src="<?= Yii::getAlias("@web") ?>/images/flagsIcons/es.svg" style="width: 26px; height: 26px;" alt="" srcset=""> Spanish</div>
                    </div>
                </div>
            </div>
            <!-- <div><img src="<?= Yii::getAlias("@web") ?>/images/home/logo_white.png" style="width: 110px;" alt="logo"></div> -->
            <i class="fa-solid fa-xmark fs-2" data-bs-dismiss="offcanvas" aria-label="Close"></i>
        </div>
        <hr>
        <div class="offcanvas-body fw-bold d-flex flex-column gap-3">
            <a href="<?= Yii::getAlias("@web") ?>/" class="text-decoration-none text-white position-relative" data-section="menu" data-value="home">Inicio</a>
            <a href="<?= Yii::getAlias("@web") ?>/services" class="text-decoration-none text-white position-relative" data-section="menu" data-value="ser">Servicios</a>
            <a href="<?= Yii::getAlias("@web") ?>/porfolio" class="text-decoration-none text-white position-relative" data-section="menu" data-value="por">Portafolio</a>
            <a href="<?= Yii::getAlias("@web") ?>/blog" class="text-decoration-none text-white position-relative">Blog</a>
            <a href="#" class="text-decoration-none text-white position-relative buttonAsesor" data-bs-dismiss="offcanvas" data-section="menu" data-value="cont">Contacto</a>
            <!--<a href="<?= Yii::getAlias("@web") ?>/vlog" class="text-decoration-none text-white position-relative" data-menu="vlog">Vlog</a> -->
            <!-- <button type="button" class="d-flex align-items-center buttonAsesor mt-4 text-white" style="background: transparent; border: none; font-size: 16px; width: fit-content;"><img src="<?= Yii::getAlias("@web") ?>/images/home/iconasesor.png" class="me-1" style="width:20px; height:20px " alt="Asesor" srcset="">Contactar a un asesor</button> -->
        </div>
    </div>

    <!-- MENSAJE FEEBACK DEL FORMULARIO DE CONTACTO -->
    <?php if(Yii::$app->session->hasFlash('success')): ?>
        <div class="modal fade" id="successMSG" tabindex="-1" data-bs-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-end">
                        <i class="fa-solid fa-xmark text-white" data-bs-dismiss="modal" aria-label="Close"></i>
                    </div>
                    <div class="modal-body mt-4 mb-5">
                        <img src="<?= Yii::getAlias('@web') ?>/images/iconos/check.png" class="d-block m-auto" style="width: 80px" alt="check" srcset="">
                        <div class="text-center fs-3 my-3 fw-bold lh-sm" data-section="message" data-value="text1">¡Gracias por contactarnos!</div>
                        <div class="text-center mb-4" data-section="message" data-value="text2">Tu solicitud estará siendo atendida<br> por uno de nuestros asesores.</div>
                        <center>
                            <button type="button" class="btn btn-lila" data-bs-dismiss="modal"><span data-section="message" data-value="text3">Continuar</span></button>
                        </center>
                    </div>
                </div>
            </div>
        </div>
        <?php
            $this->registerJS(' $(function() {$("#successMSG").modal("show")}) ')
        ?>
    <?php elseif(Yii::$app->session->hasFlash('error')): ?>
        <div class="modal fade" id="successMSG" tabindex="-1" data-bs-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-end">
                        <i class="fa-solid fa-xmark text-white" data-bs-dismiss="modal" aria-label="Close"></i>
                    </div>
                    <div class="modal-body mt-4 mb-5">
                        <img src="<?= Yii::getAlias('@web') ?>/images/logo.png" class="d-block m-auto" style="width: 120px" alt="check" srcset="">
                        <div class="text-center fs-3 my-3 fw-bold lh-sm" data-section="message" data-value="text4">¡Error de validación!</div>
                        <div class="text-center mb-4" data-section="message" data-value="text5">No pudimos validar la información, intente mas tarde.</div>
                        <center>
                            <button type="button" class="btn btn-lila" data-bs-dismiss="modal"><span data-section="message" data-value="text3">Continuar</span></button>
                        </center>
                    </div>
                </div>
            </div>
        </div>
        <?php
            $this->registerJS('$("#successMSG").modal("show")')
        ?>
    <?php endif ?>
    
    <script>
        AOS.init({
            once: true,
            disable: 'mobile' // Desactiva completamente en móviles
        });

        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        grecaptcha.ready(function() {
            if(grecaptcha && document.getElementById('recaptcha-token') != null){
                grecaptcha.execute('6LeKNtcqAAAAAKoOTJiylGVGWAq-jRLrj5lGnmrW', {action: 'submit'}).then(function(token) {
                    document.getElementById('recaptcha-token').value = token;
                    //console.log("Token generado: " + token);  // Verifica que no sea vacío
                });
            }
            if(grecaptcha && document.getElementById('recaptcha-token2') != null){
                grecaptcha.execute('6LeKNtcqAAAAAKoOTJiylGVGWAq-jRLrj5lGnmrW', {action: 'submit'}).then(function(token) {
                    document.getElementById('recaptcha-token2').value = token;
                    //console.log("Token generado: " + token);  // Verifica que no sea vacío
                });
            }
        });
        
        const menu = document.querySelector('.menu-fixed');

        document.addEventListener("scroll", function () {
            if (window.scrollY > 50) {
                menu.classList.add('blur');
                menu.style.position = 'fixed';
                menu.style.margin = '0';
                menu.querySelector('div').style.width = '77%';
            } else {
                menu.classList.remove('blur');
                menu.style.position = 'relative';
                menu.style.margin = '3rem 0';
                menu.querySelector('div').style.width = 'auto';
            }
        });

        const buttonAsesor = document.querySelectorAll('.buttonAsesor')
        const formulario = document.querySelector('.formulario')
        buttonAsesor.forEach(items => {
            items.addEventListener('click', () =>{
                formulario.classList.contains('active') ? formulario.classList.remove('active') : formulario.classList.add('active')
            })
        })

        var url = window.location.pathname.split('/')
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        
        if(url[2] != null){
            if(url[2].includes('punto-de-venta-')){

                const imgLogo = document.querySelector('.imgLogo')
                const imgLogoFooter = document.querySelector('.imgLogoFooter')
                imgLogo.closest('a').href = 'https://www.weclickdigital.com/';
                imgLogoFooter.closest('a').href = 'https://www.weclickdigital.com/';

            }

            /* grecaptcha.ready(function() {
                grecaptcha.execute('6LfsFWgqAAAAAKJiKax7HMtbMRcAJyz-aH-0IBsj', {action: 'submit'}).then(function(token) {
                    document.getElementById('recaptcha-token').value = token;
                    //console.log("Token generado: " + token);  // Verifica que no sea vacío
                });
            });
            
            if(url[2].includes('punto-de-venta-')){
                grecaptcha.ready(function() {
                    grecaptcha.execute('6LfsFWgqAAAAAKJiKax7HMtbMRcAJyz-aH-0IBsj', {action: 'submit'}).then(function(token) {
                        document.getElementById('recaptcha-token2').value = token;
                        //console.log("Token generado: " + token);  // Verifica que no sea vacío
                    });
                });
            } */
        }

        const itemsMenu =  menu.querySelectorAll('a')
        
        itemsMenu.forEach(i =>{
            if(window.location.href.replace(/\/home$/, '/') === i.href || i.href.includes(window.location.pathname.split('/')[2]))
                i.classList.add('active')
        })

        const selectedOption = document.querySelectorAll('.selected-option');
        const selectValue = document.querySelector('.select-value');
        const optionContainer = document.querySelectorAll('.options');
        const optionList = document.querySelectorAll('.option');

        /** Toggle function */
        const selectToggle = ()=>{
            optionContainer.forEach(oc =>{
                if(oc.dataset.toggle == 'collapsed'){
                    oc.dataset.toggle = '';
                }else{
                    oc.dataset.toggle = 'collapsed'
                }
            })
        }

        /** When click on seleted-option */
        selectedOption.forEach( so => { so.addEventListener('click', selectToggle) })

        /** This function update select value */
        const updateSelectValue = (option) => {
            //selectValue.innerHTML = option.innerHTML;
    
            window.location.href = option.dataset.href;
            //localStorage.setItem('selectLang', ''+option.dataset.lang+'')
        }

        optionList.forEach((option) => {
            /* if(option.dataset.lang === document.querySelector("html").getAttribute('lang')){
                selectValue.innerHTML = option.innerHTML;
            } */
            option.addEventListener('click', (e) => {
                updateSelectValue(option)
                selectToggle()
            })  
        })

        document.querySelector('.clearUrl').addEventListener('click', function() {
            // Elimina el fragmento de la URL sin recargar la página
            history.replaceState(null, null, ' ');
        });

        if (window.location.href.endsWith('#contact-advisor')) {
            document.querySelector('.button-label').click()
        }

    </script>
</body>
</html>
<?php $this->endPage() ?>