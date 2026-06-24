<?php
namespace common\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;
/* use yii\base\NotSupportedException;
use yii\web\IdentityInterface;
use yii\web\UploadedFile;
use yii\helpers\Url; */

class SoftCanned extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%SoftCanned}}';
    }

    public function rules()
    {
        return [
            [['Type'], 'required'],
            [['Type', 'PorfolioID'], 'integer']
        ];
    }
   
    public function attributeLabels()
    {
        return [
            'Type' => 'Tipo de software enlatado'
        ];
    }

    public function getPorfolio(){
        return $this->hasOne(Porfolio::className(), ['PorfolioID' => 'PorfolioID']);
    }

}
?>