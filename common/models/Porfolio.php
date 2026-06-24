<?php
namespace common\models;

use Yii;
use yii\base\Model;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\web\UploadedFile;
use yii\helpers\Url;
use common\models\Porfolio;

class Porfolio extends ActiveRecord
{
    public $Photo;
    public $VideoPF;
    public $Proyect;
    public $Description;
    
    public static function tableName()
    {
        return '{{%Porfolio}}';
    }

    public function rules()
    {
        return [
            [['Title', 'Proyect', 'Client', 'Description', 'Type', 'Visibility', 'Restriction', 'NGuatemala'], 'required'],
            [['Title', 'ProyectES', 'ProyectEN', 'Client', 'DescriptionES', 'DescriptionEN', 'Link', 'Image', 'Video'], 'string'],
            [['Position', 'Type', 'Visibility', 'Restriction', 'NGuatemala'], 'integer'],
            [['Photo'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, webp'],
            [['VideoPF'], 'file', 'skipOnEmpty' => true, 'extensions' => ['mp4', 'mpeg'], 'maxSize' => 60 * 1024 * 1024],
        ];
    }
   
    public function attributeLabels()
    {
        return [
            'Title' => 'Título',
            'Client' => 'Cliente',
            'Type' => 'Tipo de sitio',
            'Description' => 'Descripción',
            'Image' => 'Imagen del portafolio',
            'Proyect' => 'Proyecto',
            'VideoPF' => 'Video (opcional)',
            'Visibility' => 'Visibilidad'
        ];
    }


    public function upload()
    {
        if($this->validate()) {
            $PhotoTemp = "ImagePorfolio_". substr(md5(uniqid(rand())),0,6) . '.' . $this->Photo->extension;
            $this->Photo->saveAs(Yii::$app->basePath.'/../images/porfolio/cover/'.$PhotoTemp);
            $this->Image = Url::to('porfolio/cover/').$PhotoTemp;
            $this->Photo = null;

            return true;
        }else {
            return false;
        }
    }

    public function uploadVideo()
    {
        $Video = "Video_". substr(md5(uniqid(rand())),0,6) . '.' . $this->VideoPF->extension;
        $this->VideoPF->saveAs(Yii::$app->basePath.'/../videos/'.$Video);
        $this->Video = Url::to('videos/').$Video;
        $this->VideoPF = null;
        return true;
    }

    public function porfolio($id = ""){
        $infoUs = Yii::$app->LocationLang->info();
		$lang = $infoUs->language->LanguageCode;

        $query = empty($id) ? Porfolio::find()->select(['*','Proyect' . strtoupper($lang) . ' AS Proyect', 'Description' . strtoupper($lang) . ' AS Description'])->orderBy(['Position' => SORT_ASC])->all() : Porfolio::find()->select(['*','Proyect' . strtoupper($lang) . ' AS Proyect', 'Description' . strtoupper($lang) . ' AS Description'])->where(['PorfolioID' => $id])->orderBy(['Position' => SORT_ASC])->one();
        
        return $query;
    }

    public function getAnexos(){
        return $this->hasMany(PorfolioAnexos::className(), ['PorfolioID' => 'PorfolioID']);
    }

    public function getSoftCanned()
    {
        return $this->hasOne(SoftCanned::class, ['PorfolioID' => 'PorfolioID']);
    }

}
?>