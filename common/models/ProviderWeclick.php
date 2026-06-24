<?php
namespace common\models;

use Yii;
use yii\base\Model;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\web\UploadedFile;
use yii\helpers\Url;

class ProviderWeclick extends ActiveRecord
{
    
    public static function tableName()
    {
        return '{{%ProviderWeclick}}';
    }

    public function rules()
    {
        return [
            [['Name'], 'required'],
            [['TypePay', 'Amount', 'Debt', 'NotiDate'], 'number'],
            [['Date'], 'date']
            //[['Photo'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, webp'],
        ];
    }
   
    public function attributeLabels()
    {
        return [
            'Name' => 'Nombre',
            'Amount' => 'Cantidad',
            'Debt' => 'Deuda',
            'Date' => 'Fecha de interes'
        ];
    }


    /* public function upload()
    {
        if($this->validate()) {
            $PhotoTemp = "ImagePorfolio_". substr(md5(uniqid(rand())),0,6) . '.' . $this->Photo->extension;
            $this->Photo->saveAs(Yii::$app->basePath.'/../images/porfolio/cover/'.$PhotoTemp);
            $this->Image = Url::to('porfolio/cover/').$PhotoTemp;
            $this->Photo = null;

            return true;
        }else {
            return false;
        }
    } */

    
    /* public function getSoftCanned(){
        return $this->hasOne(SoftCanned::class, ['PorfolioID' => 'PorfolioID']);
    } */

    public function getPayService(){
        return $this->hasOne(PayConServ::class, ['ProviderID' => 'ProviderID'])->orderBy(['Date' => SORT_DESC])->limit(1);
    }

}
?>