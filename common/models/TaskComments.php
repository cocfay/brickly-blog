<?php
namespace common\models;

use Yii;
use yii\web\UploadedFile;

class TaskComments extends \yii\db\ActiveRecord
{
    public $uploadedFile;

    public static function tableName()
    {
        return 'TaskComments';
    }

    public function rules()
    {
        return [
            [['AccountID', 'Comment'], 'required'],
            [['Comment', 'File'], 'string'],
            [['AccountID', 'ProjectTaskID'], 'integer'],
            [['DateCreate'], 'safe'],
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

    public function upload()
    {
        if ($this->validate()) {
            $fileName = uniqid() . '_' . $this->uploadedFile->baseName . '.' . $this->uploadedFile->extension;
            $uploadPath =  Yii::getAlias('@proyectroot/uploads/comments/') . $fileName;

            if ($this->uploadedFile->saveAs($uploadPath)) {
                $this->File = $fileName;
                $this->uploadedFile = false;
                return true;
            }
        }
        return false;
    }
    public function getAccount()
    {
        return $this->hasOne(Account::class, ['AccountID' => 'AccountID']);
    }
}
