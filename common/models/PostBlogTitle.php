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

class PostBlogTitle extends ActiveRecord
{
   

    public static function tableName()
    {
        return '{{%PostBlogTitle}}';
    }

	public function rules()
    {
        return [
            [[ 'Lang', 'Data', 'PostBlogID'], 'required'],
            // [['discard'], 'safe'],
            [[ 'Lang','Data'], 'string','max' => 600],


            [['PostBlogTitleID','PostBlogID'], 'number'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'Data' => 'Título del Post',
            'Lang' => 'Idioma',
        ];
    }

    public function getPostBlog(){
        return $this->hasOne(PostBlog::className(), ['PostBlogID' => 'PostBlogID']);
    }
}
?>