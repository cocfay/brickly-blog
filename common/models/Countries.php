<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\ActiveQuery;

class Countries extends ActiveRecord{

    public static function tableName(){
        return '{{%Country}}';
    }

}

?>