<?php
namespace common\models;
use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Url;

class ProjectsClientsAnexos extends ActiveRecord{

    public $FilePrice;
    public $FileService;

    public static function tableName(){
        return 'ProjectsClientsAnexos';
    }

    public function rules() {
        return [
            [['Text'], 'required'],
            [['Type', 'ProjectClientID'], 'integer'],
            [['Link', 'File'], 'string'],
            [['FilePrice'], 'file', 
                'skipOnEmpty' => true,
                'maxSize' => 4 * 1024 * 1024,
                'extensions' => 'pdf, doc, docx, csv, xls', 
                'checkExtensionByMimeType' => true,
                'tooBig' => 'El archivo no puede ser mayor a 4 MB.',
                'wrongExtension' => 'Solo se permiten documentos.'
            ],
            [['FileService'], 'file', 
                'skipOnEmpty' => true,
                'maxSize' => 4 * 1024 * 1024,
                'extensions' => 'pdf, doc, docx, csv, xls', 
                'checkExtensionByMimeType' => true,
                'tooBig' => 'El archivo no puede ser mayor a 4 MB.',
                'wrongExtension' => 'Solo se permiten documentos.'
            ],
        ];
    }

    public function attributeLabels(){
        return [
            'Text' => 'Título',
            'Type' => 'Tipo',
            'Link' => 'Enlace',
            'FilePrice' => 'Subir archivo',
            'FileService' => 'Subir archivo'
        ];
    }

    public function upload($t){
        if($this->validate()) {
            $nFile = $t == 0 ? 'cotizacion' : 'documento';
            $tFile = $t == 0 ? 'FilePrice' : 'FileService';

            $randomString = Yii::$app->security->generateRandomString(4);
            $FileTemp = $nFile . '_' . strtolower(str_replace(' ', '_', $this->Text)) . '_' . date('d-m-Y') . '_' . $randomString . '.' . $this->$tFile->extension;
         
            $this->$tFile->saveAs(Yii::$app->basePath.'/../uploads/admin/'.$tFile.'/'.$FileTemp);
            $this->File = Url::to('uploads/admin/').$tFile.'/'.$FileTemp;

            $this->$tFile = null;

            return true;
        }else {
            return false;
        }
    }

    public function getProjectClient(){
        return $this->hasOne(ProjectsClients::class, ['ProjectClientID' => 'ProjectClientID']);
    }

}

?>