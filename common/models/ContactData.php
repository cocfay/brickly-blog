<?php
namespace common\models;

use Yii;
use yii\base\Model;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\web\UploadedFile;
use yii\helpers\Url;

class ContactData extends ActiveRecord
{

    public static function tableName(){
        return '{{%DataClient}}';
    }
    /* public $Name;
    public $Email;
    public $Phone; */
    
    public function rules()
    {
        return [
            [['Name', 'Email', 'Phone'], 'required'],
            [['Email', 'Country'], 'string'],
            [['Email'], 'email'],
            [['Name'], 'string', 'max' => 250],
            [['Phone'], 'string', 'min' => 8, 'tooShort' => 'Teléfono * debería contener al menos 8 digitos.'], // Ajusta 'max' según sea necesario
            [['Phone'], 'match', 'pattern' => '/^\d{8,15}$/', 'message' => 'Teléfono * solo debe contener números.'], // Asegura que solo contenga dígitos

        ];
    }
   
    public function attributeLabels()
    {
        return [
            'Name' => 'Nombre *',
            'Email' => 'Correo electrónico *',
            'Phone' => 'Teléfono *'
        ];
    }

    public function valiCaptcha(){
        $secretKey = '6LeKNtcqAAAAAEbD69D-mDml1R-2gI8lKsBYAeun';

        $recaptchaToken = $_POST['recaptcha-token'];
        $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secretKey}&response={$recaptchaToken}");
        $result = json_decode($response, true);
        
        return $result['success'] ? true : false;
    }
}
?>