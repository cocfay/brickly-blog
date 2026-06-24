<?php
namespace common\models;

use Yii;
use yii\base\Model;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\web\UploadedFile;

class CompleteInfo extends ActiveRecord{
    public static function tableName(){
        return '{{%UserAccount}}';
    }

    public function rules(){
        return [
            [['NumberPhone', 'CountryID'], 'required'],
        ];
    }

    public function attributeLabels(){
        return [
            'NumberPhone' => 'Número teléfonico',
            'CountryID' => 'País',
        ];
    }
}