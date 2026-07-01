<?php
namespace common\models;

use Yii;
use yii\base\Model;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\web\UploadedFile;
use yii\helpers\Url;

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


}
?>