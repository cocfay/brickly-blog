<?php 
	namespace backend\controllers;

	use Yii;
	use yii\helpers\Url;
	use yii\db\Expression;

	use yii\web\Controller;
    use common\components\ValidUsers;
    use common\models\PostBlog;
	use common\models\Porfolio;
	use common\models\FormSeller;
	use common\models\Promotions;
	use common\models\Services;
	use common\models\ServicesByAccount;
	use common\models\ProjectsClients;
	use common\models\RequestServiceClient;
	use yii\helpers\ArrayHelper;
	use common\models\CompleteInfo;
	use common\models\Account;
	use common\models\Countries;



	class HomeController extends Controller
	{
		private $_ValidUser;
		public $_MenuController = "";
		public $_PagePath = "";

		public function actionIndex()
		{	

			$data['UserData'] = $UserData =  Yii::$app->AccessControl->Verify();
			
			$this->layout = $UserData->getLayout();
			// $this->layout = "/main";
			$data = [];

			if($UserData->TypeUser == 6)
			$this->redirect(['tool/pay-serv-provider?id=1']);

			switch($UserData->typeUsers->UserHome){

				case 'homeclient':

					$infoUs = Yii::$app->LocationLang->info();
					$data['lang'] = $lang = $infoUs->language->LanguageCode;

					$data['completeI'] = CompleteInfo::findOne($UserData->UserName);

					$nameC = $lang == 'es' ? 'Name' : 'Name_en';
					$contryList = Countries::find()->select(['*', $nameC.' AS Name'])->orderBy([$nameC => SORT_ASC])->all();
					$cc = Countries::find()->select(['CountryID'])->where(['Abbreviation' => $infoUs->country_code])->one();
					$data['contryList'] = ArrayHelper::map($contryList, 'CountryID', 'Name');
					$data['countryCode'] = $cc->CountryID;

					if($data['completeI']->load(Yii::$app->request->post())){
						if($data['completeI']->validate()){
							if(empty($data['completeI']->NumberPhone)){
								$nCountry = Countries::findOne($data['completeI']->CountryID);
								$c = Yii::$app->CountryCode->codecountry($nCountry->$nameC); 
								$data['completeI']->NumberPhone = $c.$data['completeI']->NumberPhone;
							}
							if($data['completeI']->save()){
								Yii::$app->session->setFlash('success', "Información actualizada correctamente.");
								return $this->refresh();
							}
						}
					}

					/* $c = Yii::$app->CountryCode->codecountry(); 
					var_dump($c);
					exit; */

					$data['RequestServiceModel'] = new RequestServiceClient();

					if($data['RequestServiceModel']->load(Yii::$app->request->post())){

						$data['RequestServiceModel']->AccountID = $UserData->AccountID;

						//var_dump($data['RequestServiceModel']); exit;
						if($data['RequestServiceModel']->save()){
							Yii::$app->session->setFlash('success', "Pronto un asesor estará en contacto contigo.");
							$contact = "";
							if(!is_null($UserData->NumberPhone) && !is_null($UserData->CountryID))
								$contact = " Número: ".$UserData->NumberPhone." País: ".$UserData->country->$nameC;
								\Yii::$app->SystemNotifications->sendPushNotificationGeneric("Servicio", "{$UserData->UserName} rellenó el formulario del servicio {$data['RequestServiceModel']->service->Name} {$contact}", ['weclickdigital']);
								return $this->refresh();
						}else{
							/* echo '<pre>';
								print_r($data['RequestServiceModel']->getErrors());
							echo '</pre>';
							exit; */
							/* Yii::$app->session->setFlash('error', "no se ha podido realizar la solicitud, intente nuevamente");
							return $this->refresh(); */
						}
					}

					$data['Notification'] = Yii::$app->SystemNotifications->getNotificationsForAccount($UserData->AccountID);

					$data['BlogPosts'] = PostBlog::find()
					->where(['Verified' => 1])
					->andWhere(['!=', 'Home', 0])
					->orderBy(['Home' => SORT_ASC])
					->orderBy(new Expression('rand()'))
					->limit(2)->all();

					$recti = ($infoUs->country_code == 'ES' || $infoUs->country_code == 'PA') ? ['!=', 'Restriction', 1] : [];
					$rGT = ($infoUs->country_code == 'GT') ? ['!=', 'NGuatemala', 1] : [];
					$data['ItemsPorfolio'] = Porfolio::find()
					->andWhere($recti)
					->andWhere($rGT)
					->andWhere(['Visibility' => 0])
					->orderBy(new Expression('rand()'))
					->limit(6)
					->all();

					$data['promo'] = Promotions::find()->where(['Visible' => 1])->one();
					$data['services'] = Services::find()->orderBy(['Position' => SORT_ASC])->all();
					
					
					function getRelatedAccountIds($currentAccountId){
						// Buscar si el usuario actual es un subusuario
						$currentAccount = Account::findOne($currentAccountId);
						
						if ($currentAccount->ParentAccount) {
							// Es subusuario - retornar [todos los subusuarios del mismo padre + el padre]
							$siblings = Account::find()
								->select(['AccountID'])
								->where(['ParentAccount' => $currentAccount->ParentAccount])
								->column();
							
							return array_merge([$currentAccount->ParentAccount], $siblings);
						} else {
							// Es usuario padre - retornar [padre] + todos los subusuarios
							$subUsers = Account::find()
								->select(['AccountID'])
								->where(['ParentAccount' => $currentAccountId])
								->column();
							
							return array_merge([$currentAccountId], $subUsers);
						}
					}

					// En tu acción:
					$relatedAccountIds = getRelatedAccountIds($UserData->AccountID);

					//var_dump($relatedAccountIds); exit;

					$data['showMyServices'] = ProjectsClients::find()
						->select(['ServiceID', 'Type', 'COUNT(ProjectClientID) as Cantidad'])
						->where(['AccountID' => $relatedAccountIds])
						->orderBy(['ServiceID' => SORT_ASC])
						->groupBy(['ServiceID', 'Type'])
						->asArray()
						->all();
					
				break;
				

				case 'home':
					
					$data['services'] = Services::find()->all();
		
				break; 
			}

		   // var_dump('Script terminado'); exit();
			$data['UserData'] = $UserData;


			if($UserData->TypeUser == 3){
				$seller = FormSeller::find()->where(['AccountID' => $UserData->AccountID])->one();
				if(is_null($seller))
					return $this->redirect('seller');
			}
			

			return $this->render($UserData->typeUsers->UserHome,$data);
		}
		public function actionTest(){

			// $infoUs = Yii::$app->LocationLang->info();
			// echo $infoUs->browser->browser_name."<br>";
			// echo $infoUs->Os->os_name."<br>";
			// echo $infoUs->device->device_type."<br>";
			// var_dump($infoUs);
			$pathValid = Yii::$app->basePath;
			$webValid = \Yii::getAlias('@web');


			$pathBase = explode('/',$pathValid);
			$webBase = explode('/',$webValid);

			$raizFolder =  $pathBase[(count($pathBase) - 2)] ?? null;

			$raizFolderWeb =  $webBase[(count($webBase) - 2)] ?? null;

			if($raizFolder && $raizFolderWeb && $raizFolder == $raizFolderWeb){
				echo "son iguales <br>";
			}

			echo "<br><br>";


			echo "@runtime => " . \Yii::getAlias('@runtime');
			echo "<br><br>";
			echo "@web => " . Url::to('@web');
			echo "<br><br>";
			echo "Alias @web => " . \Yii::getAlias('@web');
			echo "<br><br>";
			echo "@webroot => " . \Yii::getAlias('@webroot');
			echo "<br><br>";
			echo "basepath => " . Yii::$app->basePath;
			echo "<br><br>";
			echo "@raizweb => " . Url::to('@raizweb');
			echo "<br><br>";
			echo "@proyectroot => " . \Yii::getAlias('@proyectroot');
			// echo "<br><br>";

			exit;
		}

		public function actionMailgun(){
		    $data = [];
		    $this->layout = false;
		    //$data['InternalView'] = $this->render('login',$data);
		    $MG = Yii::$app->mg;
		    $rt = $MG->send(['to'=>'jcfarias.fc@gmail.com', 'subject'=>'Mailgun WC', 'html'=>'Send Email test MG']);

			echo "Enviado test: ".$rt;
			exit();
		    //return $this->render('tablet',$data);
		}

		public function actionChat($id=false){
			$data = [];
			$data['token'] = $id;
			if(!Yii::$app->user->isGuest) {
				$data['UserData'] = $UserData =  Yii::$app->AccessControl->Verify();
				$this->layout = $UserData->getLayout();
			}else{
				$this->layout =  "@webroot/common/modules/JcChat/views/layouts/simpleCpanel";
			}
			
			return $this->render('chat',$data);
		}

   }
