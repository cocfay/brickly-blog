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

class ImagesComponentsDescription extends ActiveRecord
{
   

    public static function tableName()
    {
        return '{{%ImagesComponentsDescription}}';
    }

	public function rules()
    {
        return [
            [[ 'Lang','ImageComponentID'], 'required'],
            // [['discard'], 'safe'],
            [[ 'Lang','Data', 'DataMovil','ImageBy'], 'string'],


            [['ImagesComponentsDescriptionID','ImageComponentID'], 'number'],
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
        return $this->hasOne(ImagesComponents::className(), ['ImageComponentID' => 'ImageComponentID']);
    }
}
?>