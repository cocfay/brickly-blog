<?php
namespace common\models;

use Yii;
use yii\base\Model;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\web\UploadedFile;
use yii\helpers\Url;

class PorfolioAnexos extends ActiveRecord
{
    public $PhotoAnexos;
    public static function tableName()
    {
        return '{{%PorfolioAnexos}}';
    }

    public function rules()
    {
        return [
            [['Image'], 'string'],
            [['PhotoAnexos'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, webp'],
        ];
    }
   
    /* public function getAnexos(){
        return $this->hasMany(Porfolio::className(), ['PorfolioID' => 'PorfolioID']);
    } */

}
?>