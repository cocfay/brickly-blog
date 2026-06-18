<?php
namespace frontend\models;

use yii;
use yii\base\Model;
use \common\models\RegisterClients;
use yii\web\UploadedFile;

/**
 * Signup form
 */
class FormRegistro extends Model
{
    public $Name;
    public $Empresa;
    public $PhoneNumber;
    public $Country;
    public $Email;
    public $InvoiceNumber;
    public $Status = 0;
    public $Comentario;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Name','Empresa','PhoneNumber', 'Country', 'Email','Comentario'], 'required'],

            [['Name','Empresa','PhoneNumber'], 'string', 'min' => 2, 'max' => 255],
            [['Email','PhoneNumber'], 'unique', 'targetClass' => '\common\models\RegisterClients', 'message' => 'Ya existe un registro con estos datos.'],
            ['Email','email', 'message' => 'Correo electrónico no es una dirección de correo válida. '],
            [['Comentario'],'string'],
        ];
    }

    public function attributeLabels()
        {
            return [
                'Name' => 'Nombre',
                'Empresa' => 'Empresa',
                'PhoneNumber' => 'Número de teléfono',
                'Country' => 'País',
                'Email' => 'Correo electrónico',
                'Comentario' => 'Cuéntanos algo mas'
                
            ];
        }

    public function valiCaptcha(){
        $secret = '6LdrDw0qAAAAAH47nZ-UZ7Yd5cgNCZtwvRz03m7i';
        $recaptchaResponse = $_POST['g-recaptcha-response'];

        // Hacer la solicitud a la API de reCaptcha
        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $data = array(
            'secret' => $secret,
            'response' => $recaptchaResponse,
            'remoteip' => $_SERVER['REMOTE_ADDR']
        );

        $options = array(
            'http' => array (
                'method' => 'POST',
                'header' => 'Content-type: application/x-www-form-urlencoded',
                'content' => http_build_query($data)
            )
        );
    
        $context = stream_context_create($options);
        $verify = file_get_contents($url, false, $context);
        $captchaSuccess = json_decode($verify);

        return $captchaSuccess->success ? true : false;
    }
        
    public function sendNLContacto(){
        $EmailTo = ['cocfay@weclickdigital.com','paola@weclickdigital.com', 'cocfay@gmail.com'];
  
        $options =  [
            'from' => ['noreply@weclickdigital.com' => 'Weclick Notificación'],
            'to' => $EmailTo,
            'subject' => 'Notificación de contacto',
        ];

        $options = (Object)$options;
            
        $html = 
        '<html lang="es-GT">
            <head>
            <title>Notificación de contacto</title>
            </head>
            <body>
            <p>
            Nombre: <b>'.$this->Name.'</b>
            </p>
            <p>
            Empresa: <b>'.$this->Empresa.'</b>
            </p>
            <p>
            Teléfono: <b>'.$this->PhoneNumber.'</b>
            </p>
            <p>
            País: <b>'.$this->Country.'</b>
            </p>
            <p>
            Correo: <b>'.$this->Email.'</b>
            </p>
            <p>
            Comentario: <b>'.$this->Comentario.'</b>
            </p>
            </body>
        </html>';
                   
        return Yii::$app->mailer->compose()
        ->setFrom($options->from)
        ->setTo($options->to)
        ->setSubject($options->subject)
        ->setHtmlBody($html)
        ->send();
    }


    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    
}
