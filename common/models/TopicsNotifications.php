<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

class TopicsNotifications extends ActiveRecord
{
    
    public static function tableName()
    {
        return '{{%TopicsNotifications}}';
    }

    /**
 	* @return \yii\db\ActiveQuery
	 */
     public function rules()
    {
        return [
            [['ChannelKey','Channel'], 'required'],
            [['Description','ChannelKey','Channel'], 'string'],

        ];
    }
    public function attributeLabels()
    {
        return [
            'ChannelKey' => 'Llave',
            'Channel' => 'Canal / Topic',
            'Description' => 'Descripción',
        ];
    }
}
?>