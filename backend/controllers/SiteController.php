<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\LoginForm;
use common\components\ValidUsers;
use common\models\LeadForm;
use common\models\UserAccount;
use common\models\Cvs;
use common\models\Account;
use common\models\UserByRole;
use common\models\Countries;
use yii\helpers\ArrayHelper;
use common\models\ReminderSSL;
use backend\models\Email;

use yii\authclient\AuthAction;
use yii\authclient\ClientInterface;
use yii\web\Response;
use yii\db\Expression;
use DateTime;
use DateInterval;


/**
 * Site controller 
 */
class SiteController extends Controller
{

    /**
     * @inheritdoc
     */
     public function behaviors()
     {
         return [
             'access' => [
                 'class' => AccessControl::className(),
                 'rules' => [
                     [
                         'actions' => ['login', 'signup','error','index','admin-login', 'listacvs', 'readcv', 'delete','checkusetaf','auth-social','social2af','approvecvs', 'reminder-ssl', 'ssltable', 'delete-url'],
                         'allow' => true,
                     ],
                     [
                         'actions' => ['logout','index','auth-social'],
                         'allow' => true,
                         'roles' => ['@'],
                     ],
                 ],
             ],
             'verbs' => [
                 'class' => VerbFilter::className(),
                 'actions' => [
                     // 'logout' => ['post'],
                 ],
             ],
         ];
     }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        // $data = Yii::$app->session->get('UserData');
        // $this->layout = "/admin";
        // (!Yii::$app->user->isGuest)? $this->layout = "404" :  $this->layout = "/main";
        $this->layout = false;
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'auth-social' => [
                'class' => AuthAction::class,
                'successCallback' => [$this, 'onAuthSuccess']
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {

        $this->layout = explode("/", $_SERVER['REQUEST_URI'])[2] === 'admin' ? "/simple" : "/simpleCpanel";

        // if (!Yii::$app->user->isGuest) {
        //      return $this->redirect(Yii::$app->urlManager->createUrl('/home'));
        //      }
        $data = [];
        if(!Yii::$app->user->isGuest) {
            return $this->redirect(Yii::$app->urlManager->createUrl('/home'));
        }

        $model = new LoginForm();
        if($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(Yii::$app->urlManager->createUrl('/home'));
        }else{
            $data['model'] =$model;
            // $post = Post::find()->asArray()->all();
            /*var_dump(Yii::$app->user->LayoutUser);exit;*/
            return $this->render('index',$data);
        }
    }

    public function actionSignup(){
        $this->layout = "/simple";

        $infoUs = Yii::$app->LocationLang->info();
		$lang = $data['lang'] = $infoUs->language->LanguageCode;

        $data = [];
        if(!Yii::$app->user->isGuest) {
            return $this->redirect(Yii::$app->urlManager->createUrl('/home'));
        }

        $nameC = $lang == 'es' ? 'Name' : 'Name_en';
        $contryList = Countries::find()->select(['*', $nameC.' AS Name'])->orderBy([$nameC => SORT_ASC])->all();
        $cc = Countries::find()->select(['CountryID'])->where(['Abbreviation' => $infoUs->country_code])->one();
        $data['contryList'] = ArrayHelper::map($contryList, 'CountryID', 'Name');
        $data['countryCode'] = $cc->CountryID;

        $data['model'] = new UserAccount;
        $ModelAccount = new Account;
        $ModelByRole = new UserByRole;

        if($data['model']->load(Yii::$app->request->post())){
            if($data['model']->validate()){

                $ModelAccount->IsActive = 1;
                $ModelAccount->AuditDate = new Expression('NOW()');
                $ModelAccount->AuditUser = "System";

                if(!$ModelAccount->save()){
                    Yii::$app->session->setFlash('error', "There was an error creating the user.");
                    $transaction->rollBack();

                    echo "create Account";
                    exit();
                }

                $data['model']->AccountID = $ModelAccount->AccountID;
                $data['model']->TypeUser = 2;
                $data['model']->ApiToken = $this->random_str(60);
                $data['model']->UserPassword = md5($data['model']->UserPassword);
                $data['model']->rUserPassword = md5($data['model']->rUserPassword);
                if($data['model']->save()){
                    $ModelByRole->UserName = $data['model']->UserName;
                    $ModelByRole->RoleID = 2;
                    if($ModelByRole->save()){
                        return $this->redirect(Yii::$app->urlManager->createUrl('/home'));
                    }
                }
            }/* else{
                echo '<pre>';
                print_r($data['model']->getErrors());
                echo '</pre>';
                exit;
            } */
        }

        return $this->render('registeradmin',$data);
    }

    public function actionCheckusetaf($id = false){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if(!$id || empty($id)){
            return false;
        }
       $userAccount =  UserAccount::findOne($id);
       if($userAccount){
        return ['status' => ($userAccount->TwoFactorActive == 1)? true : false];
       }
       return ['status' => false];

    }

    public function actionAdminLogin()
    {
        $this->layout = "/simple";
        // if (!Yii::$app->user->isGuest) {
        //      return $this->redirect(Yii::$app->urlManager->createUrl('/home'));
        //      }
            $data = [];
            if (!Yii::$app->user->isGuest) {
                if(Yii::$app->user->identity->AccountID == 207){
                    return $this->redirect(Yii::$app->urlManagerCpanel->createUrl('/home'));

                }else{
                    return $this->redirect(Yii::$app->urlManager->createUrl('/home'));
                }
             }
              $model = new LoginForm();
              if ($model->load(Yii::$app->request->post()) && $model->login()) {
                if(Yii::$app->user->identity->AccountID == 207){
                    return $this->redirect(Yii::$app->urlManagerCpanel->createUrl('/home'));

                }
                $usuario = Yii::$app->user->identity->UserName; //correo si es gmail / usuario si se registra desde el formulario
                $nameUser = Yii::$app->user->identity->Name;
                \Yii::$app->SystemNotifications->sendPushNotificationGeneric("Login", "({$nameUser}) ha iniciado sesión usuario: {$usuario}", ['weclickdigital']);
                return $this->redirect(Yii::$app->urlManager->createUrl('/home'));
            }else {
            $data['model'] =$model;
            // $post = Post::find()->asArray()->all();
            /*var_dump(Yii::$app->user->LayoutUser);exit;*/
            return $this->render('loginadmin',$data);
        }
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
       $this->layout = "/simple";
            $data = [];
            if (!Yii::$app->user->isGuest) {
             return $this->redirect(Yii::$app->urlManager->createUrl('/home'));
             }
              $model = new LoginForm();
              if ($model->load(Yii::$app->request->post()) && $model->login()) {
                
                return $this->redirect(Yii::$app->urlManager->createUrl('/home'));
            }else {
            $data['model'] =$model;
            // $post = Post::find()->asArray()->all();
            /*var_dump(Yii::$app->user->LayoutUser);exit;*/
            return $this->render('index',$data);
        }
    }
    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->SessionActivity->out();
        Yii::$app->user->logout();
        return $this->goHome();
    }

    public function actionListacvs($type = 1){

        $UserData =  Yii::$app->AccessControl->Verify();
        
        $data = [];
        $this->layout = $UserData->getLayout();
        
        $type = $type == 1 ? 'interested_job' : 'seller';
        
        $model = Cvs::find()->where(['Type' => $type])->orderBy(['Approve' => SORT_ASC, 'CvID' => SORT_DESC]);

        $data['dataProvider']  = new ActiveDataProvider([
            'query' => $model,
            'pagination' => [
                'pageSize' => 8,
            ],
        ]);

        return $this->render('cvs', $data);
    }

    public function actionReadcv($id){
        $UserData =  Yii::$app->AccessControl->Verify();

        $data = [];
        $this->layout = false;

        $model = Cvs::findOne($id);

        $filePath = Yii::$app->basePath . '/../' . $model->File;

        // Obtener información del archivo
        $fileInfo = pathinfo($filePath);
        $extension = strtolower($fileInfo['extension']);
        $fileName = $fileInfo['basename'];

        // Mapear extensiones a tipos MIME comunes
        $mimeTypes = [
            'pdf' => 'application/pdf',
            'doc' => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'webp' => 'image/webp'
        ];

        // Determinar si el archivo se debe mostrar en el navegador o forzar descarga
        $shouldDisplayInline = in_array($extension, ['pdf', 'jpg', 'jpeg', 'png', 'gif', 'webp']);

        // Configurar los headers adecuados
        if (isset($mimeTypes[$extension])) {
            header("Content-Type: " . $mimeTypes[$extension]);
            
            if ($shouldDisplayInline) {
                header("Content-Disposition: inline; filename=\"$fileName\"");
            } else {
                header("Content-Disposition: attachment; filename=\"$fileName\"");
            }

            header("Content-Length: " . filesize($filePath));
            //header("Content-Disposition:attachment;filename=\"downloaded.pdf\"");
            readfile($filePath);
        }
    
    }

    public function actionApprovecvs($id){
        
        $UserData =  Yii::$app->AccessControl->Verify();
        
        $data = [];

        $cv = Cvs::findOne($id);

        $ModelAccount = new Account;
		$ModelUserAccount = new UserAccount;
		$ModelByRole = new UserByRole;

        $ModelAccount->IsActive = 1;
        $ModelAccount->AuditDate = new Expression('NOW()');
        $ModelAccount->AuditUser = "System";

        if(!$ModelAccount->save()){
            Yii::$app->session->setFlash('error', "There was an error creating the user.");
            //$transaction->rollBack();
            var_dump($ModelAccount->getErrors());
            echo "create Account";
            exit();
        }

        $ModelUserAccount->AccountID = $ModelAccount->AccountID;
        $ModelUserAccount->UserName = $this->generarUsuario($cv->Email);
        $ModelUserAccount->Name = $cv->Name;
        $ModelUserAccount->TypeUser = 3;
        $ModelUserAccount->Email = $cv->Email;
        $ModelUserAccount->NumberPhone = $cv->Phone;
        $ModelUserAccount->PhotoUrl = 'avatar2.png';
        $ModelUserAccount->ApiToken = $this->random_str(60);
        $ModelUserAccount->UserPassword = md5('ContraseñaTemp.2025');
        $ModelUserAccount->rUserPassword = md5('ContraseñaTemp.2025');
        
        if(!$ModelUserAccount->save()){
            Yii::$app->session->setFlash('error', "There was an error creating the user.");
    
            // Mostrar errores detallados
            echo "<h2>Errores en UserAccount:</h2>";
            echo "<pre>";
            print_r($ModelUserAccount->getErrors());
            echo "</pre>";
            
            // También puedes ver los atributos que se estaban intentando guardar
            echo "<h2>Atributos del modelo:</h2>";
            echo "<pre>";
            print_r($ModelUserAccount->attributes);
            echo "</pre>";
            
            exit();
        }

        $ModelByRole->UserName =  $ModelUserAccount->UserName;
        $ModelByRole->RoleID = 18;
        if(!$ModelByRole->save()){
            Yii::$app->session->setFlash('error', "Ocurrio un error al intentar crear el usuario, porfavor intentelo nuevamente.");
            //$transaction->rollBack();
            echo "UserByRole";
            exit();
        }
        
        $cv->Approve = 1;
        $cv->save();
        Yii::$app->session->setFlash('success', "Aprobado exitosamente, el correo fue enviando");
        Yii::$app->Emails->ARPassword($ModelUserAccount);
        return $this->redirect(Yii::$app->request->referrer);

        /* $this->layout = $UserData->getLayout();
        
        $type = $type == 1 ? 'interested_job' : 'seller';
        
        $model = Cvs::find()->where(['Type' => $type])->orderBy(['CvID' => SORT_DESC]);

        $data['dataProvider']  = new ActiveDataProvider([
            'query' => $model,
            'pagination' => [
                'pageSize' => 8,
            ],
        ]);

        return $this->render('cvs', $data); */
    }

    public function actionDelete($id){
        $UserData =  Yii::$app->AccessControl->Verify();

        $data = [];
        $this->layout = false;

        $model = Cvs::findOne($id);

        $filePath = Yii::$app->basePath . '/../' . $model->File;

        $deleteFile = false;

        if(file_exists($filePath)){
            if(unlink($filePath))
                $deleteFile = true;
        }

        if($model->delete() && $deleteFile){
            return $this->redirect(Yii::$app->request->referrer);
            Yii::$app->session->setFlash('success', 'Registro eliminado.');
        }else{
            return $this->redirect(Yii::$app->request->referrer);
            Yii::$app->session->setFlash('error', 'Error al eliminar el registro.');
        }
    }

    public function actionSocial2af(){
        $this->layout = "/simple";
        $data = [];
        $data['loginModel'] = new LoginForm();
        if($data['loginModel']->load(Yii::$app->request->post())){

            $userAccount = UserAccount::findOne($data['loginModel']->username);
           
            $gTAF = new \Sonata\GoogleAuthenticator\GoogleAuthenticator();
            if (!$gTAF->checkCode($userAccount->TwoFactorSecrect, $data['loginModel']->twoFactorAuthCode,2)) {
                Yii::$app->SessionActivity->setUserData($userAccount)->set(['login'=>true,'Activity'=>'2AF Fail', 'ActivityStatus'=> 0, 'Status' => 0]);
            }else{
                $nameUser = $userAccount->Name;
                $usuario = $userAccount->Email;
                 \Yii::$app->SystemNotifications->sendPushNotificationGeneric("Login", "({$nameUser}) ha iniciado sesión correo: {$usuario}", ['weclickdigital']);
                Yii::$app->user->login($userAccount, 3600 * 24 * 30);
            }
        }
        if (Yii::$app->session->hasFlash('userlogin')){
            $user = Yii::$app->session->getFlash('userlogin');
            $userAccount = UserAccount::findOne($user);
            $data['loginModel']->username = $user;
            $data['UserAccount'] = $userAccount;
            return $this->render('social-twofactor',$data);
        }
            
        return $this->goHome();
        
       
    }

    public function onAuthSuccess(ClientInterface $client)
    {
        $attributes = $client->getUserAttributes();

        $email = $attributes['email'] ?? null;
        $name = $attributes['name'] ?? null;
        $newUserIs = false;
        // Busca o crea un usuario
        $ModelUserAccount = UserAccount::findOne(['Email' => $email]);
        if (!$ModelUserAccount) {
            $newUserIs = true;
            $transaction = \Yii::$app->db->beginTransaction();
            try{
                $ModelAccount = new Account();
                $ModelAccount->IsActive = 1;
                $ModelAccount->AuditDate = new \yii\db\Expression('NOW()');
                $ModelAccount->AuditUser = "System";

                if(!$ModelAccount->save()){
                    Yii::$app->session->setFlash('error', "There was an error creating the user.");
                   
                    $transaction->rollBack();

                    var_dump($ModelAccount->getErrors());
                    exit();
                    return $this->goBack();
                }
                $baseUsName = explode('@',$email)[0];
                $username = $baseUsName;
                $counterUname = 1;

                while(UserAccount::find()->where(['UserName' => $username])->exists()){
                    $username = $baseUsName.$counterUname;
                    $counterUname++;
                }

                $ModelUserAccount = new UserAccount();
                $ModelUserAccount->UserName = $username;
                $ModelUserAccount->Name = $name;
                $ModelUserAccount->Email = $email;
                $ModelUserAccount->TypeUser = 2;
                $ModelUserAccount->AccountID = $ModelAccount->AccountID;
                $ModelUserAccount->ApiToken = md5(Yii::$app->security->generateRandomString(8));
                $ModelUserAccount->UserPassword = md5(Yii::$app->security->generateRandomString(8));
                $ModelUserAccount->rUserPassword = $ModelUserAccount->UserPassword;
                if(!$ModelUserAccount->save()){
                    Yii::$app->session->setFlash('error', "There was an error creating the user.");
                    $transaction->rollBack();
                    return $this->goBack();
                }

                $modelRole = new UserByRole();
                $modelRole->UserName =  $ModelUserAccount->UserName;
                $modelRole->RoleID = 2;
                if(!$modelRole->save()){
                    Yii::$app->session->setFlash('error', "Ocurrio un error al intentar crear el usuario, porfavor intentelo nuevamente.");
                    $transaction->rollBack();
                    return $this->goBack();
                }
                $transaction->commit();

            } catch (Exception $e) {
                Yii::$app->session->setFlash('error', "There was an error creating the user.");
                    $transaction->rollBack();
                    return $this->goBack();
                
            }
        }

        if($ModelUserAccount->TwoFactorActive == 1){
            Yii::$app->session->setFlash('userlogin',$ModelUserAccount->UserName);
            return $this->redirect('social2af');
        }else{
             $usuario =$ModelUserAccount->Email; //correo si es gmail / usuario si se registra desde el formulario
            $nameUser = $ModelUserAccount->Name;
            if($newUserIs){
                \Yii::$app->SystemNotifications->sendPushNotificationGeneric("Nuevo usuario", "({$nameUser}) se ha registrao correo: {$usuario}", ['weclickdigital']);
            }else{
                \Yii::$app->SystemNotifications->sendPushNotificationGeneric("Login", "({$nameUser}) ha iniciado sesión correo: {$usuario}", ['weclickdigital']);
            }
            Yii::$app->user->login($ModelUserAccount, 3600 * 24 * 30); // 30 días
        }
        return $this->goBack();

    }

    private function random_str(int $length = 64,string $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'){
        if ($length < 1) {
            throw new \RangeException("Length must be a positive integer");
        }
        $pieces = [];
        $max = mb_strlen($keyspace, '8bit') - 1;
        for ($i = 0; $i < $length; ++$i) {
            $pieces []= $keyspace[random_int(0, $max)];
        }
        return implode('', $pieces);
    }

    function generarUsuario($email) {
        // Extraer la parte antes del @
        $partes = explode('@', $email);
        $base = substr($partes[0], 0, 4); // Tomar solo las primeras 4 letras
        
        // Definir caracteres permitidos para la parte aleatoria
        $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $longitudCaracteres = strlen($caracteres);
        
        // Generar 6 caracteres aleatorios
        $aleatorio = '';
        for ($i = 0; $i < 6; $i++) {
            $aleatorio .= $caracteres[rand(0, $longitudCaracteres - 1)];
        }
        
        // Combinar las 4 letras iniciales con los 6 caracteres aleatorios
        $resultado = $base . $aleatorio;
        
        // Asegurar que no exceda 10 caracteres (por si acaso)
        return substr($resultado, 0, 10);
    }

    function obtenerVencimientoSSL(string $host, int $port = 443, int $timeout = 15) {
        $this->layout = false;
        $context = stream_context_create([
            'ssl' => [
                'capture_peer_cert' => true,
                'SNI_enabled' => true,
                'peer_name' => $host, // importante para SNI
                'verify_peer' => false, // sólo para obtener el cert; no use false en producción si necesita verificar
                'verify_peer_name' => false,
            ]
        ]);

        $errNo = 0;
        $errStr = '';
        
        // Primero resolvemos la IP del host
        $ip = gethostbyname($host);
        
        $fp = @stream_socket_client(
            "ssl://{$host}:{$port}",
            $errNo,
            $errStr,
            $timeout,
            STREAM_CLIENT_CONNECT,
            $context
        );

        if ($fp === false) {
            return [
                'ok' => false,
                'error' => "No se pudo conectar: $errStr ($errNo)",
                'host' => $host,
                'ip' => $ip // Incluimos la IP incluso en caso de error
            ];
        }

        // Obtenemos la IP real a la que nos conectamos (por si hay redirección)
        $socketName = stream_socket_get_name($fp, true);
        $connectedIp = explode(':', $socketName)[0];
        
        $params = stream_context_get_params($fp);
        if (empty($params['options']['ssl']['peer_certificate'])) {
            fclose($fp);
            return [
                'ok' => false,
                'error' => 'No se encontró certificado en la conexión.',
                'host' => $host,
                'ip' => $connectedIp
            ];
        }

        $cert = $params['options']['ssl']['peer_certificate'];
        $certInfo = openssl_x509_parse($cert, false);
        fclose($fp);

        if ($certInfo === false) {
            return [
                'ok' => false,
                'error' => 'Error al parsear el certificado.',
                'host' => $host,
                'ip' => $connectedIp
            ];
        }

        // validTo_time_t es timestamp unix del fin de validez si está disponible
        $validTo = $certInfo['validTo_time_t'] ?? null;
        if ($validTo === null) {
            // fallback: parsear validTo (string) si no hay time_t
            if (!empty($certInfo['validTo'])) {
                $validTo = strtotime($certInfo['validTo']);
            }
        }

        $now = time();
        $daysLeft = ($validTo !== null) ? ceil(($validTo - $now) / 86400) : null;

        return [
            'ok' => true,
            'host' => $host,
            'ip_resolved' => $ip, // IP resuelta por DNS
            'ip_connected' => $connectedIp, // IP real a la que se conectó
            'port' => $port,
            'valid_to_timestamp' => $validTo,
            'valid_to' => $validTo ? date('Y-m-d', $validTo) : null,
            'days_left' => $daysLeft,
            'cert_info' => $certInfo,
        ];
    }

    public function ReminderDays($date){

        $fechaObjetivo = new DateTime($date);
        $hoy = new DateTime(); // Fecha actual

        $diferencia = $hoy->diff($fechaObjetivo);
        $diasRestantes = $diferencia->days;

        return $diasRestantes;
    }
    
    public function actionReminderSsl(){
        $this->layout = false;
        $query = ReminderSSL::find()->orderBy(['ReminderDays' => SORT_ASC])->all();
        
        $items = [];
        foreach($query as $i){
            $model = ReminderSSL::findOne($i->RSSLID);
            if(!is_null($i->IpHosting)){
                $data = $this->obtenerVencimientoSSL($i->Text);

                if($model->ReminderDays != $data['days_left']){
                    $model->ReminderDays = $data['days_left'];
                    $model->Date = $data['valid_to'];
                    $model->save();
                }
            }else{
                $d = $this->ReminderDays($i->Date);
                if($model->ReminderDays != $d){
                    $model->ReminderDays = $d;
                    $model->save();
                }
            }
            if($i->ReminderDays <= 8){
                $items[] = $i;
            }
        }

        if(count($items) > 0){
            $e = Email::find()->all();

            $mailsW = [];
            $mailsD = [];

            $sw1 = [];
            $sw2 = [];

            $sm = 'SSL: ';
            $dm = 'DM: ';

            foreach ($items as $key => $value) {
                if(!is_null($value->IpHosting)){
                    $sw1[] = '<div style="margin-bottom: 6px;">'.$value->Text.'</div>';
                    $sm .= $value->Text.', ';
                }else{
                    $sw2[] = '<div style="margin-bottom: 6px;">'.$value->Text.'</div>';
                    $dm .= $value->Text.', ';
                }
            }

            foreach($e as $eMail){
                if(count($sw1) > 0){
                    if($eMail->Type == 0)
                        $mailsW[] = $eMail->Mail;
                }
                if(count($sw2) > 0){
                    if($eMail->Type == 1)
                        $mailsD[] = $eMail->Mail;
                }
            }

            if(count($sw1) > 0){
                //$text = "Existen ".count($sw1)." certificados SSL con menos de 8 días por vencer";
                Yii::$app->Emails->sendReminderSsl($mailsW, count($sw1), $sw1, 'certificados SSL');
                \Yii::$app->SystemNotifications->sendPushNotificationGeneric("Certificados SSL", rtrim($sm, ", "), ['weclickdigital']);
            }
            if(count($sw2) > 0){
                //$text = "Existen ".count($sw2)." dominios con menos de 8 días por vencer";
                Yii::$app->Emails->sendReminderSsl($mailsD, count($sw2), $sw2, 'dominios');
                \Yii::$app->SystemNotifications->sendPushNotificationGeneric("Dominios", rtrim($dm, ", "), ['weclickdigital']);
            }
            
        }
        
    }

}
