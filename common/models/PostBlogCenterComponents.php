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

class PostBlogCenterComponents extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%PostBlogCenterComponents}}';
    }

	public function rules()
    {
        return [
            [[ 'Type', 'PostBlogID'], 'required'],
            [['PostBlogCenterComponentID','PostBlogID', 'Type'], 'number'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'Type' => 'Tipo de componente',
        ];
    }


    public function getPostBlog(){
        return $this->hasOne(PostBlog::className(), ['PostBlogID' => 'PostBlogID']);
    }

    public function getImageC(){
        return $this->hasOne(ImagesComponents::className(), ['PostBlogCenterComponentID' => 'PostBlogCenterComponentID']);
    }

    public function getTextBoxC(){
        return $this->hasOne(TextBoxComponents::className(), ['PostBlogCenterComponentID' => 'PostBlogCenterComponentID']);
    }

    public function getYtVideoC(){
        return $this->hasOne(YtVideoComponents::className(), ['PostBlogCenterComponentID' => 'PostBlogCenterComponentID']);
    }


    public function getCarouselC(){
        return $this->hasOne(CarouselComponents::className(), ['PostBlogCenterComponentID' => 'PostBlogCenterComponentID']);
    }
    
}
?>