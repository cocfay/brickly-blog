<?php
use frontend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;

AppAsset::register($this);
$this->beginPage();

$controllerId = Yii::$app->controller->id;
$isBlogSection = $controllerId === 'blog';
$isVlogSection = $controllerId === 'vlog';
$isDarkSection = $isVlogSection;

$metaDescriptions = [
    'blog' => 'Blog de Brickly Homes con contenido sobre propiedades, inversión inmobiliaria y tendencias del mercado.',
    'vlog' => 'Vlog de Brickly Homes con contenido audiovisual sobre propiedades y mercado inmobiliario.',
    'default' => 'Brickly Homes: propiedades, agentes, asociados y contenido inmobiliario.',
];

$pageDescription = $metaDescriptions[$controllerId] ?? $metaDescriptions['default'];
$brandHomeUrl = Yii::getAlias('@web') . '/';
$logoPath = Yii::getAlias('@web') . ($isDarkSection ? '/images/logos/logo_blanco.png' : '/images/logos/logo_negro.png');
$headerTextColor = $isDarkSection ? '#ffffff' : '#111111';
$headerBackground = $isDarkSection ? '#111111' : '#ffffff';
$bodyBackground = $isDarkSection ? '#111111' : '#ffffff';
$bodyColor = $isDarkSection ? '#ffffff' : '#111111';

$whatsappUrl = 'https://wa.me/50237649719?text=' . urlencode('¡Hola! Deseo contactar a un asesor.');
$subscribeUrl = Url::to(['/blog/subscribe']);

$navItems = [
    ['label' => 'PROPIEDADES', 'url' =>'https://www.bricklyhomes.com/propiedades'],
    ['label' => 'BUSCAR AGENTE', 'url' => 'https://www.bricklyhomes.com/agentes'],
    ['label' => 'ASOCIADOS', 'url' => 'https://www.bricklyhomes.com/asociados'],
    ['label' => 'PRECIOS', 'url' => 'https://www.bricklyhomes.com/precios'],
    ['label' => 'BLOG', 'url' => Yii::getAlias('@web') . '/blog', 'active' => $isBlogSection],
];

$this->registerCss(<<<CSS
body.brickly-lead-layout {
    background-color: {$bodyBackground};
    color: {$bodyColor};
    max-width: 100%;
    overflow-x: hidden;
}
.brickly-lead-layout a {
    text-decoration: none;
}
.brickly-header-shell--dark {
    border-bottom-color: rgba(255,255,255,.12);
}
.brickly-header-inner {
    min-height: 101px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 24px;
}
.brickly-header-nav {
    display: flex;
    flex-wrap: wrap;
    justify-content: flex-end;
    gap: 18px 28px;
}
.brickly-header-link.active,
.brickly-mobile-link.active {
    opacity: .72;
}
/* .brickly-mobile-bar {
    background: {$headerBackground};
    color: {$headerTextColor};
    border-bottom: 1px solid rgba(0,0,0,.06);
    position: sticky;
    top: 0;
    z-index: 1041;
} */
.brickly-mobile-bar--dark {
    border-bottom-color: rgba(255,255,255,.12);
}
.brickly-mobile-bar__inner {
    min-height: 74px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.brickly-mobile-bar__toggle {
    border: 0;
    background: transparent;
    color: inherit;
    font-size: 28px;
}
.brickly-mobile-offcanvas__body {
    display: flex;
    flex-direction: column;
    gap: 18px;
}
.brickly-mobile-offcanvas {
    --bs-offcanvas-width: min(100vw, 565px);
    color: #ffffff;
    width: min(100vw, 565px) !important;
}
.brickly-mobile-offcanvas__header {
    align-items: center;
    justify-content: space-between;
    padding: 12px 16px 0px;
}
.brickly-mobile-offcanvas__brand img {
    display: block;
    width: 120px;
}
.brickly-mobile-offcanvas__close {
    align-items: center;
    background: transparent;
    border: 0;
    color: rgba(255, 255, 255, .52);
    display: inline-flex;
    font-size: 16px;
    height: 44px;
    justify-content: center;
    line-height: 1;
    padding: 0;
    width: 44px;
}
.brickly-mobile-offcanvas__body {
    padding: 36px 18px 0px;
}

.brickly-mobile-offcanvas__nav {
    display: flex;
    flex-direction: column;
}
.brickly-mobile-offcanvas__nav .brickly-mobile-link {
    border-bottom: 1px solid rgba(255, 255, 255, .35);
    color: #ffffff;
    display: block;
    font-size: 14px;
    font-weight: 400;
    letter-spacing: 0;
    line-height: 1.2;
    padding: 18px 10px;
    text-decoration: none;
    width: 100%;
}
.brickly-mobile-offcanvas__nav .brickly-mobile-link.active::after {
    display: none;
}
.brickly-mobile-offcanvas__socials {
    align-items: center;
    display: flex;
    gap: 1.5rem;
    justify-content: center;
    margin: 30px 0 29px;
}
.brickly-mobile-offcanvas__socials a {
    align-items: center;
    color: #ffffff;
    display: inline-flex;
    font-size: 22px;
    justify-content: center;
    text-decoration: none;
}
.brickly-mobile-login {
    align-items: center;
    border: 1px solid rgba(255, 255, 255, .88);
    border-radius: 8px;
    color: #ffffff;
    display: flex;
    font-size: clamp(21px, 5vw, 24px);
    gap: 17px;
    justify-content: center;
    min-height: 88px;
    text-decoration: none;
    width: 100%;
}
.brickly-mobile-login:hover,
.brickly-mobile-offcanvas__socials a:hover,
.brickly-mobile-offcanvas__nav .brickly-mobile-link:hover {
    color: #ffffff;
}
@media (max-width: 991.98px) {
    .brickly-header-inner {
        min-height: 80px;
    }
}
CSS);
?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?= Html::encode($pageDescription) ?>">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <link rel="shortcut icon" href="<?= Yii::getAlias('@web') . '/images/favicon.png' ?>"/>
    <?php $this->head() ?>
    <?php if (!str_contains($_SERVER['SERVER_NAME'], 'dev.mydesk.digital')): ?>
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-7GWVFV7Q21"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', 'G-7GWVFV7Q21');
        </script>
    <?php endif ?>
</head>
<body class="brickly-lead-layout<?= $isDarkSection ? ' brickly-lead-layout--dark' : '' ?>">
<?php $this->beginBody() ?>

<header class="brickly-mobile-bar <?= $isDarkSection ? 'brickly-mobile-bar--dark' : '' ?> d-block d-lg-none">
    <div class="container brickly-mobile-bar__inner">
        <a href="<?= $brandHomeUrl ?>" class="brickly-mobile-bar__brand" aria-label="Brickly">
            <img src="<?= $logoPath ?>" class="img-fluid" alt="Brickly">
        </a>
        <button type="button" class="brickly-mobile-bar__toggle" data-bs-toggle="offcanvas" data-bs-target="#bricklyLeadMenu" aria-controls="bricklyLeadMenu" aria-label="Abrir menú">
            <i class="fa-solid fa-bars"></i>
        </button>
    </div>
</header>

<div class="offcanvas offcanvas-start brickly-mobile-offcanvas bg-dark" tabindex="-1" id="bricklyLeadMenu" aria-labelledby="bricklyLeadMenuLabel">
    <div class="offcanvas-header brickly-mobile-offcanvas__header">
        <a href="<?= $brandHomeUrl ?>" class="brickly-mobile-offcanvas__brand" aria-label="Brickly">
            <img src="<?= Yii::getAlias('@web') ?>/images/logos/logo_blanco.png" alt="Brickly">
        </a>
        <button type="button" class="brickly-mobile-offcanvas__close" data-bs-dismiss="offcanvas" aria-label="Cerrar menu">
            <i class="btn-close btn-close-white"></i>
        </button>
    </div>
    <div class="offcanvas-body brickly-mobile-offcanvas__body">

        <nav class="brickly-mobile-offcanvas__nav" aria-label="Menu movil">
        <?php foreach ($navItems as $item): ?>
            <a href="<?= $item['url'] ?>" class="brickly-mobile-link"><?= Html::encode($item['label']) ?></a>
        <?php endforeach; ?>
        </nav>

        <div class="brickly-mobile-offcanvas__socials" aria-label="Redes sociales">
            <a href="https://www.facebook.com/profile.php?id=61588999228778" target="_blank" rel="noreferrer" aria-label="Facebook"><i class="fa-brands fa-facebook"></i></a>
            <a href="<?= $whatsappUrl ?>" target="_blank" rel="noreferrer" aria-label="WhatsApp"><i class="fa-brands fa-whatsapp"></i></a>
            <a href="https://www.instagram.com/bricklyoficial/" target="_blank" rel="noreferrer" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
            <a href="https://www.linkedin.com/company/bricklygt/" target="_blank" rel="noreferrer" aria-label="LinkedIn"><i class="fa-brands fa-linkedin"></i></a>
            <a href="https://www.tiktok.com/@bricklyhomes?_r=1&_t=ZP-95NIrCBiYAQ" target="_blank" rel="noreferrer" aria-label="TikTok"><i class="fa-brands fa-tiktok"></i></a>
        </div>

        <!-- <a href="<?= Yii::getAlias('@web') ?>/cpanel" class="brickly-mobile-login">
            <i class="fa-solid fa-user"></i>
            <span>INICIAR SESIÓN</span>
        </a> -->
    </div>
</div>

<?= $content ?>

<footer class="brickly-footer py-5 bg-dark">
    <div class="container">
        <div class="brickly-footer__top">
            <div class="brickly-footer__brand">
                <a href="<?= $brandHomeUrl ?>" class="brickly-footer__logo-link">
                    <img src="<?= Yii::getAlias('@web') ?>/images/logos/logo_blanco.png" alt="Brickly" class="brickly-footer__logo">
                </a>
            </div>

            <div class="brickly-footer__center gap-1 gap-xl-5">
                <nav class="brickly-footer__nav d-flex justify-content-between flex-column flex-lg-row mt-xl-3" aria-label="Footer">
                    <a href="https://www.bricklyhomes.com/propiedades" style="font-size: 14px">PROPIEDADES</a>
                    <a href="https://www.bricklyhomes.com/agentes" style="font-size: 14px">BUSCAR AGENTE</a>
                    <a href="https://www.bricklyhomes.com/asociados" style="font-size: 14px">ASOCIADOS</a>
                    <a href="https://www.bricklyhomes.com/precios" style="font-size: 14px">PRECIOS</a>
                    <a href="<?= Yii::getAlias('@web') ?>/blog" style="font-size: 14px">BLOG</a>
                </nav>

                <div class="brickly-footer__subscribe mt-4 mt-lg-0">
                    <span class="brickly-footer__subscribe-label">SUSCRÍBETE</span>
                    <form class="brickly-footer__subscribe-form" action="<?= $subscribeUrl ?>" method="post" data-subscribe-form>
                        <label for="footer-subscription-email" class="visually-hidden">Correo electrónico para suscribirse</label>
                        <input id="footer-subscription-email" name="email" type="email" class="form-control" placeholder="E-mail" aria-label="E-mail" aria-describedby="footer-subscription-error" required>
                        <button type="submit" class="btn" data-subscribe-button>ENVIAR</button>
                    </form>
                    <div id="footer-subscription-error" class="brickly-footer__subscribe-error" data-subscribe-error aria-live="polite"></div>
                </div>
            </div>

            <div class="brickly-footer__contact">
                <div class="brickly-footer__socials mt-xl-2">
                    <a href="https://www.facebook.com/profile.php?id=61588999228778" target="_blank" rel="noreferrer" aria-label="Abrir Facebook de Brickly Homes"><i class="fa-brands fa-facebook"></i></a>
                    <a href="<?= $whatsappUrl ?>" target="_blank" rel="noreferrer" aria-label="Abrir WhatsApp de Brickly Homes"><i class="fa-brands fa-whatsapp"></i></a>
                    <a href="https://www.instagram.com/bricklyoficial/" target="_blank" rel="noreferrer" aria-label="Abrir Instagram de Brickly Homes"><i class="fa-brands fa-instagram"></i></a>
                    <a href="https://www.linkedin.com/company/bricklygt/" target="_blank" rel="noreferrer" aria-label="Abrir LinkedIn de Brickly Homes"><i class="fa-brands fa-linkedin"></i></a>
                    <a href="https://www.tiktok.com/@bricklyhomes?_r=1&_t=ZP-95NIrCBiYAQ" target="_blank" rel="noreferrer" aria-label="Abrir TikTok de Brickly Homes"><i class="fa-brands fa-tiktok"></i></a>
                </div>
                <div class="brickly-footer__info">
                    <span>Edificio Sixtino zona 10, Guatemala</span>
                    <a href="mailto:info@bricklyhomes.com">info@bricklyhomes.com</a>
                    <a href="<?= $whatsappUrl ?>" target="_blank" rel="noreferrer">+502 3764-9719</a>
                </div>
            </div>
        </div>
        <hr class="my-5">
        <div class="brickly-footer__bottom">
            <span>© Brickly. Todos los derechos reservados <?= date('Y') ?></span>
            <a href="https://www.bricklyhomes.com/terms">Términos y Condiciones de Servicio</a>
        </div>
    </div>
</footer>

<div class="brickly-toast" id="brickly-subscribe-toast" aria-live="polite" aria-atomic="true">
    <i class="fa-regular fa-circle-check"></i>
    <span>Gracias por suscribirte.</span>
</div>

<?php $this->endBody() ?>

<script>
    if (typeof AOS !== 'undefined') {
        AOS.init({ once: true });
    }

    const menu = document.querySelector('.menu-fixed');
    if (menu) {
        const desktopHeader = `
            <div class="brickly-header-shell <?= $isDarkSection ? 'brickly-header-shell--dark' : '' ?> d-none d-lg-block">
                <div class="container brickly-header-inner py-lg-2 py-xl-4">
                    <a href="<?= $brandHomeUrl ?>" class="brickly-header-brand" aria-label="Brickly">
                        <img src="<?= $logoPath ?>" alt="Brickly">
                    </a>
                    <nav class="brickly-header-nav" aria-label="Principal">
                        <?php foreach ($navItems as $item): ?>
                            <a href="<?= $item['url'] ?>" class="brickly-header-link<?= !empty($item['active']) ? ' active' : '' ?>"><?= Html::encode($item['label']) ?></a>
                        <?php endforeach; ?>
                    </nav>
                </div>
            </div>
        `;

        menu.insertAdjacentHTML('afterbegin', desktopHeader);
    }

    const subscribeForm = document.querySelector('[data-subscribe-form]');
    if (subscribeForm) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
        const subscribeInput = subscribeForm.querySelector('input[name="email"]');
        const subscribeButton = subscribeForm.querySelector('[data-subscribe-button]');
        const subscribeError = document.querySelector('[data-subscribe-error]');
        const subscribeToast = document.getElementById('brickly-subscribe-toast');
        let subscribeToastTimeout = null;

        const setSubscribeError = (message = '') => {
            if (!subscribeError) return;
            subscribeError.textContent = message;
            subscribeError.classList.toggle('is-visible', Boolean(message));
        };

        const showSubscribeToast = () => {
            if (!subscribeToast) return;
            subscribeToast.classList.add('is-visible');
            if (subscribeToastTimeout) {
                window.clearTimeout(subscribeToastTimeout);
            }
            subscribeToastTimeout = window.setTimeout(() => {
                subscribeToast.classList.remove('is-visible');
            }, 4000);
        };

        subscribeForm.addEventListener('submit', async function (event) {
            event.preventDefault();
            const email = subscribeInput ? subscribeInput.value.trim() : '';
            if (!email) return;

            setSubscribeError();

            if (subscribeButton) {
                subscribeButton.disabled = true;
                subscribeButton.dataset.originalText = subscribeButton.dataset.originalText || subscribeButton.innerHTML;
                subscribeButton.innerHTML = '<span class="spinner-border spinner-border-sm" aria-hidden="true"></span>';
            }

            try {
                const body = new URLSearchParams();
                body.append('email', email);
                body.append('_csrf', csrfToken);

                const response = await fetch(subscribeForm.action, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
                    },
                    body: body.toString()
                });

                const result = await response.json();

                if (response.ok && result.success) {
                    if (subscribeInput) {
                        subscribeInput.value = '';
                    }
                    showSubscribeToast();
                } else {
                    setSubscribeError(result.message || 'No pudimos procesar tu suscripción en este momento');
                }
            } catch (error) {
                setSubscribeError('No pudimos procesar tu suscripción en este momento');
            } finally {
                if (subscribeButton) {
                    subscribeButton.disabled = false;
                    subscribeButton.innerHTML = subscribeButton.dataset.originalText || 'ENVIAR';
                }
            }
        });
    }
</script>
</body>
</html>
<?php $this->endPage() ?>
