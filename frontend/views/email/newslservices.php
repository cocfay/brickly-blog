<?php
    use yii\helpers\Url;

    function uri($link){
        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
        $isEmailClient = false;

        // Lista de patrones comunes en User-Agent de clientes de correo
        $emailClients = [
            'GoogleImageProxy', // Gmail
            'Microsoft Outlook',
            'Apple Mail',
            'Thunderbird',
            'MailClient',
        ];

        foreach ($emailClients as $client) {
            if (stripos($userAgent, $client) !== false) {
                $isEmailClient = true;
                break;
            }
        }

        //$links = ($isEmailClient) ? Url::to([$link], true) : Yii::getAlias("@web").$link;
        $links = Url::to([$link], true);

        return $links;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        *{
            margin: 0;
            padding: 0;
        }
        body{
            background-color: #E6E8EC;
        }
        .banner{
            width: 100%;
        }
        .contenedor{
            width: 100%;
            max-width: 600px;
            margin: auto;
            background-color: #212020ff;
            color: #fff;
            padding-bottom: .1px;
            font-family: Arial;
        }
        .conteBody{
            margin: 30px auto;
            width: 95%;
            max-width: 520px;
            box-sizing: border-box; 
            font-weight: light;
        }
        .bgFondo{
            background-image: url(<?= uri('/images/email/ms/fondo.png') ?>); 
            min-height: 426px; 
            width: 100%; 
            background-repeat: no-repeat; 
            background-size: 100%;
        }
        .fondoContenido{
            position: relative;
            top: 100px;
            padding: 0 3rem;
            margin-bottom: 4rem;
            
        }
        ul{
            margin-top: 1rem;
            padding-left: 15px;
            line-height: 1.7;
        }

        ul li::marker{
            color: #c217c2ff;
        }

        .footer{
            background-color: #000000;
            box-sizing: border-box; 
            padding: 0 50px 50px 50px;
            position: relative;
            z-index: 10;
            font-size: 1rem;
        }

        @media screen and (max-width: 600px) {
            .fondoContenido{
                padding: 0 1.3rem;
                top: 70px;
            }
            .bgFondo{
                background-size: 100% 100%;
                background-position: 100%;
                background-color: #212020ff /* Color de respaldo */
                position: relative;
            }

            .footer{
                text-align: center;
                padding: 0 1.3rem 50px 1.3rem;
            }

            .footer td {
                display: inline-table;
            }

            .footer table table{
                text-align: center;
            }
        
        }
    </style>
</head>
<body>
    <div class="contenedor">
        <img src="<?= uri('/images/email/ms/banner.png') ?>" class="banner" alt="banner">
        <div class="conteBody">
            <div style="text-align:center; color: white; margin-top: 2rem;">
                <div style="font-size: 2rem; font-weight: 700; margin-bottom: 1.8rem;">¡<?= $lang == 'es' ? 'Hola' : 'Hello' ?> <?= $datos->Name ?>!</div>
                <div class="text3" style="line-height: 1.2;">
                    <div style="margin-bottom: 1.3rem;"><?= $lang == 'es' ? 'Hemos recibido tu solicitud. ¡Gracias por confiar en nosotros nuevamente!' : 'We\'ve received your request. Thank you for trusting us again!' ?></div>
                    <div><?= $lang == 'es' ? 'Hemos registrado tu solicitud de servicio de Monitoreo y Seguridad. Nuestro equipo ya está revisando los detalles para ofrecerte la mejor solución adaptada a tus necesidades.' : 'We\'ve registered your Monitoring and Security service request. Our team is reviewing the details to offer you the best solution tailored to your needs.' ?></div>
                </div>  
            </div>
        </div>
        <div class="bgFondo">
            <div class="fondoContenido">
                <div><?= $lang == 'es' ? 'Un asesor especializado se contactará contigo en las próximas 24 horas para:' : 'A specialized advisor will contact you in the next 24 hours to:' ?></div>
                <ul>
                    <li><?= $lang == 'es' ? 'Validar los requerimientos específicos.' : 'Validate specific requirements.' ?></li>
                    <li><?= $lang == 'es' ? 'Coordinar tiempos y formalizar el proceso.' : 'Coordinate times and formalize the process.' ?></li>
                    <li><?= $lang == 'es' ? 'Resolver cualquier duda que tengas.' : 'Resolve any questions you may have.' ?></li>
                </ul>
                <div style="margin-top: 2rem;"><?= $lang == 'es' ? 'Mientras tanto, puedes revisar más información sobre nuestros servicios en' : 'In the meantime, you can check out more information about our services at' ?> <a href="http://www.weclickdigital.com/services" target="_blank" style="color: #c217c2ff; text-decoration: none;">www.weclickdigital.com/services</a></div>
                <div style="margin: 2rem 0;">
                    <div style="display: inline-table; vertical-align: middle;"><?= $lang == 'es' ? 'o escribirnos a directamente a nuestro' : 'or write to us directly at our' ?> </div>
                    <a href="https://api.whatsapp.com/send?phone=50258634559&amp;text=Hola%2C+quiero+contactar+a+un+asesor." target="_blank" style="height: 100%; display: inline-table; vertical-align: middle;">
                        <img src="<?= uri('/images/email/ms/ws.png') ?>" alt="whatsapp" style="width: 45px" srcset="">
                    </a>
                </div>
            </div>
        </div>
        <div class="footer">
            <table style="width: 100%">
                <td style="width: 50%;"><a href="https://www.weclickdigital.com" target="_blank" rel="noopener noreferrer" style="color: white; text-decoration: none;">www.weclickdigital.com</a></td>
                <td style="width: 50%;" align="right">
                    <table style="vertical-align: middle; width: 100%;">
                        <td style="">
                            <div><?= $lang == 'es' ? '¡Síguenos!' : 'Follow us!' ?></div> 
                        </td>
                        <td style="">
                            <div class="redes">
                                <div style="display: inline-block"><a href="https://www.instagram.com/weclick.digital/" target="_blank"><img src="<?= uri('/images/icons/IGlila.png') ?>" alt="redes" srcset="" style="width: 25px;"></a></div>
                                <div style="display: inline-block"><a href="https://www.facebook.com/WeclickDigital" target="_blank"><img src="<?= uri('/images/icons/FBlila.png') ?>" alt="redes" srcset="" style="width: 25px;"></a></div>
                                <div style="display: inline-block"><a href="https://www.linkedin.com/company/weclick-digital/" target="_blank"><img src="<?= uri('/images/icons/INlila.png') ?>" alt="redes" srcset="" style="width: 25px;"></a></div>
                                <div style="display: inline-block"><a href="https://api.whatsapp.com/send?phone=50258634559&text=Hola%2C+quiero+contactar+a+un+asesor." target="_blank"><img src="<?= uri('/images/icons/whatsapp.png') ?>" alt="redes" srcset="" style="width: 25px;"></a></div>
                            </div>
                        </td>
                    </table>    
                </td>
            </table>
        </div>
    </div>
</body>
</html>