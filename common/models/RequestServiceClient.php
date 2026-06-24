<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

class RequestServiceClient extends ActiveRecord
{
    
    public static function tableName()
    {
        return '{{%RequestServiceClient}}';
    }
    public function rules()
    {
        return [
            [['Description','ServiceID','AccountID'], 'required'],

            [['Check1', 'Check2', 'Check3', 'Check4', 'Check5', 'Check6', 'Check7', 'Check8', 'Check9', 'Check10'], 'safe'],
        
            /// Validación condicional para checkboxes
            //['Check1', 'validateCheckboxesWhenPresent', 'skipOnEmpty' => false],
        

            [['Description'], 'string'],
            [['AccountID','ServiceID'],'integer', 'integerOnly'=>true],

        ];
    }

    public function attributeLabels()
    {
        return [
            'ServiceID' => 'Servicio *',
            'Description' => 'Descripción *',
        ];
    }

    /* public function validateCheckboxesWhenPresent($attribute, $params)
    {
        $checkboxes = ['Check1', 'Check2', 'Check3', 'Check4', 'Check5', 'Check6'];
        
        // Verifica si alguno de los checkboxes fue enviado en el POST (aunque esté vacío)
        $anyCheckboxPresent = false;
        $anyCheckboxChecked = false;
        
        foreach ($checkboxes as $checkbox) {
            // Verifica si el checkbox está presente en los datos enviados
            if ($this->$checkbox !== null) {
                $anyCheckboxPresent = true;
                
                // Verifica si el checkbox está marcado (valor = 1, true, o el valor que uses)
                if (!empty($this->$checkbox)) {
                    $anyCheckboxChecked = true;
                }
            }
        }
    
        // Solo validar si hay checkboxes presentes en el formulario
        if ($anyCheckboxPresent && !$anyCheckboxChecked) {
            foreach ($checkboxes as $checkbox) {
                $this->addError($checkbox, 'Debe seleccionar al menos una opción');
            }
        }
    } */

  /**
 	* @return \yii\db\ActiveQuery
	 */
	public function getAccount()
	{
	    return $this->hasOne(Account::className(), ['AccountID' => 'AccountID']);
	}

	/**
 	* @return \yii\db\ActiveQuery
	 */
	public function getService()
	{
	    return $this->hasOne(Services::className(), ['ServiceID' => 'ServiceID']);
	}




}
?>