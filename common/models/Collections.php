<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use common\components\ConvertToWebP;

class Collections extends ActiveRecord
{
    //public $IsNewReg;
    //public $FileImage;
    public $Name;
    public static function tableName()
    {
        return '{{%Collection}}';
    }

    public function rules()
    {
        return [
            [['Name'], 'required'],
            [['Name', 'NameEs', 'NameEn', 'NameIt', 'NameFr', 'NamePt', 'NameDe'], 'string'],
            [['Display'], 'number'],
            //[['FileImage'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, webp'],
        ];
    }

    public function attributeLabels(){
        return [
            [
                'Name' => 'Nombre'
            ]
        ];
    }

    /* public function upload()
    {
        if ($this->validate()) {
            $PhotoUrl = "item_". substr(md5(uniqid(rand())),0,6) . '.' . $this->FileImage->extension;
            $this->FileImage->saveAs(Yii::$app->basePath.'/../images/tagsbg/categoryT/' .$PhotoUrl );


            if(strtolower($this->FileImage->extension) != 'webp'){
                        
                        $FileWeb = Yii::getAlias(Yii::$app->basePath.'/../images/tagsbg/categoryT/' .  $PhotoUrl);
                        $convert = new ConvertToWebP();
                        $UpFiileConv = $convert->convert($FileWeb,80,true);

                        if($UpFiileConv->status == 1){
                             $PhotoUrl = str_replace('.'.$this->FileImage->extension,'.webp', $PhotoUrl);
                        }

            }

            $this->BackgroundUrl =  $PhotoUrl;
            $this->FileImage = null;

            return true;
        } else {
            return false;
        }
    }

    public function PatchBackgroundIMG(){
        
        $returnImg = $this->BackgroundUrl;
        $user_agent = $_SERVER['HTTP_USER_AGENT']; 

        if(stripos( $user_agent, 'Safari') !== false && !(stripos( $user_agent, 'Chrome') !== false)){

            $fPath = \Yii::getAlias('@webroot');
            $dirImage = $fPath.'/images/tagsbg/categoryT/';

            $ext = pathinfo($dirImage.$this->BackgroundUrl, PATHINFO_EXTENSION);

            $SafaryIMG = str_replace(
                                    ['.'.strtolower($ext),'.'.strtoupper($ext)],
                                    ['.jpg','.jpg'],
                                    $this->BackgroundUrl
                                );
            if(!file_exists($dirImage.$SafaryIMG)){
                $FileWeb = Yii::getAlias($dirImage.$this->BackgroundUrl);
                $convert = new ConvertToWebP();
                $UpFiileConv = $convert->convert($FileWeb,80,false,'jpg');

                if($UpFiileConv->status == 1){
                    $returnImg = $SafaryIMG;
                }

            }else{
                $returnImg = $SafaryIMG;
            }
        }

        return $returnImg;

    } */

        /**
        * @return \yii\db\ActiveQuery
         */

    /* public function getBlog()
	{
		return $this->hasOne(Blog::className(), ['CollectionID' => 'CollectionID']);
	} */

   /*  public function getObjectCollections()
    {
        return $this->hasMany(ObjectCollections::className(), ['CollectionID' => 'CollectionID'])->orderBy(['Position' => SORT_ASC]);
    } */
    /* public function getTypes()
    {
        return $this->hasMany(TypeObject::className(), ['CollectionID' => 'CollectionID']);
    } */

    public function getPosts(){
        return $this->hasMany(PostBlog::class, ['PostBlogID' => 'PostBlogID'])->viaTable('CollectionByPost', ['CollectionID' => 'CollectionID']);
    }

}
?>