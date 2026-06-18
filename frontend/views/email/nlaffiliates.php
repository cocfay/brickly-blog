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
            max-width:600px;
            margin: auto;
            /* background-color: #2C2A2A; */
            color: #fff;
            /* border-radius: 30px 30px 0 0; */
            padding-bottom: .1px;
            font-family: Arial;
            overflow: hidden;
        }
        .banner{
            width: 100%;
            display: block
        }
        .conteBody{
            margin: 100px auto;
            width: 95%;
            box-sizing: border-box; 
            font-weight: light;
        }
        .section-cards{
            display: block;
        }
        .movil-cards{
            display: none;
        }
        .cards{
            /* margin-bottom: 50px; */
            margin-top: 3rem;
            width: 100%;
            background: #F6F6F6;
        }
        .cards > div{
            display: inline-block;
            width: 49%;
            vertical-align: middle;
        }
        .centrado {
            box-sizing: border-box;
        }
        .centrado ul{
            font-size: 18px;
        }
        li::marker{
            color: #FF0461;
        }
        .footer{
            /* dispay: inline-block; */
            /* margin-top: 5rem; */
            background-color: #000000;
            box-sizing: border-box; 
            padding: 50px;
            position: relative;
            z-index: 10;
            font-size: 1.5rem;
        }
        .footer table td{
            padding: 0 12px;
        }
        .text1{
            font-size: 3rem;
        }
        .text3{
            font-size: 1.3rem;
        }

        .row{
            width: 100%;
        }
        .row .col-md-6{
            display: block;
           /*  width: calc(50% - 50px); */
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
            .contenedor, .conteBody{
                width: 100%;
            }
            .conteBody{
                margin: 30px auto;
                padding: 0 2rem;
            }
            .cards{
                margin: auto;
            }
            .cards > div{
                display: block;
                width: 100%;
            }
            .cards .item2 div{
                margin: auto;
                margin-bottom: 3rem;
            }
            .cards .item2 div{
                margin: auto;
                margin-bottom: 3rem;
            }
            .centrado ul{
                font-size: 16px;
            }
            .cards img{
                margin: auto auto 1.5rem;
            }
            .section-cards{
                display: none;
            }
            .movil-cards{
                display: block;
            }

            .text1{
             font-size: 2rem;
            }
            .text3{
                font-size: 1.3rem;
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
        <img src="<?= uri('/images/email/banner2.png') ?>" class="banner" alt="banner">
        <div style="text-align: center; background: black; box-sizing: border-box; padding: 2rem;">
            <div class="text1" style="font-weight: 700; line-height: 1.1;">¡Hemos recibido tu CV! <br> Estamos revisando tu aplicación.</div>
        </div>
        <div class="conteBody">
            <div style="text-align:center; color: black; margin-top: 4rem;">
                <div style="font-size: 2.4rem; color: #FF0461; font-weight: 700; margin-bottom: 1.8rem;">¡Hola <?= $datos->Name ?>!</div>
                <div class="text3" style="line-height: 1.2;">
                    ¡Muchas gracias por mostrar interés en formar parte de nuestro equipo de <?= $datos->Type == 'seller' ? 'ventas' : 'trabajo' ?>! Valoramos el tiempo que has dedicado a completar el formulario y queremos informarte que estamos revisando cuidadosamente cada aplicación.
                </div>
            </div>
        </div>
        <div class="cards">
            <div class="item1"><img src="<?= uri('/images/email/quesigue.png') ?>" style="width: 100%;" class="" alt=""></div>
            <div class="item2">
               <!--  <div style="background: #220342; box-sizing: border-box; padding: 6rem 2rem 2rem 2rem; width: 90%; height: 340px; z-index: 10; border-radius: 6px;">
                    
                    <div style="margin-bottom: 2rem; font-size: 1.8rem; font-weight: 700;">¡MANTENTE ATENTO!</div>
                    <div style="font-size: 1.2rem;">Si eres seleccionado/a, recibirás un correo o llamada de nuestro equipo de reclutamiento para coordinar los siguientes pasos.</div>
                </div> -->
                <div style="background-image: url(<?= uri('/images/email/fondo.png') ?>); min-height: 380px; width: 93%; background-repeat: no-repeat; background-size: cover;">
                    <div style="width: 86%; margin: auto;">
                        <div style="padding-top: 10.5rem; margin-bottom: 1rem; font-size: 1.2rem; font-weight: 700;">¡MANTENTE ATENTO!</div>
                        <div>Si eres seleccionado/a, recibirás un correo o llamada de nuestro equipo de reclutamiento para coordinar los siguientes pasos.</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div style="background: #F6F6F6; position: relative; min-height: 650px;">
            <img src="<?= uri('/images/email/quesigue.png') ?>" style="width: 60%; position: absolute; top:0; left: -8%;" class="" alt="">
            <div style="background: #220342; box-sizing: border-box; padding: 6rem 2rem 2rem 2rem; width: 600px; height: 400px; z-index: 10; position: absolute; top: 50%; right: 0; transform: translate(-15%, -50%); border-radius: 6px;">
                <img src="<?= uri('/images/email/atencion.png') ?>" style="width: 140px;transform: translate(-60%, -50%);position: absolute;top: 0;left: 50%;" class="" alt="">
                <div style="margin-bottom: 2rem; font-size: 3rem; font-weight: 700;">¡MANTENTE ATENTO!</div>
                <div style="font-size: 1.8rem;">Si eres seleccionado/a, recibirás un correo o llamada de nuestro equipo de reclutamiento para coordinar los siguientes pasos.</div>
            </div>
        </div> -->
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