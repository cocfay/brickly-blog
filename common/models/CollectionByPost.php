<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
//use common\components\ConvertToWebP;

class CollectionByPost extends ActiveRecord
{
    /* public $CollectionID;
    public $BlogPostID; */
    public $Labels;

    public static function tableName()
    {
        return '{{%CollectionByPost}}';
    }

    public function rules()
    {
        return [
            [['CollectionID', 'PostBlogID'], 'number'],
            [['Labels'], 'safe']
        ];
    }

    public function getByCollection(){
        return $this->hasMany(Collection::className(), ['CollectionID' => 'CollectionID']);
    }

    /* public function attributeLabels(){
        return [
            [
                'Name' => 'Nombre'
            ]
        ];
    } */


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

}
?>