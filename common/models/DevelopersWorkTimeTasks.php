<?php
namespace common\models;

use yii\db\ActiveRecord;

class DevelopersWorkTimeTasks extends ActiveRecord
{
    public static function tableName()
    {
        return 'DevelopersWorkTimeTasks_Log';
    }

    public function rules()
    {
        return [
            [['ProjectTaskID', 'AccountID', 'Status'], 'required'],
            [['ProjectTaskID', 'AccountID', 'Status'], 'integer'],
            [['StartDate', 'EndDate'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'DeveloperWorkTimeTaskID' => 'ID de Tiempo de Trabajo',
            'ProjectTaskID' => 'ID de la Tarea del Proyecto',
            'AccountID' => 'ID de la Cuenta',
            'StartDate' => 'Fecha de Inicio',
            'EndDate' => 'Fecha de Fin',
            'Status' => 'Estado',
        ];
    }

    public function getProjectTask()
    {
        return $this->hasOne(ProjectTasks::class, ['ProjectTaskID' => 'ProjectTaskID']);
    }
    public function getAccount()
    {
        return $this->hasOne(Account::class, ['AccountID' => 'AccountID']);
    }
}
