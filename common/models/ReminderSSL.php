<?php
namespace common\models;

use Yii;
use yii\base\Model;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\web\UploadedFile;
use yii\helpers\Url;

class ReminderSSL extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%ReminderSSL}}';
    }

    public function rules()
    {
        return [
            [['Text', 'IpHosting', 'Date', 'Provider'], 'string'],
            [['ReminderDays', 'Status'], 'number']
        ];
    }
   
    /* public function getAnexos(){
        return $this->hasMany(Porfolio::className(), ['PorfolioID' => 'PorfolioID']);
    } */

}
?>