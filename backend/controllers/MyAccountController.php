<?php 
	namespace backend\controllers;

	use Yii;
	use yii\helpers\Url;
	use yii\db\Expression;

	use yii\web\Controller;
    use common\components\ValidUsers;
    use common\models\PostBlog;
	use common\models\Porfolio;
	use common\models\BillingInfo;
	use common\models\ActivitySession;

    use common\models\Account;
	use common\models\Directory;
	use common\models\UserAccount;
    use common\models\Country;
    use common\models\Countries;
    use common\models\ValidarUser;
    use common\models\Role;
	use common\models\UserByRole;
	use common\models\TypeUsers;
    use yii\web\UploadedFile;
    //use common\models\ImgCompany;

    use yii\data\ActiveDataProvider;



	class MyAccountController extends Controller
	{
		private $_ValidUser;
		public $_MenuController = "";
		public $_PagePath = "";

		public function actionIndex()
		{	
            
			$UserData =  Yii::$app->AccessControl->Verify();
            $BillingInfo = $UserData->billingInfo? : new BillingInfo(['AccountID'=>$UserData->AccountID]);
			$this->layout = $UserData->getLayout();
			$data = [];
			
            $oldPassword = $UserData->UserPassword;
            if (Yii::$app->request->isAjax && $UserData->load(Yii::$app->request->post())) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return \yii\widgets\ActiveForm::validate($UserData);
              }

            if(isset(Yii::$app->request->post()['NotifyMarkAllRead'])){

                \Yii::$app->SystemNotifications->markAllAsRead($UserData->AccountID);

                return $this->refresh();

            }
            if(isset(Yii::$app->request->post()['NotifyAllReadDelete'])){
                \Yii::$app->SystemNotifications->deleteReadNotifications($UserData->AccountID);
                return $this->refresh();

            }

            if(isset(Yii::$app->request->post()['NotifyIdDelete'])){
                \Yii::$app->SystemNotifications->deleteNotifications($UserData->AccountID,Yii::$app->request->post()['NotifyIdDelete']);
                return $this->refresh();

            }


            if($BillingInfo->load(Yii::$app->request->post())){
                if(!$BillingInfo->save()){
                    var_dump($BillingInfo->getErrors()); exit;
                    Yii::$app->session->setFlash('error','Ha ocurrido un error y no se pudo actualizar la información');
                }

                return $this->refresh();
            }
            if($UserData->load(Yii::$app->request->post())){
                $UserData->ImgCompany = UploadedFile::getInstance($UserData, 'ImgCompany');
                if($UserData->ImgCompany != null)
                    $UserData->imgCompany();
                

                if($oldPassword != $UserData->UserPassword){
                    $UserData->UserPassword = md5($UserData->UserPassword);
                    $UserData->rUserPassword = md5($UserData->rUserPassword);
                }else{
                    $UserData->UserPassword = $UserData->UserPassword;
                    $UserData->rUserPassword = $UserData->UserPassword;
                }

                $infoUs = Yii::$app->LocationLang->info();
                $lang = $infoUs->language->LanguageCode;
                $nameC = $lang == 'es' ? 'Name' : 'Name_en';

                
                if(is_null($UserData->CountryID)){
                    $country = $infoUs->country_name; 
                }else{
                    $nCountry = Countries::findOne($UserData->CountryID);
                    $country = $nCountry->$nameC;
                }
                $c = Yii::$app->CountryCode->codecountry($country); 
                
                $UserData->NumberPhone = strlen($c.$UserData->NumberPhone) <= 4 ? NULL : $c.$UserData->NumberPhone;
                

                if(!$UserData->save()){
                    // var_dump($UserData->getErrors()); exit;
                    Yii::$app->session->setFlash('error','Ha ocurrido un error y no se pudo actualizar la información');
                }

                return $this->refresh();

            }

            $data['UserData'] = $UserData;
            $data['BillingInfo'] = $BillingInfo;

            $gTAF = new \Sonata\GoogleAuthenticator\GoogleAuthenticator();
            if(isset(Yii::$app->request->post()['TwoAuthFactor'])){
                    
                $TwoFactor = Yii::$app->request->post()['TwoAuthFactor'];
                // var_dump($TwoFactor); exit();
                if(isset($TwoFactor['code']) && isset($TwoFactor['secrect']) && isset($TwoFactor['password'])){
                    if(md5($TwoFactor['password']) != $oldPassword){
                        Yii::$app->session->setFlash('error','Haz ingresado una contraseña que no coincide');
                        return $this->refresh();
                    }
                    if ($gTAF->checkCode($TwoFactor['secrect'], $TwoFactor['code'],2)) {
                        $UserData->TwoFactorActive = 1;
                        $UserData->TwoFactorSecrect = $TwoFactor['secrect'];
                        if($oldPassword != $UserData->UserPassword){
                            $UserData->UserPassword = md5($UserData->UserPassword);
                            $UserData->rUserPassword = md5($UserData->rUserPassword);
                        }else{
                            $UserData->UserPassword = $UserData->UserPassword;
                            $UserData->rUserPassword = $UserData->UserPassword;
                        }
                        if($UserData->save()){
                            Yii::$app->session->setFlash('success','2AF activado de forma exitosa.');
                            return $this->refresh();
                        }else{
                            Yii::$app->session->setFlash('error','No se ha podido guardar la configuracion del 2AF intente nuevamente.');
                            return $this->refresh();
                        }
                    } else {
                        
                            Yii::$app->session->setFlash('error','El codigo de authentificacón es incorrecto.');
                            return $this->refresh();
                    }
                }elseif(isset($TwoFactor['desactive']) && isset($TwoFactor['code']) && isset($TwoFactor['password'])){
                    if(md5($TwoFactor['password']) != $oldPassword){
                        Yii::$app->session->setFlash('error','Haz ingresado una contraseña que no coincide');
                        return $this->refresh();
                    }
                    if ($gTAF->checkCode($UserData->TwoFactorSecrect, $TwoFactor['code'], 2)) {
                        $UserData->TwoFactorActive = 0;
                        $UserData->TwoFactorSecrect = new Expression('NULL');
                        if($oldPassword != $UserData->UserPassword){
                            $UserData->UserPassword = md5($UserData->UserPassword);
                            $UserData->rUserPassword = md5($UserData->rUserPassword);
                        }else{
                            $UserData->UserPassword = $UserData->UserPassword;
                            $UserData->rUserPassword = $UserData->UserPassword;
                        }
                        if($UserData->save()){
                            Yii::$app->session->setFlash('success','2AF Desactivado de forma exitosa.');
                            return $this->refresh();
                        }else{
                            Yii::$app->session->setFlash('error','No se ha podido guardar la configuracion del 2AF intente nuevamente.');
                            return $this->refresh();
                        }
                    }else {
                       
                            Yii::$app->session->setFlash('error','El codigo de authentificacón es incorrecto.');
                            return $this->refresh();
                    }
                }else{
                    Yii::$app->session->setFlash('error','Se ha recibido una solicitud incorrecta.');
                    return $this->refresh();
                }
            }
            if($UserData->TwoFactorActive == 0){
                if(empty($UserData->TwoFactorSecrect)){
                    $secrectTwoFactor = $gTAF->generateSecret();
                    $UserData->TwoFactorSecrect =  $secrectTwoFactor;
                    if($oldPassword != $UserData->UserPassword){
                        $UserData->UserPassword = md5($UserData->UserPassword);
                        $UserData->rUserPassword = md5($UserData->rUserPassword);
                    }else{
                        $UserData->UserPassword = $UserData->UserPassword;
                        $UserData->rUserPassword = $UserData->UserPassword;
                    }
                    $UserData->save();
                    return $this->refresh();
                }

                $QR =  \Sonata\GoogleAuthenticator\GoogleQrUrl::generate($UserData->UserName, $UserData->TwoFactorSecrect, yii::$app->params['ProyectName']);

                $data['QR'] = $QR;
                $data['secrectTwoFactor'] = $UserData->TwoFactorSecrect;
            }

            //$data['$UserData'] = $UserData =  Yii::$app->AccessControl->Verify();

            if($UserData->TypeUser == 2){
                $pUserAccount = UserAccount::findBySql("SELECT u.* FROM UserAccount u INNER JOIN Account a ON u.AccountID = a.AccountID WHERE a.ParentAccount = {$UserData->AccountID};");
            }else{
                $pUserAccount = UserAccount::find();
            }

            $data['AgencysDat']  = new ActiveDataProvider([
				    'query' => $pUserAccount,
				    'pagination' => [
				        'pageSize' => 20,
				    ],
				]);   


            // // $data['Countrys'] = $Country;
            // $data['Agencys'] = $pAgency;
            // $data['UserAccounts'] = $pUserAccount;
            $data['model'] = new ValidarUser();

            $sumaryHtml = $this->renderPartial('tabs-my-account/summary',$data);
            $securityHtml = $this->renderPartial('tabs-my-account/security',$data);
            $usersHtml = $this->renderPartial('tabs-my-account/users',$data);
            $notifyHtml = $this->renderPartial('tabs-my-account/notify',$data);
            $activityHtml = $this->renderPartial('tabs-my-account/activity',$data);

            $data['modals'] = $this->renderPartial('modals',$data);


            $data['summaryHtml'] = $sumaryHtml;
            $data['securityHtml'] = $securityHtml;
            $data['usersHtml'] = $usersHtml;
            $data['notifyHtml'] = $notifyHtml;
            $data['activityHtml'] = $activityHtml;

            


			return $this->render('index',$data);
		}

        public function actionCloseSession($id){   

            $UserData =  Yii::$app->AccessControl->Verify([]);

            $IdSession = Yii::$app->session->getId();

            $toclose = ActivitySession::findOne($id);

            session_commit();

            if($toclose && $toclose->AccountID == $UserData->AccountID){

                $idSessionToClose = $toclose->SessionID;

                session_id($idSessionToClose);
                session_start();
                session_destroy();
                session_commit();

                session_id($IdSession);
                session_start();
                $toclose->Status = 0;
                $toclose->save();
            }else{
                Yii::$app->session->setFlash('error','No se recibieron datos correctos intente nuevamente.');
            }

            return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
        }

        public function actionReadNotify($id){
            $UserData =  Yii::$app->AccessControl->Verify([]);
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            $Notification = \Yii::$app->SystemNotifications->getNotification($id);

            if(!$Notification){
                return false;
            }
            \Yii::$app->SystemNotifications->markAsRead($id, $UserData->AccountID);

            return $Notification;

        }
   }
