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

class ServicesByAccount extends ActiveRecord
{
    //public $captcha;
    
    public static function tableName(){
        return '{{%ServicesByAccount}}';
    }
   
    public function rules()
    {
        return [
            [['ServiceID', 'AccountID'], 'integer']
        ];
    }

    /* public function attributeLabels()
    {
        return [
            'Name' => 'Nombre *',
        ];
    } */

}
?>