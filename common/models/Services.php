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

class Services extends ActiveRecord
{
    
    public static function tableName(){
        return '{{%Services}}';
    }
   
    public function rules()
    {
        return [
            [['Name'], 'required'],
            [['Name'], 'string']
        ];
    }
   
    /* public function attributeLabels()
    {
        return [
            'Name' => 'Nombre *',
        ];
    } */

    /* public function getHowMany(){
        $accountId = Yii::$app->user->identity->AccountID;
        return $this->hasMany(ServicesByAccount::class, ['ServiceID' => 'ServiceID'])->where(['AccountID' => $accountId])->groupBy('ServiceID');
        //return $this->hasMany(Account::class, ['AccountID' => 'AccountID'])->viaTable('ServicesByAccount', ['ServiceID' => 'ServiceID']);
    } */

    public function getRequestServices(){
        return $this->hasMany(RequestServiceClient::class, ['ServiceID' => 'ServiceID']);
    }

}
?>