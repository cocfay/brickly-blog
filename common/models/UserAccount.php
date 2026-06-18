<?php
namespace common\models;

use Yii;
use yii\base\Model;
use yii\helpers\Url;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\web\UploadedFile;

class UserAccount extends ActiveRecord implements IdentityInterface
{
    public $PhotoProfile;
    public $auth_key;
    public $layoutUse;
    public $rUserPassword;
    public static function tableName()
    {
        return '{{%UserAccount}}';
    }

    public function rules()
    {
        return [
            [['UserName','Name','Email','UserPassword','rUserPassword'], 'required'],
            [['UserName','Name'], 'string'],
            [['UserPassword','PhotoUrl','Address'], 'string'],
            [['UserName'], 'unique','targetClass'=>'\common\models\UserAccount', 'message' => 'El nombre de usuario que elegiste ya se encuentra en uso','when' => function ($model, $attribute) {
               return $model->{$attribute} !== $model->getOldAttribute($attribute);
           },],
            [['Email'], 'email'],
            [['Email'],'unique','targetClass'=>'\common\models\UserAccount', 'message' => 'El correo electrónico que ingresaste ya se encuentra en uso', 'when' => function ($model, $attribute) {
               return $model->{$attribute} !== $model->getOldAttribute($attribute);
           },],
            [['NumberPhone'], 'string'],
            [['TypeUser','CountryID'],'integer', 'integerOnly'=>true],
            [['PhotoProfile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
            [['rUserPassword'],'compare', 'compareAttribute' => 'UserPassword', 'message' => "Las contraseñas no coinciden"],
            [['ImgCompany'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, webp'],

        ];
    }

    public function upload(){
        if ($this->validate()) {
            $this->PhotoUrl = $this->PhotoProfile->baseName . "_". substr(md5(uniqid(rand())),0,6) . '.' . $this->PhotoProfile->extension;
            $this->PhotoProfile->saveAs(Yii::$app->basePath.'/../images/profile/' .$this->PhotoUrl );
            $this->PhotoProfile = null;

            return true;
        } else {
            return false;
        }
    }

    public function imgCompany(){
        //if($this->validate()) {
            $PhotoTemp = "ImgCompany_". substr(md5(uniqid(rand())),0,6) . '.' . $this->ImgCompany->extension;
            $this->ImgCompany->saveAs(Yii::$app->basePath.'/../admin/images/company/'.$PhotoTemp);
            $this->ImgCompany = Url::to('company/').$PhotoTemp;
            //$this->ImgCompany = null;

            return true;

        //}else {
           //return false;
        //}
    }

    public function attributeLabels()
    {
        return [
            'UserName' => 'Nombre de usuario',
            'Name' => 'Nombre',
            'UserPassword' => 'Clave de usuario',
            'rUserPassword' => 'Repita la clave de usuario',
            'TypeUser' => 'Tipo de Usuario',
            'PhotoProfile' => 'Foto de perfil',
            'CountryID' => 'País',
            'Address' => 'Dirección',
            'Email' => 'Correo electrónico',
            'NumberPhone' => 'Número de teléfono',
        ];
    }

    public function getLayout()
    {
        /*switch ($this->TypeUser){
                         case '1':
                             $this->layoutUse = "/admin";
                             break;
                         case '2':
                             $this->layoutUse = "/main";
                             break;
                         case '3':
                             $this->layoutUse = "/";
                             break;
                     }*/
        if($this->AccountID == 207){
            $current = (array) explode('/',Yii::$app->request->url);

            // var_dump($current); exit();
            if(in_array('admin',$current)){
                Yii::$app->getResponse()->redirect(Yii::$app->urlManagerCpanel->createUrl('/'));
            }
            return '/template';
        }
        return $this->typeUsers->Layout;
    }
        
     public function validatePassword($password)
    {
        return static::findOne(['UserPassword' => md5($password)]);
    }
    
    public static function findIdentity($id)
    {
        return static::findOne(['UserName' => $id]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }
    
        /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }
    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
    * @return \yii\db\ActiveQuery
     */
    public function getAccount()
    {
        return $this->hasOne(Account::className(), ['AccountID' => 'AccountID']);
    }
    public function getBillingInfo()
    {
        return $this->hasOne(BillingInfo::className(), ['AccountID' => 'AccountID']);
    }

    public function getClients()
    {
        return $this->hasOne(Clients::className(), ['AccountID' => 'AccountID']);
    }
    public function getTypeUsers()
    {
        return $this->hasOne(TypeUsers::className(), ['TypeUsersID' => 'TypeUser']);
    }
    public function getCountry()
    {
        return $this->hasOne(Countries::className(), ['CountryID' => 'CountryID']);
    }
    
    /**
    * @return \yii\db\ActiveQuery
     */
    public function getUserByRoles()
    {
        return $this->hasMany(UserByRole::className(), ['UserName' => 'UserName']);
    }

    public function getRolesId()
    {
        return $this->hasMany(UserByRole::className(), ['UserName' => 'UserName'])->select(['RoleID'])->column();
    }

    public function getProjectsPersonalized()
    {
        return $this->hasMany(ProjectsClients::className(), ['AccountID' => 'AccountID'])->onCondition(['Type'=>'Personalizado']);
    }
    public function getProjectsSaas()
    {
        return $this->hasMany(ProjectsClients::className(), ['AccountID' => 'AccountID'])->onCondition(['Type'=>'SAAS']);
    }
    public function getProjectsOutsourcing()
    {
        return $this->hasMany(ProjectsClients::className(), ['AccountID' => 'AccountID'])->onCondition(['Type'=>'Outsourcing']);
    }

}
?>
