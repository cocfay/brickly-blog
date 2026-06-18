<?php
namespace common\models;

use Yii;
use yii\base\Model;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\web\UploadedFile;

class BillingInfo extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%BillingInfo}}';
    }

    public function rules()
    {
        return [
            [['Name','Email','Address'], 'required'],
            [['Name','NIT','Address'], 'string'],
            [['Email'], 'email'],
            [['AccountID'],'integer', 'integerOnly'=>true],

        ];
    }

    public function attributeLabels()
    {
        return [
            'Name' => 'Nombre*',
            'Email' => 'Correo electónico',
            'NIT' => 'NIT',
            'Address' => 'Dirección',
        ];
    }
    public function getAccount()
    {
        return $this->hasOne(Account::className(), ['AccountID' => 'AccountID']);
    }
    public function getUserAccount()
    {
        return $this->hasOne(UserAccount::className(), ['AccountID' => 'AccountID']);
    }
}