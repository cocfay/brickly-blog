<?php
namespace common\models;

use Yii;
use yii\base\Model;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\web\UploadedFile;
use yii\helpers\Url;

class Promotions extends ActiveRecord
{
    public $FileNewsletter;
    public static function tableName()
    {
        return '{{%Promotions}}';
    }

    public function rules()
    {
        return [
            [['Text'], 'string', 'max' => 250],
            [['Visible',"isShipped", "StatusShipped"], 'number'],
            [['ImageNewsLetter',"SubjectNewsLetter",'DescriptionNewsletter'], 'string'],
            [['FileNewsletter'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, webp'],
        ];
    }
   
    /* public function getAnexos(){
        return $this->hasMany(Porfolio::className(), ['PorfolioID' => 'PorfolioID']);
    } */

}
?>