<?php 
	namespace common\models;

	use yii;
	use yii\base\Model;
	use yii\base\NotSupportedException;
	use yii\db\ActiveRecord;
	
	class SwiftToggle extends ActiveRecord
	{


		public static function tableName()
		{
			return '{{%swifttoggle}}';
		}

		public function rules()
	    {
	        return [
	                 [['ValueToggle'],'number']
	            ];
	    }
	    public function attributeLabels()
	    {
	        return [];
	    }
	}

?>