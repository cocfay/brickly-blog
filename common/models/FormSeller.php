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

class FormSeller extends ActiveRecord
{
    public $Country;
    public $Expe;
    public $Source;
    public $Language;
    
    public static function tableName(){
        return '{{%FormSeller}}';
    }
   
    public function rules()
    {
        return [
            [['Name', 'Email', 'NumberDocument', 'Date', 'Address', 'City', 'Phone', 'Profession', 'ExplField1', 'ExplField2', 'ExplField3', 'ExplField4', 'ExplField5', 'ExplField6', 'ExplField7', 'HCField1', 'HCField2', 'HCField3', 'HCField4', 'HCField5', 'HCField6', 'HCField7', 'Expe', 'Source', 'Language'], 'required'],
            [['Email', 'Address', 'City', 'Profession', 'CivilState', 'ExplField1', 'ExplField2', 'ExplField6', 'ExplField7', 'ExplField8'], 'string'],
            [['Date', 'ExplField3', 'ExplField4'], 'date', 'format' => 'php:Y-m-d'],
            //['ExplField3', 'compare', 'compareAttribute' => 'ExplField4', 'operator' => '<=', 'message' => 'La Fecha B no puede ser mayor que la Fecha A'],
            [['Country', 'NumberDocument', 'ExplField5'], 'integer'],
            [['Email'], 'email'],
            [['Name'], 'string', 'max' => 50],
            [['HCField1', 'HCField2', 'HCField3', 'HCField4', 'HCField5', 'HCField6', 'HCField7'], 'string', 'max' => 250],
            [['Phone'], 'string', 'min' => 8], // Ajusta 'max' según sea necesario
            [['Phone'], 'match', 'pattern' => '/^\d{8,15}$/'], // Asegura que solo contenga dígitos
            //[['Consulta'], 'string', 'max' => 400],
            //['captcha', ReCaptchaValidator::class, 'score' => 0.8, 'action' => 'login']
        ];
    }
   
    public function attributeLabels()
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
    }

    public function valiCaptcha(){
        return true;
    }
}
?>