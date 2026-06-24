<?php
namespace common\models;

use Yii;
use yii\base\Model;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\web\UploadedFile;
use yii\helpers\Url;
//use manchenkov\yii\recaptcha\ReCaptchaValidator;

class ContactAsesor extends ActiveRecord
{
    //public $captcha;
    
    public static function tableName(){
        return '{{%DataClient}}';
    }
   
    public function rules()
    {
        return [
            [['Name', 'Email', 'Phone', 'Consulta'], 'required'],
            [['Email', 'Country'], 'string'],
            [['Email'], 'email'],
            [['Name'], 'string', 'max' => 250],
            [['Phone'], 'string', 'min' => 8], // Ajusta 'max' según sea necesario
            [['Phone'], 'match', 'pattern' => '/^\d{8,15}$/'], // Asegura que solo contenga dígitos
            [['Consulta'], 'string', 'max' => 400],
            //['captcha', ReCaptchaValidator::class, 'score' => 0.8, 'action' => 'login']
        ];
    }
   
    public function attributeLabels()
    {
        return [
            'Name' => 'Nombre y apellido *',
            'Email' => 'Correo electrónico *',
            'Phone' => 'Teléfono *',
            'Country' => 'País',
            'Consulta' => 'Consulta *'
        ];
    }

    public function valiCaptcha(){
        $secretKey = '6LeKNtcqAAAAAEbD69D-mDml1R-2gI8lKsBYAeun';

        $recaptchaToken = $_POST['recaptcha-token'];
        $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secretKey}&response={$recaptchaToken}");
        $result = json_decode($response, true);

        //var_dump($result); exit;

        return ($result['success']) && ($result['score'] >= 0.5);
    }
}
?>