<?php
namespace common\modules\JcChat\models;

use Yii;
use yii\db\ActiveRecord;

class ChatMessage extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%chat_message}}';
    }

    public function rules()
    {
        return [
            [['room_id', 'created_at'], 'required'],
            [['room_id', 'created_at','is_read'], 'integer'],
            [['text', 'image','sender'], 'string'],
        ];
    }

    public function getRoom()
    {
        return $this->hasOne(ChatRoom::class, ['id' => 'room_id']);
    }
}