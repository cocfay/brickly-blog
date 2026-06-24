<?php
namespace backend\models;

use Yii;
use yii\db\ActiveRecord;

class Email extends ActiveRecord{
    public static function tableName(){
        return '{{%Emails}}';
    }

    public function rules()
    {
        return [
            [['Mail'], 'required'],
            [['Mail'], 'string']
        ];
    }

    public function attributeLabels(){
        return [
            'Mail' => 'Correo Electrónico'
        ];
    }
}

