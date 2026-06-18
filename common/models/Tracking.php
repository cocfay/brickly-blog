<?php
namespace common\models;

use Yii;
use yii\base\Model;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\web\UploadedFile;
use yii\helpers\Url;

class Tracking extends ActiveRecord
{
    
    public static function tableName(){
        return '{{%Tracking}}';
    }

    public function rules()
    {
        return [
            [['Date', 'Input', 'Site', 'Ip'], 'string']
        ];
    }
}
?>