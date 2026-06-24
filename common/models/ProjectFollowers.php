<?php
namespace common\models;

use yii\db\ActiveRecord;

class ProjectFollowers extends ActiveRecord
{
    public static function tableName()
    {
        return 'ProjectFollowers';
    }

    public function rules()
    {
        return [
            [['ProjectClientID', 'AccountID'], 'required'],
            [['ProjectClientID', 'AccountID'], 'integer'],
            [['DateFollow'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'ProjectFollowerID' => 'ID del Seguidor del Proyecto',
            'ProjectClientID' => 'ID del Proyecto Cliente',
            'AccountID' => 'ID de la Cuenta',
            'DateFollow' => 'Fecha de Seguimiento',
        ];
    }

    public function getProjectsClient()
    {
        return $this->hasOne(ProjectsClients::class, ['ProjectClientID' => 'ProjectClientID']);
    }
}
