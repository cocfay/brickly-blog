<?php
namespace common\modules\JcChat\models;

use Yii;
use yii\db\ActiveRecord;

class ChatRoom extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%chat_room}}';
    }

    public function rules()
    {
        return [
            [['token', 'created_at', 'status'], 'required'],
            [['created_at', 'is_typing'], 'integer'],
            [['token'], 'string', 'max' => 255],
            [['status'], 'in', 'range' => ['active', 'closed']],
        ];
    }
    public function getMessages()
    {
        return $this->hasMany(ChatMessage::class, ['room_id' => 'id']);
    }
    public function getLastMessage()
    {
        return $this->hasOne(ChatMessage::class, ['room_id' => 'id'])->orderBy(['created_at'=>SORT_DESC]);
    }
}