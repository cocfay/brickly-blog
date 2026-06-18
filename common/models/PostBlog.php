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

class PostBlog extends ActiveRecord
{
    public $RequestFile;
    public $VTitle;
    public $TypeSave;
    public $discard;
    //public $Labels;

    public static function tableName()
    {
        return '{{%PostBlog}}';
    }

	public function rules()
    {
        return [
            [['AccountID', 'ImagePost','VTitle', 'CreateAT'], 'required'],
            // [['discard'], 'safe'],
            [['CreateAT'],  'string'],
            [['VTitle'], 'string','max' => 600],

            [['RequestFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, webp'],

            [['AccountID', 'PostBlogID', 'Featured', 'Home'], 'number'],
            //[['Labels'], 'safe']
        ];
    }

    public function attributeLabels()
    {
        $infoUs = Yii::$app->LocationLang->info();
        $lang = $infoUs->language->LanguageCode;

        $postTitle = [
            'en' => 'Post Title',
            'fr' => 'Titre du Post',
            'it' => 'Titolo del Post',
            'es' => 'Título del Post',
            'de' => 'Post-Titel',
            'pt' => 'Título do Post'
        ];

        $genre = [
            'en' => 'Genre',
            'fr' => 'Genre',
            'it' => 'Genere',
            'es' => 'Género',
            'de' => 'Genre',
            'pt' => 'Gênero'
        ];

        $postCoverImage = [
            'en' => 'Post Cover Image',
            'fr' => 'Image de couverture du post',
            'it' => 'Immagine di copertina del post',
            'es' => 'Imagen de portada del post',
            'de' => 'Beitrags-Coverbild',
            'pt' => 'Imagem de capa do post'
        ];
        
        return [
            'Title' => $postTitle[$lang],
            'VTitle' => 'Título del Post',
            'CollectionID' => 'Colecciones',
            'CreateAT' => 'Fecha de publicación',
            'RequestFile' => $postCoverImage[$lang],
            'Featured' => 'En tendencia'
        ];
    }

 	public function upload()
    {
        // if ($this->validate()) {
            $NameFile = 'doc-'.substr(md5(uniqid(rand())),0,6) . '.' . $this->RequestFile->extension;
            $this->RequestFile->saveAs(Url::to('@proyectroot/post/') . $NameFile );


            if(strtolower($this->RequestFile->extension) != 'webp'){
                        
                $FileWeb = Url::to('@proyectroot/post/') . $NameFile;
                $convert = new ConvertToWebP();
                $UpFiileConv = $convert->convert($FileWeb,80,true);

                if($UpFiileConv->status == 1){
                    $NameFile = str_replace('.'.$this->RequestFile->extension,'.webp',$NameFile);
                }

            }

            
            $this->ImagePost = Url::to('@raizweb/post/') . $NameFile;
            $this->RequestFile = null;
            return true;
        
    }

    public function PatchIMG(){

        $returnImg = $this->ImagePost;
        $user_agent = $_SERVER['HTTP_USER_AGENT']; 

        if(stripos( $user_agent, 'Safari') !== false && !(stripos( $user_agent, 'Chrome') !== false)){

            $GetNameImage = explode('/post/',$this->ImagePost);
            $GetNameImage = $GetNameImage[1];

            $fPath = \Yii::getAlias('@proyectroot');
            $dirImage = $fPath.'/post/';
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
                    $returnImg = Url::to('@raizweb/post/',true).$SafaryIMG;
                }

            }else{
                $returnImg = Url::to('@raizweb/post/',true).$SafaryIMG;
            }
        }

        return $returnImg;

    }

    public function getAccount(){
        return $this->hasOne(Account::className(), ['AccountID' => 'AccountID']);
    }
    public function getCollection(){
        return $this->hasOne(Collections::className(), ['CollectionID' => 'CollectionID']);
    }

    public function getCollectionPrimary(){
        return $this->hasOne(CollectionsPrimary::className(), ['CollectionPrimaryID' => 'CollectionPrimaryID']);
    }

    // public function getComments(){
    //     return $this->hasMany(BlogComments::className(), ['PostBlogID' => 'PostBlogID']);
    // }
    
    // public function getBlogDetails(){
    //     return $this->hasMany(BlogDetails::className(), ['PostBlogID' => 'PostBlogID']);
    // }

    ///////////////TITLES POST BLOB//////////////
    public function getTitles(){
        return $this->hasMany(PostBlogTitle::className(), ['PostBlogID' => 'PostBlogID']);
    }
    public function getCurrentTitle(){
        $infoUs = Yii::$app->LocationLang->info();
        $codLang = $infoUs->language->LanguageCode;
        return $this->hasOne(PostBlogTitle::className(), ['PostBlogID' => 'PostBlogID'])->onCondition(['Lang'=>  $codLang]);
    }

    public function gettitle(){

        $current = $this->currentTitle;

        return isset($current->Data)? $current->Data : false;


    }

    public function getComponentTextForDescription(){
        return $this->hasOne(PostBlogCenterComponents::className(), ['PostBlogID' => 'PostBlogID'])->onCondition(['Type'=>  1]);
    }
    public function getComponentImageForDescription(){
        return $this->hasMany(PostBlogCenterComponents::className(), ['PostBlogID' => 'PostBlogID'])->onCondition(['Type'=>  2]);
    }

    public function getdescription(){
        $DescriptionRT = '';
        $ComponentDescription = $this->componentTextForDescription;
        if($ComponentDescription){
           $DescriptionRT = $ComponentDescription->textBoxC->Description;
        }else{

            $ComponentDescriptionImg = $this->componentImageForDescription;
            foreach ($ComponentDescriptionImg as $ImgComponent) {
                 $Comp = $ImgComponent->imageC;
                 if(!empty($Comp->Description)){
                    $DescriptionRT = $Comp->Description;
                    break;
                 }
            }
        }

        return $DescriptionRT;
    }
    ///////////////END TITLES POST BLOB//////////////
    public function getCenterComponents(){
        return $this->hasMany(PostBlogCenterComponents::className(), ['PostBlogID' => 'PostBlogID']);
    }

    /* public function getComments(){
        return $this->hasMany(BlogComments::className(), ['PostBlogID' => 'PostBlogID']);
    } */

    public function getBlogBy(){
        return $this->hasMany(Collections::class, ['CollectionID' => 'CollectionID'])->viaTable('CollectionByPost', ['PostBlogID' => 'PostBlogID']);
    }

    public function getProject(){
        $infoUs = Yii::$app->LocationLang->info();

        $recti = ($infoUs->country_code == 'ES' || $infoUs->country_code == 'PA') ? ['!=', 'Restriction', 1] : [];
        $rGT = ($infoUs->country_code == 'GT') ? ['!=', 'NGuatemala', 1] : [];

        return $this->hasMany(Porfolio::className(), ['PorfolioID' => 'PorfolioID'])
                ->where($recti)
                ->andWhere($rGT)
                ->viaTable('BlogByProject', ['PostBlogID' => 'PostBlogID']);
    }

}
?>