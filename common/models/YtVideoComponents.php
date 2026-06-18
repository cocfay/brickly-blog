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

class YtVideoComponents extends ActiveRecord
{
    public $RequestFile;
    public $VDescription;

    public static function tableName()
    {
        return '{{%YtVideoComponents}}';
    }

	public function rules()
    {
        return [
            [[ 'PostBlogID', 'PostBlogCenterComponentID','UrlVideo'], 'required'],
            // [['discard'], 'safe'],
            [[ 'UrlVideo'], 'string','max' => 600],

            [['PostBlogCenterComponentID', 'PostBlogID'], 'number'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'UrlVideo' => 'Enlace del video',
        ];
    }


    public function getPostBlog(){
        return $this->hasOne(PostBlog::className(), ['PostBlogID' => 'PostBlogID']);
    }

    public function getPostBlogCenterComponents(){
        return $this->hasOne(PostBlogCenterComponents::className(), ['PostBlogCenterComponentID' => 'PostBlogCenterComponentID']);
    }

    public function getCenterComponents(){
        return $this->hasOne(PostBlogCenterComponents::className(), ['PostBlogID' => 'PostBlogID']);
    }

}
?>