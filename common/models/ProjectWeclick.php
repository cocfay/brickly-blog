<?php
namespace common\models;

use Yii;
use yii\base\Model;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\web\UploadedFile;
use yii\helpers\Url;

class ProjectWeclick extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%ProjectWeclick}}';
    }

    public function rules()
    {
        return [
            [['Dominio', 'Carpeta', 'DB', 'Usuario', 'Descripcion', 'Password', 'Cliente'], 'required'],
            [['UrlDev', 'UrlProd', 'Fecha'], 'string'],
            [['TypeProject', 'Status'], 'safe'],
            [['Type'], 'integer']
        ];
    }

    public function attributeLabels(){
        return [
            //'Dominio' => '', 
            //'Carpeta' => '', 
            'DB' => 'Base de datos', 
            //'Usuario' => '', 
            'Descripcion' => 'Descripción', 
            'Password' => 'Contraseña', 
            'Fecha' => 'Fecha de expiración', 
            'TypeProject' => 'Tipo de proyecto',
            'UrlDev' => 'Url desarrollo', 
            'UrlProd' => 'Url producción'
        ];
    }
   
    /* public function getAnexos(){
        return $this->hasMany(Porfolio::className(), ['PorfolioID' => 'PorfolioID']);
    } */

}
?>