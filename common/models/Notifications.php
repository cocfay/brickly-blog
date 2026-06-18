<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

class Notifications extends ActiveRecord
{
    public static function tableName()
    {
        return 'Notifications';
    }

    public function rules()
    {
        return [
            [['Title', 'Body'], 'required'],
            [['Body'], 'string'],
            [['UrlIcon'], 'string', 'max' => 255],
            [['CreatedAt'], 'safe'],
        ];
    }

    public function getAccounts()
    {
        return $this->hasMany(Account::class, ['AccountID' => 'AccountID'])
            ->viaTable('NotificationByAccount', ['NotificationID' => 'NotificationID']);
    }

    public function getNotificationsByAccount()
    {
        return $this->hasMany(NotificationByAccount::class, ['NotificationID' => 'NotificationID']);
    }
}
