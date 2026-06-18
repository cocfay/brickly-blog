<?php
namespace common\models;

use yii\db\ActiveRecord;

class DevelopersByTasks extends ActiveRecord
{
    public static function tableName()
    {
        return 'DevelopersByTasks';
    }

    public function rules()
    {
        return [
            [['ProjectTaskID', 'AccountID', 'Status'], 'required'],
            [['ProjectTaskID', 'AccountID', 'Status'], 'integer'],
            [['StartTask', 'EndTask', 'DateCreate'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'DeveloperByTaskID' => 'ID del Desarrollador por Tarea',
            'ProjectTaskID' => 'ID de la Tarea del Proyecto',
            'AccountID' => 'ID de la Cuenta',
            'Status' => 'Estado',
            'StartTask' => 'Inicio de Tarea',
            'EndTask' => 'Fin de Tarea',
            'DateCreate' => 'Fecha de Creación',
        ];
    }

    public function getProjectTask()
    {
        return $this->hasOne(ProjectTasks::class, ['ProjectTaskID' => 'ProjectTaskID']);
    }
}
