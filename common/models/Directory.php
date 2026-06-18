<?php 
	namespace common\models;

	use yii;
	use yii\base\Model;
	use yii\base\NotSupportedException;
	use yii\db\ActiveRecord;
	
	class Directory extends ActiveRecord
	{
		

		public static function tableName()
		{
			return '{{%directory}}';
		}

		public function rules()
	    {
	        // return [
	        //     [['Name','NIT','NumberPhone'], 'required'],
	        //     [['Name','NumberPhone'], 'string','max' => 128],
	        //     [['Description','DescriptionEng','Address'], 'string','max' => 500],
	        //     [['WebSite','Facebook','Twitter','Skype','Linkedin','Video'], 'string','max' => 220],
	        //     [['Email'], 'email'],
	        //     [['Latitud','Longitud','PathImagen'], 'string'],
	        //     [['Origen'],'number'],
	        //     [['CrmID','CbmID','SoapCode','ValidationCode'],'string']

	        // ];
			return [
	            [['Name','NIT','NumberPhone'], 'required'],
	            [['Name','NumberPhone'], 'string','max' => 128],
	            [['Address'], 'string','max' => 500],
	            [['Email'], 'email']

	        ];
	    }
	    public function attributeLabels()
	    {
	        return [
	            'Name' => 'Nombre',
	            'NIT' => 'NIT',
	            'Address' => 'Dirección',
	            'NumberPhone' => 'Numero de teléfono',
	            // 'Description'=> 'Descripción',
	            // 'DescriptionEng' => 'Descripción Ingles',
	            // 'WebSite' => 'Sitio Web',
	            // 'Facebook' => 'Facebook',
	            // 'Twitter' => 'Twitter',
	            // 'Skype' => 'Skype',
	            // 'Linkedin' => 'Linkedin',
	            // 'Video' => 'Correo',
	            // 'Origen' => 'Origen',
	            
	        ];
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