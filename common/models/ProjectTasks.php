<?php
namespace common\models;

use Yii;
use yii\web\UploadedFile;

class ProjectTasks extends \yii\db\ActiveRecord
{
    
    public $uploadedFile;

    public static function tableName()
    {
        return 'ProjectTasks';
    }

    public function rules()
    {
        return [
            [['OwnerTaskID','ProjectClientID','Type', 'Title', 'Description', 'Status'], 'required'],
            [['AccountID', 'Status', 'OwnerTaskID','ProjectClientID','ProjectTaskID'], 'integer'],
            [['Sprint', 'HoursWorked'],'number'],
            [['EstimatedStart', 'EstimatedEnd', 'StartTask', 'EndTask', 'DateCreate'], 'safe'],
            [['Type','Title','Description','File'],'string'],
            [['uploadedFile'], 'file', 
                'skipOnEmpty' => true,
                'maxSize' => 60 * 1024 * 1024,
                'extensions' => [
                    'jpg', 'jpeg', 'png', 'gif',
                    'mp4', 'avi', 'mov', 'mkv',
                    'pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx',
                    'zip', 'rar'
                ],
                'checkExtensionByMimeType' => true,
                'tooBig' => 'El archivo no puede ser mayor a 60 MB.',
                'wrongExtension' => 'Solo se permiten imágenes, videos, documentos de Office, PDF y archivos comprimidos (zip o rar).'
            ],
        ];
    }
    public function attributeLabels()
    {
        return [
            'ProjectClientID' => 'ID del Proyecto Cliente',
            'AccountID' => 'Usuario asignado',
            'Title' => 'Título',
            'Type' => 'Tipo',
            'Description' => 'Descripción',
            'EstimatedStart' => 'Fecha de inicio estimado',
            'EstimatedEnd' => 'Fecha de finalización estimado',
            'File' => 'Adjunto',
            'OwnerTaskID' => 'Tarea creada por',
            'uploadedFile' => 'Subir adjunto',
            'Sprint' =>  'Sprint',
            'HoursWorked' => 'Horas realizadas'


            
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $fileName = uniqid() . '_' . $this->uploadedFile->baseName . '.' . $this->uploadedFile->extension;
            $uploadPath = Yii::getAlias('@proyectroot/uploads/tasks/') . $fileName;

            if ($this->uploadedFile->saveAs($uploadPath)) {
                $this->File = $fileName;
                $this->uploadedFile = null;
                return true;
            }
        }
        return false;
    }

    public function getProject()
    {
        return $this->hasOne(ProjectsClients::class, ['ProjectClientID' => 'ProjectClientID']);
    }
    public function getAccount()
    {
        return $this->hasOne(Account::class, ['AccountID' => 'AccountID']);
    }
    public function getOwner()
    {
        return $this->hasOne(Account::class, ['AccountID' => 'OwnerTaskID']);
    }

    public function getComments()
    {
        return $this->hasMany(TaskComments::class, ['ProjectTaskID' => 'ProjectTaskID'])->orderBy(['TaskCommentID'=>SORT_ASC]);
    }
    public function getActivity()
    {
        return $this->hasMany(DevelopersWorkTimeTasks::class, ['ProjectTaskID' => 'ProjectTaskID']);
    }
}
