<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

class ActivitySession extends ActiveRecord
{
    
    public static function tableName()
    {
        return '{{%ActivitySession}}';
    }

    public function compare(){
        $data = Yii::$app->SessionActivity->current();
        if(
            $this->IP == $data->IP &&
            $this->Browser == $data->Browser &&
            $this->Device == $data->Device &&
            $this->OS == $data->OS &&
            $this->AccountID == $data->AccountID && 
            $this->Status == 1 &&
            $this->SessionID == $data->SessionID


        ){
            return true;
        }
            return false;
        
    }

  /**
 	* @return \yii\db\ActiveQuery
	 */
	public function getAccount()
	{
	    return $this->hasOne(Account::className(), ['AccountID' => 'AccountID']);
	}


}
?>