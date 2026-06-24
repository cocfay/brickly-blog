<?php
namespace common\models;

use Yii;
use yii\base\Model;
use common\models\UserAccount;
use common\components\ValidUsers;
use common\components\ConvertToWebP;
use yii\web\UploadedFile;


class ChecklistFilesForm extends Model
{
    public $ConditionID;
    public $ImageFile;
    public $AccountID;
    public $UrlIMG;
    public $NameFileSv;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // UserName and Password are both required
            [['ConditionID'], 'required'],
            [['UrlIMG'], 'string'],
            [['AccountID'], 'number'],
            [['ImageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, jpeg, webp, PNG, JPG, JPEG, WEBP'],
        
        ];
    }

    public function attributeLabels()
        {
            return [
                'UserName' => 'Usuario *',
                'Password' => 'Contraseña *',
                'NumberPhone' => 'Teléfono',
                'RememberMe' => 'Recordarme',
                'Name' => 'Nombre',
                'CountryID' => 'Pais',
                'Email' => 'Email *',
                'Password2' => 'RE. Comtraseña'
                
            ];
        }

   public function upload($patch = false)
    {
        if($patch){
            if ($this->validate()) {
                $this->NameFileSv = time().uniqid().'_'.$this->ConditionID. '.' . $this->ImageFile->extension;
                $this->ImageFile->saveAs($patch . $this->NameFileSv);

                if(strtolower($this->ImageFile->extension) != 'webp'){
                        
                        $FileWeb = Yii::getAlias($patch . $this->NameFileSv);
                        $convert = new ConvertToWebP();
                        $UpFiileConv = $convert->convert($FileWeb,80,true);
                        if($UpFiileConv->status == 1){
                            $this->NameFileSv = str_replace('.'.$this->ImageFile->extension,'.webp',$this->NameFileSv);
                        }

                    }


                return true;
            } else {
                return false;
            }
        }else{ return false; }
    }

}

    
