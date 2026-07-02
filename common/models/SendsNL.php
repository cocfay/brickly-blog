<?php
    namespace common\models;

    use yii;
    use yii\db\ActiveRecord;

    class SendsNL extends ActiveRecord
    {
        public static function tableName()
        {
            return '{{%suscribe}}';
        }

        public function rules()
        {
            return [
                [['Email'], 'required'],
                [['Email'], 'email'],
                [['Email'], 'unique'],
                [['Email'], 'string', 'max' => 255],
                [['CreatedAt'], 'safe'],
            ];
        }

        public function attributeLabels()
        {
            return [
                'Email' => 'Correo electrónico',
                'CreatedAt' => 'Fecha de suscripción',
            ];
        }
    }
