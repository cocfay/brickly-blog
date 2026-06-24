<?php
namespace common\models;
use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Url;

class ProjectsClients extends ActiveRecord
{
    public $uploadedFile;
    public $UsersFollowers;
    public $FileGantt;

    public static function tableName()
    {
        return 'ProjectsClients';
    }

    public function rules()
    {
        return [
            [['AccountID', 'Name', 'Type'], 'required'],
            [['AccountID','ProjectClientID','UseGantt','ServiceID','ShowDates','Completed','HoursCompleted'], 'integer'],
            // [['Sprint'], 'number'],
            [['Name'], 'string', 'max' => 60],
            [['Type'], 'string', 'max' => 20],
            [['LinkDev', 'LinkPro', 'Logo','UrlGantt'], 'string', 'max' => 120],
            [['UsersFollowers'],'safe'],
            [['uploadedFile'], 'file', 
                'skipOnEmpty' => true,
                'maxSize' => 4 * 1024 * 1024,
                'extensions' => [
                    'jpg', 'jpeg', 'png', 'gif',
                ],
                'checkExtensionByMimeType' => true,
                'tooBig' => 'El archivo no puede ser mayor a 4 MB.',
                'wrongExtension' => 'Solo se permiten imágenes.'
            ],
            [['FileGantt'], 'file', 
                'skipOnEmpty' => true,
                'maxSize' => 4 * 1024 * 1024,
                'extensions' => [
                    'pdf', 'xls', 'csv',
                ],
                'checkExtensionByMimeType' => true,
                'tooBig' => 'El archivo no puede ser mayor a 4 MB.',
                'wrongExtension' => 'Solo se permiten documentos.'
            ],
        ];
    }
    public function upload()
    {
        if ($this->validate()) {
            $fileName = uniqid() . '_' . time() . '.' . $this->uploadedFile->extension;
            $uploadPath = Yii::getAlias('@proyectroot/uploads/projects/logos') .'/'. $fileName;

            if ($this->uploadedFile->saveAs($uploadPath)) {
                $this->Logo = $fileName;
                $this->uploadedFile = null;
                return true;
            }
        }
        return false;
    }
    public function uploadGantt()
    {
        if ($this->validate()) {
            $fileName = uniqid() . '_' . time() . '.' . $this->FileGantt->extension;
            $uploadPath = Yii::getAlias('@proyectroot/uploads/projects/gantts') .'/'. $fileName;

            if ($this->FileGantt->saveAs($uploadPath)) {
                $this->UrlGantt = Url::to('@raizweb',true) . '/uploads/projects/gantts/'. $fileName;
                $this->FileGantt = null;
                return true;
            }
        }
        return false;
    }

    public function attributeLabels()
    {
        return [
            'ProjectClientID' => 'ID del proyecto cliente',
            'AccountID' => 'ID de la cuenta',
            'Name' => 'Nombre',
            'Type' => 'Tipo',
            'LinkDev' => 'Enlace dev',
            'LinkPro' => 'Enlace prod',
            'Logo' => 'Logo',
            'UsersFollowers' => 'Seguidores del proyecto',
            'UseGantt' => 'Mostrar gantt',
            'UrlGantt' => 'Link gantt',
            'FileGantt' => 'Archivo gantt',
            'DriveLink' => 'Enlace de drive',
            'ShowDates' => 'Mostrar Fechas',
            'HoursCompleted' => 'Horas por completar'
            // 'Sprint' =>  'Sprint'
        ];
    }

    public function getFollowers(){
        return $this->hasMany(ProjectFollowers::class, ['ProjectClientID' => 'ProjectClientID']);
    }
    public function getTasks(){
        return $this->hasMany(ProjectTasks::class, ['ProjectClientID' => 'ProjectClientID']);
    }
    public function getTasksQa(){
        return $this->hasMany(ProjectTasks::class, ['ProjectClientID' => 'ProjectClientID'])->onCondition(['Type'=>'qa']);
    }
    public function getTasksGantt(){
        return $this->hasMany(ProjectTasks::class, ['ProjectClientID' => 'ProjectClientID'])->onCondition(['Type'=>'gantt'])->orderBy(['Sprint' => SORT_ASC,'EstimatedStart'=>SORT_ASC]);
    }
    public function getAccount(){
        return $this->hasOne(Account::class, ['AccountID' => 'AccountID']);
    }
    public function getClientAnexos(){
        return $this->hasMany(ProjectsClientsAnexos::class, ['ProjectClientID' => 'ProjectClientID']);
    }
    public function getClientAnexo(){
        return $this->hasOne(ProjectsClientsAnexos::class, ['ProjectClientID' => 'ProjectClientID']);
    }
    public function getService(){
        return $this->hasOne(Services::class, ['ServiceID' => 'ServiceID']);
    }
}
