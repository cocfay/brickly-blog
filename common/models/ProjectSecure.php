<?php
namespace common\models;

use Yii;
use yii\base\Model;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\web\UploadedFile;
use yii\helpers\Url;

class ProjectSecure extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%ProjectSecure}}';
    }

    public function rules()
    {
        return [
            [['ProjectWeclickID', 'PolicySecureID'], 'integer']
        ];
    }

    public function attributeLabels(){
        return [];
    }
   
    /* public function getAnexos(){
        return $this->hasMany(Porfolio::className(), ['PorfolioID' => 'PorfolioID']);
    } */

}
?>