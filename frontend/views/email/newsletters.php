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
        .contenedor{
            width: 100%;
            max-width: 600px;
            margin: auto;
            background-color: #2C2A2A;
            color: #fff;
            padding-bottom: .1px;
            font-family: Arial;
        }
        .banner{
            width: 100%;
        }

        .conteBody{
            margin: 30px auto;
            width: 95%;
            box-sizing: border-box; 
            font-weight: light;
        }

        .desktop-card{
            display: block;
        }

        .movil-card{
            display: none;
        }

        .movil-card img{
            width: 100%;
        }

        .movil-card .card-title{
            margin: 1rem 0;
            font-size: 2rem;
        }

        .movil-card .centrado{
            margin-bottom: 3rem;
        }

        .row-card{
            margin: auto;
            width: 90%;
        }

        .row-card td.col-md-6 {
            vertical-align: middle;
        }

        .row-card .col-md-6 img{
            display: block;
            width: 240px;
            aspect-ratio: 4 / 3;
        }

        .row-card .col-md-6 .card-title{
            font-size: 1.3rem;
            margin-bottom: 0.6rem;
        }

        li::marker{
            color: #FF0461;
        }
        
        .footer{
            /* dispay: inline-block; */
            margin-top: 5rem;
            background-color: #000000;
            box-sizing: border-box; 
            padding: 50px;
            font-size: 1.5rem;
        }
        .footer table{
            margin: auto;
        }
        .footer table td{
            padding: 0 12px;
        }
        .row{
            width: 100%;
        }
        .row .col-md-6{
            display: block;
            margin: auto;
            /* width: calc(50% - 50px); */
            vertical-align: middle;
            text-align: center;
        }
        .row .col-md-6 table{
            margin: auto;
        }
        @media screen and (max-width: 600px) {
            html{
                font-size: 12px;
            }
            /* .contenedor, .conteBody{
                width: 100%;
            } */
            .conteBody{
                margin: 30px auto;
                padding: 0 2rem;
            }

            .desktop-card{
                display: none;
            }

            .movil-card{
                display: block;
            }


            .row-card td {
                display: block !important;
                width: 100% !important;
                padding: 10px 0 !important; /* Adjust padding for mobile */
            }
            .row-card td img {
                width: 100% !important;
                height: auto !important;
            }
            .row-card td table td {
                width: 100% !important;
                padding: 0 10px !important; /* Adjust padding for mobile text */
            }
            .row-card td table td:first-child { /* Target the empty column for alignment */
                width: auto !important; /* Allow it to collapse */
                display: none !important; /* Hide it on small screens */
            }
            .row-card .card-title {
                text-align: center !important;
            }
            .row-card ul {
                text-align: left !important; /* Keep list left aligned */
                padding-left: 20px !important;
            }

            .footer td {
                display: inline-table;
            }
            
            .row .col-md-6{
                display: block;
                width: 100%;
                vertical-align: middle;
                text-align: center;
            }
            .row .col-md-6 table{
                margin-top: 1.2rem;
            }
        }
    </style>
</head>
<body>
    <div class="contenedor">
        <img src="<?= uri('/images/email/banner.png') ?>" class="banner" alt="banner">
        <div class="conteBody">
            <img src="<?= uri('/images/home/logo_white.png') ?>" alt="logo" style="width: 130px; display: block; margin: auto;" srcset="">
            <div style="margin-top: 50px; text-align: center">
                <div style="font-size: 2rem; margin-bottom: 1rem;"><?= $lang == 'es' ? '¡Bienvenido!' : 'Welcome!' ?></div>
                <div style="font-size: 1rem; "><?= $lang == 'es' ? 'Estamos emocionados de conectarnos contigo.' : 'We\'re excited to connect with you.' ?></div>
                <div style="font-size: 1rem; margin: 20px 0;"><?= $lang == 'es' ? 'Nos enfocamos en crear soluciones de software personalizadas que se ajusten a las necesidades específicas de nuestros clientes.' : 'We focus on creating customized software solutions that fit our clients specific needs.' ?></div>
                <div style="font-size: 1rem; "><?= $lang == 'es' ? 'Nuestro equipo de expertos en desarrollo de software se estará contactando contigo en breve para conocer más sobre tu proyecto.' : 'Our team of software development experts will be contacting you shortly to learn more about your project.' ?></div>
            </div>
            <hr style="margin: 40px auto 80px; border-color: #FF0461; opacity: 1; width: 50%;">
            <div style="font-size: 1.75rem; text-align: center; margin-bottom: 50px;"><?= $lang == 'es' ? 'Desarrollo de software robusto, seguro y de alta calidad' : 'Development of robust, secure, and high-quality software' ?></div>
            
            <div class="desktop-card">

                <table class="row-card" width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td class="col-md-6" width="50%" valign="top">
                            <img src="<?= uri('/images/email/Post6.png') ?>" alt="" width="100%" style="display: block;">
                        </td>

                        <td class="col-md-6" width="50%" valign="top" style="vertical-align: middle;">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td width="20%"></td>
                                <td width="80%" align="left">
                                    <div class="card-title"><?= $lang == 'es' ? 'Aplicaciones móviles' : 'Mobile applications' ?></div>
                                    <ul>
                                    <li><?= $lang == 'es' ? 'Nativas IOS y Android' : 'Native iOS and Android' ?></li>
                                    <li><?= $lang == 'es' ? 'Híbridas' : 'Hybrids' ?></li>
                                    <li><?= $lang == 'es' ? 'Webs móviles' : 'Mobile websites' ?></li>
                                    </ul>
                                </td>
                            </tr>
                        </table>
                        </td>
                    </tr>
                </table>

                <table class="row-card" style="margin-top: 3rem;" width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td class="col-md-6" width="50%" valign="top">
                            <div class="card-title">e-Commerce</div>
                            <ul>
                                <li><?= $lang == 'es' ? 'Completamente personalizadas a tus necesidades UI/UX' : 'Completely customized to your UI/UX needs' ?></li>
                            </ul>
                        </td>

                        <td class="col-md-6" width="50%" valign="top">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                <td width="20%"></td>
                                    <td width="80%" align="right">
                                        <img src="<?= uri('/images/email/Post4.png') ?>" alt="">
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>

                <table class="row-card" style="margin-top: 3rem;" width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td class="col-md-6" width="50%" valign="top">
                            <img src="<?= uri('/images/email/Post1.png') ?>" alt="">
                        </td>

                        <td class="col-md-6" width="50%" valign="top" style="vertical-align: middle;">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td width="20%"></td>
                                <td width="80%" align="left">
                                    <div class="card-title"><?= $lang == 'es' ? 'Diseño web' : 'Web design' ?></div>
                                    <div>
                                        <ul>
                                            <li><?= $lang == 'es' ? 'Atractivo' : 'Attractive' ?></li>
                                            <li><?= $lang == 'es' ? 'Funcional' : 'Functional' ?></li>
                                            <li><?= $lang == 'es' ? 'Capaces de crear una experiencia de usuario envolvente y efectiva' : 'Able to create an immersive and effective user experience' ?></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        </table>
                        </td>
                    </tr>
                </table>

                <table class="row-card" style="margin-top: 3rem;" width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td class="col-md-6" width="50%" valign="top">
                            <div class="card-title"><?= $lang == 'es' ? 'Software a la medida' : 'Custom software' ?></div>
                            <ul>
                                <li><?= $lang == 'es' ? 'Nos aseguraremos que tu sistema personalizado sea seguro, escalable y fácil de usar' : 'We will ensure that your custom system is secure, scalable and easy to use.' ?></li>
                            </ul>
                        </td>

                        <td class="col-md-6" width="50%" valign="top">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                <td width="20%"></td>
                                    <td width="80%" align="right">
                                        <img src="<?= uri('/images/email/Post3.png') ?>" alt="">
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>

            </div>


             <div class="movil-card">
                <div class="cards">
                    <div><img src="<?= uri('/images/email/Post6.png') ?>" alt=""></div>
                    <div class="centrado">
                        <div class="card-title"><?= $lang == 'es' ? 'Aplicaciones móviles' : 'Mobile applications' ?></div>
                        <div>
                            <ul>
                                <li><?= $lang == 'es' ? 'Nativas IOS y Android' : 'Native iOS and Android' ?></li>
                                <li><?= $lang == 'es' ? 'Híbridas' : 'Hybrids' ?></li>
                                <li><?= $lang == 'es' ? 'Webs móviles' : 'Mobile websites' ?></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="cards">
                    <div><img src="<?= uri('/images/email/Post4.png') ?>" alt="" class="position-right"></div>
                    <div class="centrado">
                        <div class="card-title">e-Commerce</div>
                        <div>
                            <ul>
                                <li><?= $lang == 'es' ? 'Completamente personalizadas a tus necesidades UI/UX' : 'Completely customized to your UI/UX needs' ?></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="cards">
                    <div><img src="<?= uri('/images/email/Post1.png') ?>" alt=""></div>
                    <div class="centrado">
                    <div class="card-title"><?= $lang == 'es' ? 'Diseño web' : 'Web design' ?></div>
                        <div>
                            <ul>
                                <li><?= $lang == 'es' ? 'Atractivo' : 'Attractive' ?></li>
                                <li><?= $lang == 'es' ? 'Funcional' : 'Functional' ?></li>
                                <li><?= $lang == 'es' ? 'Capaces de crear una experiencia de usuario envolvente y efectiva' : 'Able to create an immersive and effective user experience' ?></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="cards">
                    <div><img src="<?= uri('/images/email/Post3.png') ?>" alt="" class="position-right"></div>
                    <div class="centrado">
                        <div class="card-title"><?= $lang == 'es' ? 'Software a la medida' : 'Custom software' ?></div>
                        <div>
                            <ul>
                                <li><?= $lang == 'es' ? 'Nos aseguraremos que tu sistema personalizado sea seguro, escalable y fácil de usar' : 'We will ensure that your custom system is secure, scalable and easy to use.' ?></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="footer">
            <div class="row">
                <div class="col-md-6" style="margin-bottom: 1.2rem;">
                    <a href="https://www.weclickdigital.com" target="_blank" rel="noopener noreferrer" style="color: white; text-decoration: none;">www.weclickdigital.com</a>
                </div>
                <div class="col-md-6">
                    <table style="vertical-align: middle;">
                        <td>
                            <div><?= $lang == 'es' ? '¡Síguenos!' : 'Follow us!' ?></div> 
                        </td>
                        <td>
                            <div class="redes">
                                <div style="display: inline-block"><a href="https://www.instagram.com/weclick.digital/" target="_blank"><img src="<?= uri('/images/icons/IGlila.png') ?>" alt="redes" srcset="" style="width: 30px;"></a></div>
                                <div style="display: inline-block"><a href="https://www.facebook.com/WeclickDigital" target="_blank"><img src="<?= uri('/images/icons/FBlila.png') ?>" alt="redes" srcset="" style="width: 30px;"></a></div>
                                <div style="display: inline-block"><a href="https://www.linkedin.com/company/weclick-digital/" target="_blank"><img src="<?= uri('/images/icons/INlila.png') ?>" alt="redes" srcset="" style="width: 30px;"></a></div>
                                <div style="display: inline-block"><a href="https://api.whatsapp.com/send?phone=50258634559&text=Hola%2C+quiero+contactar+a+un+asesor." target="_blank"><img src="<?= uri('/images/icons/whatsapp.png') ?>" alt="redes" srcset="" style="width: 30px;"></a></div>
                            </div>
                        </td>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>