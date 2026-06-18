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

class Hook extends ActiveRecord
{
    public static function tableName(){
        return '{{%Hook}}';
    }
   
    public function rules(){
        return [
            [['Name'], 'required']
        ];
    }

    public function attributeLabels(){
        return [
            'Name' => 'Nombre'
        ];
    }

}