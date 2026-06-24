<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
//use common\components\ConvertToWebP;

class BlogByProject extends ActiveRecord
{
    /* public $CollectionID;
    public $BlogPostID; */
    public $Project;

    public static function tableName()
    {
        return '{{%BlogByProject}}';
    }

    public function rules()
    {
        return [
            [['PorfolioID', 'PostBlogID'], 'number'],
            [['Project'], 'default', 'value' => []],
            [['Project'], 'safe']
        ];
    }

    /* public function getProject(){
        return $this->hasMany(Collection::className(), ['CollectionID' => 'CollectionID']);
    } */

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
