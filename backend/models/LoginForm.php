<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\UserAccount;
use common\components\ValidUsers;


/**
 * Login form
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe;
    public $twoFactorAuthCode;
    public $showTAF;

    private $_user;
    public $_userData;
    private $_setdata;
    private $bandera = false;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password','twoFactorAuthCode'], 'required'],
            [['UserName'], 'string'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    public function attributeLabels()
        {
            return [
                'username' => 'Usuario/Email *',
                'password' => 'Contraseña *',
                'NumberPhone' => 'Teléfono',
                'twoFactorAuthCode' => 'Código del autenticador Google 2AF',
                'rememberMe' => 'Recordarme',
                
            ];
        }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    //el que trajo original
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Usuario o Clave Incorrecta');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    //el que trajo original
    public function login()
    {
        if ($this->getUser()) {
            /**
            Yii::$app->user->login($this->_user, $this->rememberMe ? 3600 * 24 * 30 : 0);
            */
            return true;
        } else {
            return false;
        }
    }

    public function logintoken()
    {
        if ($this->getUsertoken()) {
            /**
            Yii::$app->user->login($this->_user, $this->rememberMe ? 3600 * 24 * 30 : 0);
            */
            return true;
        } else {
            return false;
        }
    }

    protected function getUsertoken()
    {
        if ($this->_user === null) {
            $this->_userData = UserAccount::find()->where(['ApiToken' => $this->username])->one();
            if($this->_userData){
                    if($this->_userData->account->IsActive == 1){
                        if(Yii::$app->user->login($this->_userData, $this->rememberMe ? 3600 * 24 * 30 : 0)){
                             $this->_user = Yii::$app->user->identity;
                        }else{
                            $this->addError('error', 'No pudo ingresar a su cuenta.');
                            $this->_user = null;
                        }
                    }else{
                        $this->addError('error', 'Esta cuenta ha sido deshabilitada');
                        $this->_user = null;
                    }

            }else{
                 $this->addError('error', 'Token de session incorrecto');
                 $this->_user = null;
            }
        }
        return $this->_user;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_userData = UserAccount::find()->where(['UserName' => $this->username])->orWhere(['Email'=>$this->username])->one();
            if($this->_userData){
                if($this->_userData->TwoFactorActive == 1){
                    $this->showTAF = 1;
                }
                if($this->_userData->UserPassword === md5($this->password)){
                    if($this->_userData->account->IsActive == 1){
                        if($this->_userData->TwoFactorActive == 1){
                            $gTAF = new \Sonata\GoogleAuthenticator\GoogleAuthenticator();
                            if (!$gTAF->checkCode($this->_userData->TwoFactorSecrect, $this->twoFactorAuthCode,2)) {
                                Yii::$app->SessionActivity->setUserData($this->_userData)->set(['login'=>true,'Activity'=>'2AF Fail', 'ActivityStatus'=> 0, 'Status' => 0]);
                                $this->addError('error', 'Los datos no coinciden con el codigo de autenticacion.');
                                $this->_user = null;
                                return $this->_user;
                            }
                        }else{  $this->showTAF = 0; }
                        if(Yii::$app->user->login($this->_userData, $this->rememberMe ? 3600 * 24 * 30 : 0)){
                            // var_dump(Yii::$app->session->getId()); exit;
                            Yii::$app->SessionActivity->set(['login'=>true,'Activity'=>'Login OK', 'ActivityStatus'=> 1, 'Status' => 1]);
                            // exit();
                             $this->_user = Yii::$app->user->identity;
                        }else{
                            Yii::$app->SessionActivity->setUserData($this->_userData)->set(['login'=>true,'Activity'=>'Login Fail', 'ActivityStatus'=> 0, 'Status' => 0]);
                            $this->addError('error', 'No pudo ingresar a su cuenta.');
                            $this->_user = null;
                        }
                    }else{
                        Yii::$app->SessionActivity->setUserData($this->_userData)->set(['login'=>true,'Activity'=>'Login Fail', 'ActivityStatus'=> 0, 'Status' => 0]);
                        $this->addError('error', 'Esta cuenta ha sido deshabilitada');
                        $this->_user = null;
                    }
                }else{
                    Yii::$app->SessionActivity->setUserData($this->_userData)->set(['login'=>true,'Activity'=>'Login Fail', 'ActivityStatus'=> 0, 'Status' => 0]);
                    $this->addError('error', 'Contraseña Incorrecta');
                    $this->_user = null;
                }

            }else{
                 $this->addError('error', 'Usuario Incorrecto');
                 $this->_user = null;
            }
        }
        
        return $this->_user;
    }
    /**
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_userData = UserAccount::findOne(['UserName' => $this->username]);
            if($this->_userData){
                if($this->_userData->UserPassword === md5($this->password)){
                    $this->_setdata = new ValidUsers(['_userData'=>$this->_userData]);
                    $this->_setdata->Setdata();
                    $this->_user = $this->_userData;
                }else{
                    $this->addError('error', 'Contraseña Incorrecta');
                    $this->_user = null;
                }

            }else{
                 $this->addError('error', 'Usuario Incorrecto');
                 $this->_user = null;
            }
        }
        return $this->_user;
    }
    */

}

    
