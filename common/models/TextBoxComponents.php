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

class TextBoxComponents extends ActiveRecord
{
    public $VDescription;

    public static function tableName()
    {
        return '{{%TextBoxComponents}}';
    }

	public function rules()
    {
        return [
            [[ 'PostBlogID', 'PostBlogCenterComponentID'], 'required'],
            // [['discard'], 'safe'],
            [[ 'VDescription'], 'string'],

            [['PostBlogCenterComponentID', 'PostBlogID'], 'number'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'Description' => 'Texto',
            'VDescription' => 'Texto',
        ];
    }


    public function getPostBlog(){
        return $this->hasOne(PostBlog::className(), ['PostBlogID' => 'PostBlogID']);
    }

    public function getPostBlogCenterComponents(){
        return $this->hasOne(PostBlogCenterComponents::className(), ['PostBlogCenterComponentID' => 'PostBlogCenterComponentID']);
    }


    ///////////////Description Image Component//////////////
    public function getDescriptions(){
        return $this->hasMany(TextBoxComponentsData::className(), ['TexBoxComponentID' => 'TexBoxComponentID']);
    }
    public function getCurrentDescription(){
        $codLang = Yii::$app->language ?: 'es';
        return $this->hasOne(TextBoxComponentsData::className(), ['TexBoxComponentID' => 'TexBoxComponentID'])->onCondition(['Lang'=>  $codLang]);
    }

    public function getdescription(){

        $current = $this->currentDescription;

        return isset($current->Data)? $current->Data : false;


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