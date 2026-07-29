<?php
use yii\helpers\Html;
use yii\helpers\Url;

function imgUrl($path) {
    $base = Yii::$app->params['blogBaseUrl'] ?? 'https://www.bricklyhomes.com/blog';
    return $base . '/' . ltrim($path, '/');
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?= Html::csrfMetaTags() ?>
    <title>¡Gracias por suscribirte a nuestro blog! - Brickly Homes</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;700&display=swap');
        @media screen and (max-width: 600px) {
            .wrapper { width: 100% !important; max-width: 100% !important; }
            .col-mobile-100 { width: 100% !important; max-width: 100% !important; display: block !important; }
            .col-33 { width: 100% !important; max-width: 100% !important; display: block !important; margin-bottom: 30px !important; border-left: none !important; border-right: none !important; border-bottom: 1px solid #e0e0e0; padding-bottom: 20px !important; }
            .col-33:last-child { border-bottom: none !important; margin-bottom: 0 !important; }
            .hide-mobile { display: none !important; }
            .padding-mobile { padding: 30px 20px !important; }
            .text-center-mobile { text-align: center !important; }
            .img-full { width: 100% !important; height: auto !important; }
            .hero-img-container { text-align: center !important; }
            .hero-img-container img { border-radius: 0 0 24px 24px !important; width: 100% !important; max-width: 100% !important; }
        }
    </style>
</head>
<body style="margin:0; padding:0; background-color:#ffffff; font-family:'Plus Jakarta Sans', 'system-ui', Helvetica, Arial, sans-serif; -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%;">

    <table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center" width="600" class="wrapper" style="margin:0 auto; background-color:#ffffff; width:600px; max-width:600px;">
        
        <!-- 1. HEADER (LOGOTIPO) -->
        <tr>
            <td style="padding: 30px 20px;">
                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                    <tr>
                        <td align="left">
                            <a href="https://www.bricklyhomes.com" target="_blank">
                                <img src="<?= imgUrl('/images/newsletters/logo_negro.png') ?>" alt="Brickly Homes" width="160" style="display:block; border:0; font-family:sans-serif; font-size:18px; line-height:20px; color:#111111; font-weight:bold;">
                            </a>
                        </td>
                        <td align="right" style="vertical-align: middle;">
                            <img src="<?= imgUrl('/images/newsletters/newsletter.png') ?>" alt="Suscripción" width="28" height="28" style="display:block; border:0;">
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <!-- 2. BLOQUE BIENVENIDA (Fijado en escritorio / Apilado en móvil) -->
        <tr>
            <td style="padding: 0 20px 40px 20px;">
                <div style="background-color:#fdfcfc; border: 1px solid #f2f2f2; border-radius: 24px; overflow: hidden; max-width: 560px;">
                    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                        <tr>
                            <!-- Texto de Bienvenida -->
                            <td class="col-mobile-100" width="260" style="width: 260px; max-width: 260px; vertical-align: middle; font-size: 14px;">
                                <div class="padding-mobile" style="padding: 40px 25px 40px 30px;">
                                    <h1 style="margin: 0 0 20px 0; font-size: 26px; line-height: 34px; color: #111111; font-weight: 700;">¡Gracias por suscribirte a nuestro blog!</h1>
                                    <p style="margin: 0 0 20px 0; font-size: 14px; line-height: 22px; color: #444444; font-weight: 500;">Tu suscripción se ha realizado correctamente.</p>
                                    <p style="margin: 0; font-size: 14px; line-height: 22px; color: #666666;">Recibirás artículos, consejos y novedades sobre el mundo inmobiliario.</p>
                                </div>
                            </td>
                            <!-- Imagen de Portada (Sala de Estar) -->
                            <td class="col-mobile-100 hero-img-container" width="300" style="width: 300px; max-width: 300px; vertical-align: top;">
                                <img src="<?= imgUrl('/images/newsletters/subBlog/banner.png') ?>" alt="Brickly Blog" width="300" style="display:block; width:100%; max-width: 300px; height:auto; border:0;">
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>

        <!-- 3. TÍTULO INTERMEDIO -->
        <tr>
            <td align="center" style="padding: 10px 20px 35px 20px;">
                <h2 style="margin: 0; font-size: 26px; line-height: 32px; color: #111111; font-weight: 700;">¿Qué puedes esperar?</h2>
            </td>
        </tr>

        <!-- 4. SECCIÓN 3 COLUMNAS -->
        <tr>
            <td style="padding: 0 20px 50px 20px; font-size: 0; text-align: center;">
                
                <!-- Columna 1: Artículos exclusivos -->
                <div class="col-33" style="display: inline-block; width: 100%; max-width: 180px; vertical-align: top; font-size: 13px;">
                    <img src="<?= imgUrl('/images/newsletters/subBlog/articulos.png') ?>" alt="Artículos" width="40" height="40" style="display:inline-block; margin-bottom:15px;">
                    <h3 style="margin: 0 0 12px 0; font-size: 15px; line-height: 18px; color: #111111; font-weight: 700;">Artículos exclusivos</h3>
                    <p style="margin: 0; font-size: 13px; line-height: 20px; color: #555555; padding: 0 5px;">Contenido de valor sobre bienes raíces, inversiones y estilo de vida.</p>
                </div>
                
                <!-- Columna 2: Consejos prácticos -->
                <div class="col-33" style="display: inline-block; width: 100%; max-width: 198px; vertical-align: top; font-size: 13px; border-left: 1px solid #e2e8f0; border-right: 1px solid #e2e8f0;">
                    <img src="<?= imgUrl('/images/newsletters/subBlog/tendencias.png') ?>" alt="Consejos" width="40" height="40" style="display:inline-block; margin-bottom:15px;">
                    <h3 style="margin: 0 0 12px 0; font-size: 15px; line-height: 18px; color: #111111; font-weight: 700;">Consejos prácticos</h3>
                    <p style="margin: 0; font-size: 13px; line-height: 20px; color: #555555; padding: 0 10px;">Ideas y recomendaciones para tomar decisiones inteligentes.</p>
                </div>
                
                <!-- Columna 3: Novedades del sector -->
                <div class="col-33" style="display: inline-block; width: 100%; max-width: 180px; vertical-align: top; font-size: 13px;">
                    <img src="<?= imgUrl('/images/newsletters/subBlog/novedades.png') ?>" alt="Novedades" width="40" height="40" style="display:inline-block; margin-bottom:15px;">
                    <h3 style="margin: 0 0 12px 0; font-size: 15px; line-height: 18px; color: #111111; font-weight: 700;">Novedades del sector</h3>
                    <p style="margin: 0; font-size: 13px; line-height: 20px; color: #555555; padding: 0 5px;">Tendencias, proyectos y noticias que te mantendrán informado.</p>
                </div>
            </td>
        </tr>

        <!-- 5. BLOQUE LLAMADO A LA ACCIÓN -->
        <tr>
            <td align="center" style="padding: 10px 20px 45px 20px; border-bottom: 1px solid #efefef;">
                <h2 style="margin: 0 0 12px 0; font-size: 26px; line-height: 32px; color: #111111; font-weight: 700;">Explora nuestro blog ahora</h2>
                <p style="margin: 0 0 25px 0; font-size: 15px; line-height: 22px; color: #444444; max-width: 440px;">Descubre los últimos artículos y mantente al día con lo mejor del mundo inmobiliario.</p>
                
                <table role="presentation" cellspacing="0" cellpadding="0" border="0" style="margin: 0 auto;">
                    <tr>
                        <td align="center" style="background-color: #000000; border-radius: 25px;">
                            <a href="<?= Yii::$app->params['blogBaseUrl'] ?? 'https://www.bricklyhomes.com/blog' ?>" target="_blank" style="padding: 14px 45px; display: block; font-size: 15px; font-weight: bold; color: #ffffff; text-decoration: none; letter-spacing: 0.5px;">Ir al blog</a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <!-- 6. SECCIÓN DE SOPORTE / CUENTA -->
        <tr>
            <td style="padding: 35px 20px 40px 20px; font-size: 0;">
                
                <!-- ¿Dudas? -->
                <div class="col-mobile-100" style="display: inline-block; width: 100%; max-width: 270px; vertical-align: top; font-size: 14px; margin-bottom: 20px;">
                    <table role="presentation" cellspacing="0" cellpadding="0" border="0">
                        <tr>
                            <td style="vertical-align: middle; padding-right: 14px;">
                                <img src="<?= imgUrl('/images/newsletters/Ayuda.png') ?>" alt="Dudas" width="36" height="36" style="display:block;">
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
                                <img src="<?= imgUrl('/images/newsletters/Cuenta.png') ?>" alt="Cuenta" width="36" height="36" style="display:block;">
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

        <!-- 7. FOOTER OSCURO -->
        <tr>
            <td style="background-color: #1a2129; padding: 35px 20px;">
                <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                    <tr>
                        <td style="font-size: 0; padding-bottom: 20px;">
                            
                            <!-- Logo Blanco -->
                            <div class="col-mobile-100 text-center-mobile" style="display: inline-block; width: 100%; max-width: 280px; vertical-align: middle; margin-bottom: 20px;">
                                <a href="https://www.bricklyhomes.com" target="_blank">
                                    <img src="<?= imgUrl('/images/newsletters/logo_blanco.png') ?>" alt="Brickly Homes" width="140" style="border:0; display: inline-block;">
                                </a>
                            </div>
                            
                            <!-- Redes Sociales -->
                            <div class="col-mobile-100 text-center-mobile" style="display: inline-block; width: 100%; max-width: 280px; vertical-align: middle; text-align: right; margin-bottom: 20px;">
                                <table role="presentation" cellspacing="0" cellpadding="0" border="0" style="display:inline-block;">
                                    <tr>
                                        <td style="padding: 0 10px;"><a href="https://www.facebook.com/profile.php?id=61588999228778" target="_blank"><img src="<?= imgUrl('/images/newsletters/FB.png') ?>" alt="Facebook" width="20" height="20"></a></td>
                                        <td style="padding: 0 8px;"><a href="https://wa.me/50237649719" target="_blank"><img src="<?= imgUrl('/images/newsletters/WS.png') ?>" alt="WhatsApp" width="18" height="18"></a></td>
                                        <td style="padding: 0 8px;"><a href="https://www.instagram.com/bricklyoficial/" target="_blank"><img src="<?= imgUrl('/images/newsletters/IG.png') ?>" alt="Instagram" width="18" height="18"></a></td>
                                        <td style="padding: 0 8px;"><a href="https://www.linkedin.com/company/bricklygt/" target="_blank"><img src="<?= imgUrl('/images/newsletters/IN.png') ?>" alt="LinkedIn" width="18" height="18"></a></td>
                                        <td style="padding: 0 8px;"><a href="https://www.tiktok.com/@bricklyhomes" target="_blank"><img src="<?= imgUrl('/images/newsletters/TT.png') ?>" alt="TikTok" width="18" height="18"></a></td>
                                    </tr>
                                </table>
                            </div>
                            
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="border-top: 1px solid #2d3743; padding-top: 20px; font-size: 12px; color: #a0aec0; line-height: 18px;">
                            <p style="margin: 0 0 8px 0;">© Brickly. Todos los derechos reservados 2026</p>
                            <p style="margin: 0; font-size: 11px;">¿No quieres recibir más correos? <a href="#" style="color:#ffffff; text-decoration:underline;">Darse de baja</a></p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

    </table>

<script>
    document.getElementById('subscribe-form').addEventListener('submit', async function (e) {
        e.preventDefault();
        console.log('1 - submit interceptado');

        const email = document.getElementById('subscribe-email').value.trim();
        const msgEl = document.getElementById('subscribe-message');
        const btn = this.querySelector('button');

        const showMsg = (text, color) => {
            msgEl.style.color = color;
            msgEl.textContent = text;
            setTimeout(() => { msgEl.textContent = ''; }, 2000);
        };

        if (!email) return;

        msgEl.textContent = '';
        btn.disabled = true;
        btn.textContent = 'Enviando...';

        const formData = new FormData();
        formData.append('email', email);

        try {
            const response = await fetch('<?= Url::to(['/newsletter/subscribe']) ?>', {
                method: 'POST',
                body: formData
            });

            const result = await response.json();

            if (response.ok && result.success) {
                showMsg('Gracias por suscribirte a nuestro blog.', '#198754');
                document.getElementById('subscribe-email').value = '';
            } else if (response.status === 409) {
                showMsg('El correo ya existe.', '#dc3545');
            } else {
                showMsg(result.message || 'Error al procesar.', '#dc3545');
            }
        } catch (error) {
            showMsg('Error de conexión.', '#dc3545');
        } finally {
            btn.disabled = false;
            btn.textContent = 'Suscribirme';
        }
    });
</script>
</body>
</html>