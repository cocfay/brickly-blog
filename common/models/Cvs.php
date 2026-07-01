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

date_default_timezone_set("America/Guatemala");

class Cvs extends ActiveRecord
{
    public static function tableName(){
        return '{{%Cvs}}';
    }
   
    public function rules()
    {
        return [
            [['Name', 'Email', 'Phone'], 'required'],
            [['Email', 'Country', 'Type'], 'string'],
            [['Email'], 'email'],
            [['Email'], 'unique'],
            [['Approve'], 'number'],
            [['Name'], 'string', 'max' => 250],
            [['Phone'], 'string', 'min' => 8], // Ajusta 'max' según sea necesario
            //[['Phone'], 'string', 'min' => 11],
            [['Phone'], 'match', 'pattern' => '/^\d{8,15}$/'], // Asegura que solo contenga dígitos
            [['File'], 'file', 
            'skipOnEmpty' => false, 
            'extensions' => 'pdf, doc, docx, ppt, png, jpg, jpeg, webp', 
            //'mimeTypes' => 'application/pdf, application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document, application/vnd.ms-powerpoint, image/jpeg, image/webp',
            'maxSize' => 10 * 1024 * 1024],
        ];
    }
   
    public function attributeLabels()
    {
        return [
            'Name' => 'Nombre y apellido *',
            'Email' => 'Correo electrónico *',
            'Phone' => 'Teléfono *',
            'Country' => 'País *',
            'File' => 'Adjuntar CV *'
        ];
    }

    public function upload()
    {
        if($this->validate()) {
            if(!file_exists(Yii::$app->basePath.'/../cvs')){
                mkdir('cvs', 0777, true);
            }

            $FileTemp = "cvs_". str_replace(" ", "_", $this->Name) .'_'. date("d_m_Y_H:i") . '.' . $this->File->extension;

            $this->File->saveAs(Yii::$app->basePath.'/../cvs/'.$FileTemp);
            $this->File = Url::to('cvs/').$FileTemp;
            //$this->File = null;

            return true;
        }else {
            return false;
        }
    }

    public function valiCaptcha(){
        return true;
    }
}
?>