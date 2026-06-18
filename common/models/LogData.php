<?php
namespace common\models;

use Yii;
use yii\db\ActiveRecord;

class LogData extends ActiveRecord
{
    public static function tableName()
    {
        return 'LogData';
    }

    public function rules()
    {
        return [
            [['Module', 'AppliedAction', 'UserName', 'TextInfo'], 'required'],
            [['TextInfo'], 'string'],
            [['DateLog'], 'safe'],
            [['Module'], 'string', 'max' => 60],
            [['AppliedAction', 'UserName'], 'string', 'max' => 120],
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord && empty($this->DateLog)) {
                $this->DateLog = date('Y-m-d H:i:s');
            }
            return true;
        }
        return false;
    }
}