<?php
namespace common\models;

use Yii;
use yii\base\Model;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\web\UploadedFile;
use yii\helpers\Url;

class Contact extends ActiveRecord
{

    public static function tableName(){
        return '{{%Contact}}';
    }
    /* public $Name;
    public $Email;
    public $Phone; */
    
    public function rules()
    {
        return [
            [['Name', 'Email', 'Phone'], 'required'],
            [['Email'], 'string'],
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


}
?>