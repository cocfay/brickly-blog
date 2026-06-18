<?php
namespace common\models;

use Yii;
use yii\db\ActiveRecord;

class NotificationByAccount extends ActiveRecord
{
    public static function tableName()
    {
        return 'NotificationByAccount';
    }

    public function rules()
    {
        return [
            [['NotificationID', 'AccountID'], 'required'],
            [['NotificationID', 'AccountID'], 'integer'],
            [['Status'], 'in', 'range' => ['unread', 'read']],
            [['ReadAt'], 'safe'],
            [['NotificationID', 'AccountID'], 'unique', 'targetAttribute' => ['NotificationID', 'AccountID']],
        ];
    }

    public function getNotification()
    {
        return $this->hasOne(Notifications::class, ['NotificationID' => 'NotificationID']);
    }

    public function getAccount()
    {
        return $this->hasOne(Account::class, ['AccountID' => 'AccountID']);
    }
}