<?php
namespace common\models;

use Yii;
use yii\db\ActiveRecord;

class CountApiRequest extends ActiveRecord
{
    //public $CollectionID;
    public static function tableName()
    {
        return '{{%CountApiRequest}}';
    }

  
  /**
 	* @return \yii\db\ActiveQuery
	 */
	// public function getUserAccount()
	// {
	//     return $this->hasOne(UserAccount::className(), ['AccountID' => 'AccountID']);
	// }





}
?>