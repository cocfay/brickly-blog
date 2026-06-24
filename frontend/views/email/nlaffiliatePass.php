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
        /* body{
            background-color: #2C2A2A;
            color: #fff;
        } */
        .contenedor{
            width: 80%;
            margin: auto;
            background-color: #2C2A2A;
            color: #fff;
            border-radius: 30px 30px 0 0;
            padding-bottom: .1px;
            font-family: Arial;
        }
        .banner{
            width: 100%;
        }
        .conteBody{
            margin: 30px auto;
            width: 62%;
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
            margin-bottom: 50px;
        }
        .cards > div{
            display: inline-block;
            width: 49%;
            vertical-align: middle;
            /* height: 250px; */
        }
        .cards img{
            aspect-ratio: 4 / 3; 
            width: 250px; 
            height: 250px;
            display: block
        }
        .cards img.position-right{
            margin-left: auto;
        }
        .centrado {
            /* text-align: center; */
           /*  padding: 0 0 0 20px; */
            box-sizing: border-box;
        }
        .centrado ul{
                font-size: 18px;
            }
        .card-title{
            font-size: 1.75rem;
            margin-bottom: 1rem;
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
        }
        .footer table{
            margin: auto;
        }
        .footer table td{
            padding: 0 12px;
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
            .cards > div{
                display: block;
                width: 100%;
            }
            .centrado ul{
                font-size: 16px;
            }
            .cards img{
                margin: auto auto 1.5rem;
            }
            .cards img.position-right{
                margin-left: auto;
            }
            .section-cards{
                display: none;
            }
            .movil-cards{
                display: block;
            }
        }
    </style>
</head>
<body>
    <div class="contenedor">
        <img src="<?= uri('../images/email/banner.png') ?>" class="banner" alt="banner">
        <div class="conteBody">
            <img src="<?= uri('../images/home/logo_white.png') ?>" alt="logo" style="width: 130px; display: block; margin: auto;" srcset="">
            <div style="margin-top: 50px; text-align: center">
                <div style="font-size: 2rem;">Has sido seleccionado como vendedor, has click <a href="https://dev.mydesk.digital/NewWeclickUp/affiliates/resetpassword?id=<?= urlencode(base64_encode($data->UserName)) ?>" style="text-decoration: none;" target="_blank">aquí</a> para completar tu registro</div>
            </div>
            <hr style="margin: 40px auto 80px; border-color: #FF0461; opacity: 1; width: 50%;">
            <div style="font-size: 1.75rem; text-align: center; margin-bottom: 50px;"><?= $lang == 'es' ? 'Desarrollo de software robusto, seguro y de alta calidad' : 'Development of robust, secure, and high-quality software' ?></div>
        </div>
        <div class="footer">
            <table style="vertical-align: middle;">
                <td>
                    <div style="font-size: 20px;"><?= $lang == 'es' ? '¡Siguenos!' : 'Follow us!' ?></div> 
                </td>
                <td>
                    <div class="redes">
                        <div style="display: inline-block"><a href="#" target="_blank"><img src="<?= uri('../images/icons/IGlila.png') ?>" alt="redes" srcset="" style="width: 30px;"></a></div>
                        <div style="display: inline-block"><a href="#" target="_blank"><img src="<?= uri('../images/icons/FBlila.png') ?>" alt="redes" srcset="" style="width: 30px;"></a></div>
                        <div style="display: inline-block"><a href="#" target="_blank"><img src="<?= uri('../images/icons/INlila.png') ?>" alt="redes" srcset="" style="width: 30px;"></a></div>
                    </div>
                </td>
            </table>
        </div>
    </div>
</body>
</html>