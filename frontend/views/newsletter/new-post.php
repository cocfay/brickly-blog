<?php
use yii\helpers\Html;

/* @var $post common\models\PostBlog */
/* @var $relatedPosts common\models\PostBlog[] */
/* @var $readingTime int */
/* @var $blogBaseUrl string */

$GLOBALS['_bricklyBlogBaseUrl'] = $blogBaseUrl ?? 'https://www.bricklyhomes.com/blog';

if (!function_exists('bricklyImgUrl')) {
    function bricklyImgUrl($path) {
        static $domain = null, $basePath = null;
        if ($domain === null) {
            $base = $GLOBALS['_bricklyBlogBaseUrl'] ?? 'https://www.bricklyhomes.com/blog';
            $parts = parse_url($base);
            $domain = ($parts['scheme'] ?? 'https') . '://' . ($parts['host'] ?? '');
            $basePath = !empty($parts['path']) ? '/' . ltrim($parts['path'], '/') : '';
        }
        if (strpos($path, 'http') === 0) {
            return $path;
        }
        $path = '/' . ltrim($path, '/');
        if ($basePath && strpos($path, $basePath . '/') === 0) {
            return $domain . $path;
        }
        return $domain . $basePath . $path;
    }
}

if (!function_exists('bricklyTrim')) {
    function bricklyTrim($text, $limit, $mode = 'chars') {
        $text = trim(preg_replace('/\s+/', ' ', strip_tags((string)$text)));
        if ($text === '') {
            return '';
        }
        if ($mode === 'words') {
            $items = explode(' ', $text);
            if (count($items) <= $limit) {
                return $text;
            }
            return implode(' ', array_slice($items, 0, $limit)) . '…';
        }
        if (mb_strlen($text) <= $limit) {
            return $text;
        }
        return mb_substr($text, 0, $limit) . '…';
    }
}

if (!function_exists('bricklyPostUrl')) {
    function bricklyPostUrl($post) {
        $base = $GLOBALS['_bricklyBlogBaseUrl'] ?? 'https://www.bricklyhomes.com/blog';
        $slug = !empty($post->Slug) ? $post->Slug : $post->PostBlogID;
        return $base . '/post/' . $slug;
    }
}

$postTitle = !empty($post->title) ? $post->title : ($post->VTitle ?: $post->Title);
$postTitle = bricklyTrim($postTitle, 50);
$postDescription = bricklyTrim($post->description, 115);
$postImage = $post->ImagePost ? bricklyImgUrl($post->PatchIMG()) : bricklyImgUrl('/images/newsletters/subBlog/banner.png');
$readingTime = isset($readingTime) ? (int)$readingTime : 1;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo artículo en el Blog - Brickly Homes</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        @media screen and (max-width: 600px) {
            .wrapper { width: 100% !important; max-width: 100% !important; }
            .px-mobile { padding-left: 20px !important; padding-right: 20px !important; }
            .col-mobile-100 { width: 100% !important; max-width: 100% !important; display: block !important; }
            .text-center-mobile { text-align: center !important; }
            .hero-card-text { padding: 24px 20px !important; width: auto !important; max-width: 100% !important; }
            .hero-card-text h1,
            .hero-card-text p { word-wrap: break-word !important; word-break: break-word !important; }
            .hero-card-table { display: block !important; width: 100% !important; max-width: 100% !important; }
            .hero-card-image { padding-top: 0 !important; }
            .hero-card-image img { border-radius: 0 0 20px 20px !important; width: 100% !important; max-width: 100% !important; height: auto !important; min-height: auto !important; }
            .col-3 { display: block !important; width: 100% !important; max-width: 100% !important; border: none !important; border-bottom: 1px solid #ececec !important; padding: 20px 0 !important; margin-bottom: 0 !important; }
            .col-3:last-child { border-bottom: none !important; }
            .col-related { display: block !important; width: 100% !important; max-width: 100% !important; margin: 0 0 18px 0 !important; }
            .col-related:last-child { margin-bottom: 0 !important; }
            .col-related img { width: 100% !important; max-width: 100% !important; height: auto !important; }
        }
    </style>
</head>
<body style="margin:0; padding:0; background-color:#ffffff; font-family:'Plus Jakarta Sans', 'system-ui', Helvetica, Arial, sans-serif; -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; color:#111111;">

<table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center" width="600" class="wrapper" style="margin:0 auto; background-color:#ffffff; width:600px; max-width:600px;">

    <!-- 1. HEADER -->
    <tr>
        <td class="px-mobile" style="padding: 28px 24px 18px 24px;">
            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                <tr>
                    <td align="left" valign="middle">
                        <a href="https://www.bricklyhomes.com" target="_blank" style="text-decoration:none; display:inline-block;">
                            <img src="<?= bricklyImgUrl('/images/newsletters/logo_negro.png') ?>" alt="Brickly Homes" width="150" style="display:block; border:0; max-width:150px; height:auto;">
                        </a>
                    </td>
                    <td align="right" valign="middle">
                        <img src="<?= bricklyImgUrl('/images/newsletters/newsletter.png') ?>" alt="Email" width="22" height="22" style="display:block; border:0;">
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    <!-- 2. FEATURED POST CARD -->
    <tr>
        <td class="px-mobile" style="padding: 12px 24px 28px 24px;">
            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="background-color:#fafafa; border:1px solid #ececec; border-radius:20px; overflow:hidden;">
                <tr>
                    <td style="padding: 0;">
                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                            <tr>
                                <!-- Texto -->
                                <td class="hero-card-text hero-card-table" valign="top" width="55%" style="width:55%; max-width:55%; padding: 28px 24px 28px 28px; vertical-align: top;">
                                    <span style="display:inline-block; font-size:12px; font-weight:700; color:#111111; letter-spacing:0.3px;">Nuevo artículo en el Blog</span>
                                    <span style="display:block; width:36px; height:2px; background-color:#111111; margin:8px 0 18px 0;"></span>
                                    <h1 style="margin: 0 0 14px 0; font-size: 22px; line-height: 28px; color: #111111; font-weight: 800; letter-spacing:-0.3px; word-wrap:break-word; overflow-wrap:break-word;"><?= Html::encode($postTitle) ?></h1>
                                    <p style="margin: 0 0 22px 0; font-size: 14px; line-height: 22px; color: #555555; font-weight:400; word-wrap:break-word; overflow-wrap:break-word;"><?= Html::encode($postDescription) ?></p>
                                    <table role="presentation" cellspacing="0" cellpadding="0" border="0" style="margin: 0 0 16px 0;">
                                        <tr>
                                            <td align="center" bgcolor="#000000" style="background-color:#000000; border-radius: 999px;">
                                                <a href="<?= bricklyPostUrl($post) ?>" target="_blank" style="padding: 11px 22px; display: block; font-size: 13px; font-weight: 700; color: #ffffff; text-decoration: none; letter-spacing: 0.3px;">
                                                    Leer artículo <span style="display:inline-block; margin-left:6px;">→</span>
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                    <table role="presentation" cellspacing="0" cellpadding="0" border="0">
                                        <tr>
                                            <td valign="middle" style="padding-right:6px; font-size:13px; color:#666666;">
                                                <img src="https://img.icons8.com/ios/50/666666/time.png" alt="" width="14" height="14" style="display:inline-block; vertical-align:middle; border:0;">
                                            </td>
                                            <td valign="middle" style="font-size:13px; color:#666666; font-weight:500;">
                                                <?= $readingTime ?> min de lectura
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <!-- Imagen -->
                                <td class="hero-card-image hero-card-table" valign="top" width="45%" style="width:45%; max-width:45%; padding: 0; vertical-align: top;">
                                    <a href="<?= bricklyPostUrl($post) ?>" target="_blank" style="display:block; text-decoration:none;">
                                        <img src="<?= $postImage ?>" alt="<?= Html::encode($postTitle) ?>" width="270" style="display:block; width:100%; max-width:100%; height:100%; min-height:220px; object-fit:cover; border:0;">
                                    </a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    <!-- 3. ¿QUÉ ENCONTRARÁS? -->
    <tr>
        <td class="px-mobile" style="padding: 8px 24px 14px 24px;">
            <h2 style="margin: 0 0 4px 0; font-size: 20px; line-height: 26px; color: #111111; font-weight: 700; text-align:center; letter-spacing:-0.2px;">¿Qué encontrarás en este artículo?</h2>
        </td>
    </tr>
    <tr>
        <td class="px-mobile" style="padding: 8px 24px 28px 24px;">
            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                <tr>
                    <!-- Información -->
                    <td class="col-3" valign="top" width="33.33%" style="width:33.33%; max-width:33.33%; padding: 18px 14px; text-align:center; vertical-align: top; border-left: 1px solid #ececec;">
                        <div style="font-size: 28px; line-height: 32px; color:#111111; margin-bottom:8px;">
                            <i class="fa-regular fa-house" style="font-style: normal;"></i>
                        </div>
                        <h3 style="margin: 0 0 8px 0; font-size: 14px; line-height: 18px; color: #111111; font-weight: 700;">Información</h3>
                        <p style="margin: 0; font-size: 12.5px; line-height: 18px; color: #555555;">Datos respaldados por análisis del mercado inmobiliario.</p>
                    </td>
                    <!-- Tendencias -->
                    <td class="col-3" valign="top" width="33.33%" style="width:33.33%; max-width:33.33%; padding: 18px 14px; text-align:center; vertical-align: top; border-left: 1px solid #ececec; border-right: 1px solid #ececec;">
                        <div style="font-size: 28px; line-height: 32px; color:#111111; margin-bottom:8px;">
                            <i class="fa-regular fa-chart-column" style="font-style: normal;"></i>
                        </div>
                        <h3 style="margin: 0 0 8px 0; font-size: 14px; line-height: 18px; color: #111111; font-weight: 700;">Tendencias</h3>
                        <p style="margin: 0; font-size: 12.5px; line-height: 18px; color: #555555;">Conoce qué zonas presentan mayor crecimiento.</p>
                    </td>
                    <!-- Recomendaciones -->
                    <td class="col-3" valign="top" width="33.33%" style="width:33.33%; max-width:33.33%; padding: 18px 14px; text-align:center; vertical-align: top; border-right: 1px solid #ececec;">
                        <div style="font-size: 28px; line-height: 32px; color:#111111; margin-bottom:8px;">
                            <i class="fa-regular fa-lightbulb" style="font-style: normal;"></i>
                        </div>
                        <h3 style="margin: 0 0 8px 0; font-size: 14px; line-height: 18px; color: #111111; font-weight: 700;">Recomendaciones</h3>
                        <p style="margin: 0; font-size: 12.5px; line-height: 18px; color: #555555;">Consejos prácticos para compradores e inversionistas.</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    <!-- 4. TAMBIÉN TE PUEDE INTERESAR -->
    <?php if (!empty($relatedPosts)): ?>
    <tr>
        <td class="px-mobile" style="padding: 8px 24px 14px 24px;">
            <h2 style="margin: 0; font-size: 20px; line-height: 26px; color: #111111; font-weight: 700; text-align:center; letter-spacing:-0.2px;">También te puede interesar</h2>
        </td>
    </tr>
    <tr>
        <td class="px-mobile" style="padding: 8px 24px 32px 24px; font-size: 0; text-align: center;">
            <?php foreach ($relatedPosts as $idx => $rel):
                $relTitle = !empty($rel->title) ? $rel->title : ($rel->VTitle ?: $rel->Title);
                $relTitle = bricklyTrim($relTitle, 50);
                $relDescription = bricklyTrim($rel->description, 115);
                $relImage = $rel->ImagePost ? bricklyImgUrl($rel->PatchIMG()) : bricklyImgUrl('/images/newsletters/subBlog/banner.png');
                $marginLeft = $idx > 0 ? '8px' : '0';
            ?>
            <table role="presentation" cellspacing="0" cellpadding="0" border="0" align="left" width="170" class="col-related" style="display:inline-block; width:170px; max-width:170px; vertical-align: top; text-align:left; margin-left: <?= $marginLeft ?>; border-collapse:collapse;">
                <tr>
                    <td style="padding: 0;">
                        <a href="<?= bricklyPostUrl($rel) ?>" target="_blank" style="display:block; text-decoration:none;">
                            <img src="<?= $relImage ?>" alt="<?= Html::encode($relTitle) ?>" width="170" style="display:block; width:100%; max-width:170px; height:110px; object-fit:cover; border-radius:10px; border:0;">
                            <h3 style="margin: 12px 0 6px 0; font-size: 14px; line-height: 18px; color: #111111; font-weight: 700;"><?= Html::encode($relTitle) ?></h3>
                            <p style="margin: 0 0 8px 0; font-size: 12px; line-height: 17px; color: #555555;"><?= Html::encode($relDescription) ?></p>
                            <span style="font-size: 12.5px; color: #111111; font-weight: 700; text-decoration: underline;">Leer <span style="display:inline-block; margin-left:2px;">→</span></span>
                        </a>
                    </td>
                </tr>
            </table>
            <?php endforeach; ?>
        </td>
    </tr>
    <?php endif; ?>

    <!-- 5. EXPLORA MÁS CONTENIDO -->
    <tr>
        <td class="px-mobile" style="padding: 0 24px 28px 24px;">
            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="background-color:#fafafa; border:1px solid #ececec; border-radius:16px;">
                <tr>
                    <td align="center" style="padding: 28px 24px;">
                        <h2 style="margin: 0 0 8px 0; font-size: 20px; line-height: 26px; color: #111111; font-weight: 700; letter-spacing:-0.2px;">Explora más contenido</h2>
                        <p style="margin: 0 0 18px 0; font-size: 13.5px; line-height: 20px; color: #555555; max-width: 420px;">Mantente informado con las últimas noticias, guías y tendencias del sector inmobiliario.</p>
                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" style="margin: 0 auto;">
                            <tr>
                                <td align="center" bgcolor="#000000" style="background-color:#000000; border-radius: 999px;">
                                    <a href="https://blog.bricklyhomes.com/" target="_blank" style="padding: 12px 32px; display: block; font-size: 13.5px; font-weight: 700; color: #ffffff; text-decoration: none; letter-spacing: 0.3px;">Ir al Blog</a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    <!-- 6. SOPORTE -->
    <tr>
        <td class="px-mobile" style="padding: 35px 20px 40px 20px; font-size: 0;">

            <!-- ¿Dudas? -->
            <div class="col-mobile-100" style="display: inline-block; width: 100%; max-width: 270px; vertical-align: top; font-size: 14px; margin-bottom: 20px;">
                <table role="presentation" cellspacing="0" cellpadding="0" border="0">
                    <tr>
                        <td style="vertical-align: middle; padding-right: 14px;">
                            <img src="<?= bricklyImgUrl('/images/newsletters/Ayuda.png') ?>" alt="Dudas" width="36" height="36" style="display:block; border:0;">
                        </td>
                        <td style="vertical-align: middle;">
                            <p style="margin:0; font-size:14px; font-weight:bold; color:#111111;">¿Dudas?</p>
                            <p style="margin:3px 0 0 0; font-size:13px; color:#555555; line-height:18px;">Estamos aquí para ayudarte. <br /> <a href="https://wa.me/50237649719?text=%C2%A1Hola!%20Deseo%20contactar%20a%20un%20asesor." target="_blank" style="color:#111111; font-weight:bold; text-decoration:underline;">Contáctanos</a></p>
                        </td>
                    </tr>
                </table>
            </div>

            <!-- Tu cuenta -->
            <div class="col-mobile-100" style="display: inline-block; width: 100%; max-width: 270px; vertical-align: top; font-size: 14px;">
                <table role="presentation" cellspacing="0" cellpadding="0" border="0">
                    <tr>
                        <td style="vertical-align: middle; padding-right: 14px;">
                            <img src="<?= bricklyImgUrl('/images/newsletters/Cuenta.png') ?>" alt="Cuenta" width="36" height="36" style="display:block; border:0;">
                        </td>
                        <td style="vertical-align: middle;">
                            <p style="margin:0; font-size:14px; font-weight:bold; color:#111111;">Tu cuenta</p>
                            <p style="margin:3px 0 0 0; font-size:13px; color:#555555; line-height:18px;">Inicia sesión para gestionar tus preferencias. <br /> <a href="https://www.bricklyhomes.com/login" target="_blank" style="color:#111111; font-weight:bold; text-decoration:underline;">Inicia sesión</a></p>
                        </td>
                    </tr>
                </table>
            </div>

        </td>
    </tr>

    <!-- 7. FOOTER -->
    <tr>
        <td style="background-color: #1a2129; padding: 35px 20px;">
            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                <tr>
                    <td style="font-size: 0; padding-bottom: 20px;">

                        <div class="col-mobile-100 text-center-mobile" style="display: inline-block; width: 100%; max-width: 280px; vertical-align: middle; margin-bottom: 20px;">
                            <a href="https://www.bricklyhomes.com" target="_blank">
                                <img src="<?= bricklyImgUrl('/images/newsletters/logo_blanco.png') ?>" alt="Brickly Homes" width="140" style="border:0; display: inline-block;">
                            </a>
                        </div>

                        <div class="col-mobile-100 text-center-mobile" style="display: inline-block; width: 100%; max-width: 280px; vertical-align: middle; text-align: right; margin-bottom: 20px;">
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0" style="display:inline-block;">
                                <tr>
                                    <td style="padding: 0 10px;"><a href="https://wa.me/50237649719" target="_blank"><img src="<?= bricklyImgUrl('/images/newsletters/WS.png') ?>" alt="WhatsApp" width="18" height="18"></a></td>
                                    <td style="padding: 0 8px;"><a href="https://www.instagram.com/bricklyoficial/" target="_blank"><img src="<?= bricklyImgUrl('/images/newsletters/IG.png') ?>" alt="Instagram" width="18" height="18"></a></td>
                                    <td style="padding: 0 8px;"><a href="https://www.linkedin.com/company/bricklygt/" target="_blank"><img src="<?= bricklyImgUrl('/images/newsletters/IN.png') ?>" alt="LinkedIn" width="18" height="18"></a></td>
                                    <td style="padding: 0 8px;"><a href="https://www.tiktok.com/@bricklyhomes" target="_blank"><img src="<?= bricklyImgUrl('/images/newsletters/TT.png') ?>" alt="TikTok" width="18" height="18"></a></td>
                                </tr>
                            </table>
                        </div>

                    </td>
                </tr>
                <tr>
                    <td align="center" style="border-top: 1px solid #2d3743; padding-top: 20px; font-size: 12px; color: #a0aec0; line-height: 18px;">
                        <p style="margin: 0 0 8px 0;">© Brickly. Todos los derechos reservados <?= date('Y') ?></p>
                        <p style="margin: 0; font-size: 11px;">¿No quieres recibir más correos? <a href="#" style="color:#ffffff; text-decoration:underline;">Darse de baja</a></p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

</table>
</body>
</html>
