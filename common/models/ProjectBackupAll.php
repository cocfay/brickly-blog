<?php
namespace common\models;

use Yii;
use yii\base\Model;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\web\UploadedFile;
use yii\helpers\Url;

class ProjectBackupAll extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%ProjectWeclick}}';
    }

    public function rules()
    {
        return [
            [['Descripcion', 'Environment'], 'required'],
            [['Status'], 'safe'],
            [['Type'], 'integer']
        ];
    }

    public function attributeLabels(){
        return [
            'Descripcion' => 'Archivo', 
            'Environment' => 'Ambiente'
        ];
    }
   
    /* public function getAnexos(){
        return $this->hasMany(Porfolio::className(), ['PorfolioID' => 'PorfolioID']);
    } */

}
?>