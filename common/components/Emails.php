<?php
namespace common\components;

use Yii;
use yii\base\Component;
use yii\base\View;
use yii\helpers\Url;
use common\models\Tracking;

class Emails extends Component {

    public function sendEmail($data){
        $options =  [
            'from' => ['noreply@weclickdigital.com' => 'Weclick Notificación'],
            'to' => strtolower($data->Email),
            'subject' => 'POS Manager - Weclick Digital'
        ];

        $options = (Object)$options;
            
        $html = 
        '<html lang="es-GT">
        <head>
            <title>POS Manager - Weclick Digital</title>
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <style>
                @media only screen and (max-width: 600px) {
                    .container {
                        width: 100% !important;
                    }
                    .contentList{
                        width: 100% !important;
                    }
                    .imgTable{
                        width: 60% !important;
                    }
                    .content {
                        font-size: 16px !important;
                    }
                    .image {
                        width: 100% !important;
                    }
                }
            </style>
        </head>
        <body style="background-color: #F1F3F8; font-family: Arial, Helvetica, sans-serif; margin: 0; padding: 0;">
            <div class="container" style="margin: auto; width: 50%; max-width: 600px;">
                <img src="'.Url::to('/images/logo.png', true).'" alt="banner" style="display: block; width: 100px; margin: 12px auto;">
                <img src="'.Url::to('/images/emailClient/img4.png', true).'" alt="banner" style="display: block; width: 100%; margin: auto;" class="image">
                <div style="text-align: center; font-weight: bold; color: #0086E4; font-size: 23px; margin: 40px 0;" class="content">¡Hola '.$data->Name.'!</div>
                <div class="contentList" style="width: 80%; margin: auto; margin-bottom: 80px; font-size: 16px;">
                    <div style="margin-bottom: 60px;" class="content">Gracias por contactarnos, tu solicitud estará siendo atendida por uno de nuestros asesores, quien te contactará en un plazo menor a 24 horas.</div>
                    <div style="margin-bottom: 20px; font-size: 16px;" class="content">Con tu nuevo punto de venta tendrás</div>
                    <table style="width: 100%; margin-bottom: 20px;">
                        <tr>
                            <td class="imgTable" style="width: 40%; padding-right: 20px;"><img src="'.Url::to('/images/emailClient/img1.png', true).'" alt="img" style="width: 100%;" class="image"></td>
                            <td style="font-size: 21px; color: #009FBA; font-weight: bold; line-height: 1" class="content">Control de tu inventario<br> en tiempo real</td>
                        </tr>
                    </table>
                    <hr style="margin: 20px 0; border: 1.5px solid #009FBA;">
                    <table style="width: 100%; margin-bottom: 20px;">
                        <tr>
                            <td class="imgTable" style="width: 40%; padding-right: 20px;"><img src="'.Url::to('/images/emailClient/img3.png', true).'" alt="img" style="width: 100%;" class="image"></td>
                            <td style="font-size: 21px; color: #0181E7; font-weight: bold; line-height: 1" class="content">Integración con<br> facturación electrónica</td>
                        </tr>
                    </table>
                    <hr style="margin: 20px 0; border: 1.5px solid #009FBA;">
                    <table style="width: 100%; margin-bottom: 20px;">
                        <tr>
                            <td class="imgTable" style="width: 40%; padding-right: 20px;"><img src="'.Url::to('/images/emailClient/img2.png', true).'" alt="img" style="width: 100%;" class="image"></td>
                            <td style="font-size: 21px; color: #009FBA; font-weight: bold; line-height: 1" class="content">Reporte de transacciones<br> de forma instantánea</td>
                        </tr>
                    </table>
                </div>
                <footer style="background-color: #000000; padding: 25px 0; font-size: 16px;">
                    <div style="text-align: center; color: #ffffff;"><span style="color: #ff014b;">© Weclick Digital.</span> Todos los derechos reservados '.date('Y').'.</div>
                </footer>
            </div>
        </body>
        </html>
        ';
                    
        return Yii::$app->mailer->compose()
        ->setFrom($options->from)
        ->setTo($options->to)
        ->setSubject($options->subject)
        ->setHtmlBody($html)
        ->send();
    }

    public function sendEmailWC($data){
        $infoUs = Yii::$app->LocationLang->info();
        $lang = $infoUs->language->LanguageCode;

        $text = $lang == 'es' ? 'Gracias por ponerte en contacto con nosotros' : 'thank you for contacting us';
        
        $options =  [
            'from' => ['noreply@weclickdigital.com' => 'Weclick Notificación'],
            'to' => strtolower($data->Email),
            'subject' => 'Weclick Digital - ' . $text
        ];

        $options = (Object) $options;


        $view = new View();
        $html = $view->renderFile('@app/views/email/newsletters.php', ['lang' => $lang]);

        return Yii::$app->mailer->compose()
        ->setFrom($options->from)
        ->setTo($options->to)
        ->setSubject($options->subject)
        ->setHtmlBody($html)
        ->send();
    }

    public function NLAffiliate($data){
        $infoUs = Yii::$app->LocationLang->info();
        $lang = $infoUs->language->LanguageCode;

        $text = $lang == 'es' ? 'Envio de CV' : 'Sending CV';
        
        $options =  [
            'from' => ['noreply@weclickdigital.com' => 'Weclick Notificación'],
            'to' => strtolower($data->Email),
            'subject' => 'Weclick Digital - ' . $text
        ];

        $options = (Object) $options;


        $view = new View();
        $html = $view->renderFile('@app/views/email/nlaffiliates.php', ['lang' => $lang, 'datos' => $data]);

        return Yii::$app->mailer->compose()
        ->setFrom($options->from)
        ->setTo($options->to)
        ->setSubject($options->subject)
        ->setHtmlBody($html)
        ->send();
    }

    public function ARPassword($data){
        $infoUs = Yii::$app->LocationLang->info();
        $lang = $infoUs->language->LanguageCode;

        //$text = $lang == 'es' ? 'Envio de CV' : 'Sending CV';
        
        $options =  [
            'from' => ['noreply@weclickdigital.com' => 'Weclick Notificación'],
            'to' => strtolower($data->Email),
            'subject' => 'Weclick Digital - Has sido aceptado',
        ];

        $options = (Object) $options;


        $view = new View();
        $html = $view->renderFile('@app/../frontend/views/email/nlaffiliatePass.php', ['lang' => $lang, 'data' => $data]);

        return Yii::$app->mailer->compose()
        ->setFrom($options->from)
        ->setTo($options->to)
        ->setSubject($options->subject)
        ->setHtmlBody($html)
        ->send();
    }

    public function receiveEmail($data){
        //$EmailTo = ['asnoldoboutto75@gmail.com'];
        $EmailTo = ['cocfay@weclickdigital.com','paola@weclickdigital.com', 'cocfay@gmail.com'];
        $EmailTo = $EmailTo;
    
        $options =  [
            'from' => ['noreply@weclickdigital.com' => 'Weclick Notificación'],
            'to' => $EmailTo,
            'subject' => 'WeclickDigital - Datos de contacto',
        ];

        $options = (Object)$options;
            
        $html = 
        '<html lang="es-GT">
        <head>
            <title>Información del cliente</title>
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            
        </head>
        <body style="background-color: #F1F3F8; font-family: Arial, Helvetica, sans-serif; margin: 0; padding: 0;">
            <div class="container" style="margin: auto; width: 50%; max-width: 600px; margin-bottom: 40px;">
                <h1>Datos de contacto</h1>
                <hr style="margin: 20px 0;">';
            $html .= 
                '<div style="font-size: 24px;"><span style="font-weight: bold">Nombre:</span> '.$data->Name.'</div>
                <div style="font-size: 24px;"><span style="font-weight: bold">Teléfono:</span> '.$data->Phone.'</div>
                <div style="font-size: 24px;"><span style="font-weight: bold">Pais:</span> '.$data->Country.'</div>
                <div style="font-size: 24px;"><span style="font-weight: bold">Correo electrónico:</span> '.$data->Email.'</div>';
                if(!empty($data->Consulta)){
                    $html .= '<div style="font-size: 24px;"><span style="font-weight: bold">Consulta:</span> '.$data->Consulta.'</div>';
                }
            $html .= 
            '</div>
        </body>
        </html>
        ';
                    
        return Yii::$app->mailer->compose()
        ->setFrom($options->from)
        ->setTo($options->to)
        ->setSubject($options->subject)
        ->setHtmlBody($html)
        ->send();
    }

    public function cvEmail($data){
        //$EmailTo = ['asnoldoboutto75@gmail.com'];
        $EmailTo = ['cocfay@weclickdigital.com','paola@weclickdigital.com', 'cocfay@gmail.com'];
        $EmailTo = $EmailTo;
    
        $options =  [
            'from' => ['noreply@weclickdigital.com' => 'Weclick Notificación'],
            'to' => $EmailTo,
            'subject' => 'WeclickDigital - CV recibido',
        ];

        $options = (Object)$options;

        if($data->Type == "seller")
            $tipo = "vendedor";
        elseif($data->Type == "interested_job")
            $tipo = "propuesta de trabajo";

        $html = 
        '<html lang="es-GT">
        <head>
            <title>Información - datos de ' . $tipo . '</title>
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            
        </head>
        <body style="background-color: #F1F3F8; font-family: Arial, Helvetica, sans-serif; margin: 0; padding: 0;">
            <div class="container" style="margin: auto; width: 50%; max-width: 600px; margin-bottom: 40px;">
                <h1>Datos de contacto - ' . $tipo . '</h1>
                <hr style="margin: 20px 0;">';
            $html .= 
                '<div style="font-size: 24px;"><span style="font-weight: bold">Nombre:</span> '.$data->Name.'</div>
                <div style="font-size: 24px;"><span style="font-weight: bold">Teléfono:</span> '.$data->Phone.'</div>
                <div style="font-size: 24px;"><span style="font-weight: bold">Pais:</span> '.$data->Country.'</div>
                <div style="font-size: 24px;"><span style="font-weight: bold">Correo electrónico:</span> '.$data->Email.'</div>
                <a style="font-size: 24px; font-weight: bold;" href="https://www.weclickdigital.com/admin/site/listacvs" target="_blank">Ver CV en el sitio web</a>';
            $html .= 
            '</div>
        </body>
        </html>
        ';
                    
        return Yii::$app->mailer->compose()
        ->setFrom($options->from)
        ->setTo($options->to)
        ->setSubject($options->subject)
        ->setHtmlBody($html)
        ->send();
    }


    public function sendReminderSsl($email, $cont, $url, $title){
        $options =  [
            'from' => ['noreply@weclickdigital.com' => 'Próximo a vencer, certificados'],
            'to' => $email,
            'subject' => 'Weclick Digital - '.$title
        ];

        $options = (Object)$options;
        $html = 
        '<html lang="es-GT">
            <head>
                <title>Weclick Digital - '.$title.'</title>
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
            </head>
            <body style="background-color: #e8eaecff; font-family: Arial, Helvetica, sans-serif; margin: 0; padding: 0;">
                <div style="padding: 14px">
                    <p>Hola,</p>

                    <p>Te escribimos respecto a los siguientes '.$title.':';

                    foreach ($url as $key => $value) {
                        $html .= $value;
                    }

                    $html.='<p>Nuestros registros indican que su fecha de vencimiento está próxima (menos de '.$cont.' días).</p>

                    <p>Para asegurar la continuidad de tu servicio, te recomendamos renovarlo cuanto antes.</p>

                    <p>Recuerda los servicios son importantes para que funcionen los sistemas.</p>

                    <p>¿Necesitas ayuda? Responde a este correo o contacta a nuestro equipo en: soporte@welcickdigital.com | +502 52515155</p>
                    <p>Atentamente, El equipo de Weclickdigital</p>
                </div>
            </body>
        </html>
        ';
                    
        return Yii::$app->mailer->compose()
        ->setFrom($options->from)
        ->setTo($options->to)
        ->setSubject($options->subject)
        ->setHtmlBody($html)
        ->send();
    }


    public function actionCaptureinput($input = "", $site = ""){
        $data = ['Date' => Date('Y-m-d H:i'), 'Input' => $_POST['Input'] ?? $input, 'Site' => $_POST['Site'] ?? $site];

        $model = new Tracking();

        $model->Date = $data['Date'];
        $model->Input = $data['Input'];
        $model->Site = $data['Site'];
        $model->Ip = self::getClientIP();

        $model->save();
    }

    public function getClientIP() {
        $ip = '';
        if (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip= $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (isset($_SERVER['HTTP_X_FORWARDED'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED'];
        } elseif (isset($_SERVER['HTTP_X_CLUSTER_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
        } elseif (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_FORWARDED_FOR'];
        } elseif (isset($_SERVER['HTTP_FORWARDED'])) {
            $ip = $_SERVER['HTTP_FORWARDED'];
        } elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        return $ip;
    }

} 
