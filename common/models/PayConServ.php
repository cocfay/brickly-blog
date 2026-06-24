<?php
namespace common\models;

use Yii;
use yii\base\Model;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\web\UploadedFile;
use yii\helpers\Url;

class PayConServ extends ActiveRecord
{
    
    public static function tableName()
    {
        return '{{%PayConServ}}';
    }

    public function rules()
    {
        return [
            //[['Name'], 'required'],
            [['TypeCurrency', 'Name'], 'string'],
            [['Conversion', 'Amount', 'Balance'], 'number'],
            [['Date'], 'date', 'format' => 'php:Y-m-d\TH:i'],
            //[['issueDate'], 'date', 'format' => 'php:Y-m-d']
            //[['Photo'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, webp'],
        ];
    }
   
    public function attributeLabels()
    {
        return [
            'TypeCurrency' => 'Tipo de moneda',
            'Conversion' => 'Conversión a quetzales',
            'Amount' => 'Monto',
            'Date' => 'Fecha de pago',
            'Photo' => 'Comprobante de pago',
            'issueDate' => 'Fecha de emisión',
            'Name' => 'Nombre'
        ];
    }


    public function upload()
    {
        if($this->validate()) {
            $PhotoTemp = "comprobante_". substr(md5(uniqid(rand())),0,6) . '.' . $this->Photo->extension;
            $this->Photo->saveAs(Yii::$app->basePath.'/../uploads/proamountweck/'.$PhotoTemp);
            $this->Photo = Url::to('proamountweck/').$PhotoTemp;
            //$this->Photo = null;
            return true;
        }else {
            return false;
        }
    }

    
    public function getProviderWeck(){
        return $this->hasOne(ProviderWeclick::class, ['ProviderID' => 'ProviderID']);
    }

}
?>