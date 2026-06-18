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

class ImagesComponents extends ActiveRecord
{
    public $RequestFile;
    public $VDescription;
    public $VImageBy;

    public static function tableName()
    {
        return '{{%ImagesComponents}}';
    }

	public function rules()
    {
        return [
            [[ 'PostBlogID', 'PostBlogCenterComponentID','ImagePatch'], 'required'],
            // [['discard'], 'safe'],
            [[ 'VDescription','ImagePatch','VImageBy'], 'string'],

            [['RequestFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, webp'],

            [['PostBlogCenterComponentID', 'PostBlogID'], 'number'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'ColorPost' => 'Color del Post',
            'Description' => 'Texto acompañante',
            'VDescription' => 'Texto acompañante',
            'VImageBy' => 'Image By'
        ];
    }

 	public function upload()
    {
        // if ($this->validate()) {
            $NameFile = 'doc-'.substr(md5(uniqid(rand())),0,6) . '.' . $this->RequestFile->extension;
            $this->RequestFile->saveAs(\Yii::getAlias('@proyectroot') . '/post/' . $NameFile );


            if(strtolower($this->RequestFile->extension) != 'webp'){
                        
                $FileWeb = Yii::getAlias(\Yii::getAlias('@proyectroot') . '/post/' . $NameFile);
                $convert = new ConvertToWebP();
                $UpFiileConv = $convert->convert($FileWeb,80,true);

                if($UpFiileConv->status == 1){
                    $NameFile = str_replace('.'.$this->RequestFile->extension,'.webp',$NameFile);
                }

            }

            
            $this->ImagePatch = Url::to('@raizweb/post/').$NameFile;
            $this->RequestFile = null;
            return true;
        
    }
    public function PatchIMG(){

        $returnImg = $this->ImagePatch;
        $user_agent = $_SERVER['HTTP_USER_AGENT']; 

        if(stripos( $user_agent, 'Safari') !== false && !(stripos( $user_agent, 'Chrome') !== false)){

            $GetNameImage = explode('/post/',$this->ImagePatch);
            $GetNameImage = $GetNameImage[1];

            $fPath = \Yii::getAlias('@proyectroot');
            $dirImage = $fPath.'/images/BlogPostImages/'.$this->centerComponents->postBlog->AccountID.'/post/';
            $SafaryIMG = str_replace(
                                    ['.webp','.WEBP'],
                                    ['.jpg','.jpg'],
                                    $GetNameImage
                                );
            if(!file_exists($dirImage.$SafaryIMG)){
                 $FileWeb = Yii::getAlias($dirImage.$GetNameImage);
                $convert = new ConvertToWebP();
                $UpFiileConv = $convert->convert($FileWeb,80,false,'jpg');

                if($UpFiileConv->status == 1){
                    // $returnImg = $SafaryIMG;
                    $returnImg = Url::to('@raizweb/images/BlogPostImages/',true).$this->centerComponents->postBlog->AccountID.'/post/'.$SafaryIMG;
                }

            }else{
                $returnImg = Url::to('@raizweb/images/BlogPostImages/',true).$this->centerComponents->postBlog->AccountID.'/post/'.$SafaryIMG;
            }
        }

        return $returnImg;

    }


    public function getPostBlog(){
        return $this->hasOne(PostBlog::className(), ['PostBlogID' => 'PostBlogID']);
    }

    public function getPostBlogCenterComponents(){
        return $this->hasOne(PostBlogCenterComponents::className(), ['PostBlogCenterComponentID' => 'PostBlogCenterComponentID']);
    }


    ///////////////Description Image Component//////////////
    public function getDescriptions(){
        return $this->hasMany(ImagesComponentsDescription::className(), ['ImageComponentID' => 'ImageComponentID']);
    }
    public function getCurrentDescription(){
        $infoUs = Yii::$app->LocationLang->info();
        $codLang = $infoUs->language->LanguageCode;
        return $this->hasOne(ImagesComponentsDescription::className(), ['ImageComponentID' => 'ImageComponentID'])->onCondition(['Lang'=>  $codLang]);
    }

    public function getdescription(){

        $current = $this->currentDescription;

        return isset($current->Data)? $current->Data : false;


    }
    public function getimageby(){

        $current = $this->currentDescription;

        return isset($current->ImageBy)? $current->ImageBy : false;


    }
    public function getdescriptionMovil(){

        $current = $this->currentDescription;

        return isset($current->DataMovil)? $current->DataMovil : false;


    }
    ///////////////END Description Image Component//////////////

    public function getCenterComponents(){
        return $this->hasOne(PostBlogCenterComponents::className(), ['PostBlogID' => 'PostBlogID']);
    }

}
?>