<?php 
    namespace common\models;

    use yii;
    use yii\base\Model;
    use yii\base\NotSupportedException;
    use yii\db\ActiveRecord;
    use yii\web\UploadedFile;

    class SendsNL extends ActiveRecord
    {
        // public $PhotoProducts;
        public static function tableName()
        {
            return '{{%sendsnl}}';
        }
        /**
         * @inheritdoc
         */
        public function rules()
        {
            return [
                [['Email','KeyNL'],'string']
            ];
        }

    }

?>