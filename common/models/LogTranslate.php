<?php 
	namespace common\models;

	use yii;
	use yii\base\Model;
	use yii\base\NotSupportedException;
	use yii\db\ActiveRecord;
	
	class LogTranslate extends ActiveRecord
	{
		public static function tableName()
		{
			return '{{%LogTranslate}}';
		}
		/**
	     * @inheritdoc
	     */
	    public function rules()
	    {
	        return [
	            
	            [['ReferrerUrl','CurrentUrl'], 'string'],
	        ];
	    }

		/**
	    * @return \yii\db\ActiveQuery
	     */

	}

?>