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

class FormSellerAnexos extends ActiveRecord
{
    public $Country;
    public $Expe;
    public $Source;
    public $Language;
    
    public static function tableName(){
        return '{{%FormSellerAnexos}}';
    }
   
    public function rules()
    {
        return [
            [['Text'], 'string'],
            [['Type', 'FormSellerID'], 'integer']
        ];
    }
   
    /* public function attributeLabels()
    {
        return [
            'Name' => 'Nombre completo *',
            'Country' => 'País',
            'NumberDocument' => 'Numero de documento (DNI/RUT/PASAPORTE)',
            'Date' => 'Fecha de nacimiento *',
            'Address' => 'Dirección *',
            'City' => 'Ciudad *',
            'Email' => 'Correo electrónico *',
            'Phone' => 'Teléfono *',
            'Profession' => 'Profesión *',
            'CivilState' => 'Estado civil *',
            'ExplField1' => 'Último trabajo (nombre empresa) *',
            'ExplField2' => 'Cargo *',
            'ExplField3' => 'Fecha inicio',
            'ExplField4' => 'Fecha fin',
            'ExplField5' => 'Teléfono de la empresa *',
            'ExplField6' => 'Sector de experiencia *',
            'ExplField7' => 'Tipo de venta *',
            'ExplField8' => 'Laborando actualmente *',
            'HCField1' => 'Describe la última vez que tuviste que buscar un cliente desde cero. ¿cómo lo hiciste? *',
            'HCField2' => '¿Qué haces cuando pasas varias horas llamando a prospectos y nadie te responde? *',
            'HCField3' => '¿Recuerdas una venta que hayas perdido y que aún te fruste? ¿qué aprendiste? *',
            'HCField4' => '¿Prefieres vender productos caros/dificiles (ciclos largos) o baratos/rápidos? ¿por qué? *',
            'HCField5' => 'Imagina que llevas 3 meses trabajando en un cliente potencial, pero siguen posponiendo la decisión. ¿qué harías en el mes 4? *',
            'HCField6' => 'En ventas complejas, los \'no\' son frecuentes. ¿qué te mantiene motivado después de varios rechazos seguidos? *',
            'HCField7' => 'Nuestro modelo es 100% por comisiones. Según tu experiencia y ambición, ¿qué ingresos mensuales por ventas crees realistas para ti en este puesto? *',
        ];
    } */

    /* public function valiCaptcha(){
        $secretKey = '6LeKNtcqAAAAAEbD69D-mDml1R-2gI8lKsBYAeun';

        $recaptchaToken = $_POST['recaptcha-token'];
        $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secretKey}&response={$recaptchaToken}");
        $result = json_decode($response, true);

        //var_dump($result); exit;

        return ($result['success']) && ($result['score'] >= 0.5);
    } */
}
?>