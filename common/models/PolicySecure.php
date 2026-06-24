<?php
namespace common\models;

use Yii;
use yii\base\Model;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\web\UploadedFile;
use yii\helpers\Url;

class PolicySecure extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%PolicySecure}}';
    }

    public function rules()
    {
        return [
            [['Nombre', 'Descripcion', 'Capa', 'Tipo'], 'required']
        ];
    }

    public function attributeLabels(){
        return [ 
            'Capa' => 'Capa de seguridad',
            'Tipo' => 'Tipo de chequeo de seguridad',
            'Descripcion' => 'Descripción'
        ];
    }
   
    public function getProjectSecure(){
        return $this->hasOne(ProjectSecure::className(), ['PolicySecureID' => 'PolicySecureID']);
    }

}
?>