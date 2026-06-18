<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\helpers\Url;

use yii\web\IdentityInterface;
use yii\web\UploadedFile;
use common\components\ConvertToWebP;

class TextBoxComponentsData extends ActiveRecord
{
   

    public static function tableName()
    {
        return '{{%TextBoxComponentsData}}';
    }

	public function rules()
    {
        return [
            [[ 'Lang', 'Data', 'DataMovil', 'TexBoxComponentID'], 'required'],
            // [['discard'], 'safe'],
            [[ 'Lang','Data', 'DataMovil'], 'string'],


            [['TextBoxComponentsDataID','TexBoxComponentID'], 'number'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'Data' => 'Descripcion de la imagen',
            'Lang' => 'Idioma',
        ];
    }

    public function getImageComponent(){
        return $this->hasOne(TextBoxComponets::className(), ['TexBoxComponentID' => 'TexBoxComponentID']);
    }
}
?>