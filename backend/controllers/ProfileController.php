<?php 
	namespace backend\controllers;

	use Yii;
	use yii\web\Controller;
    use common\components\ValidUsers;

    use yii\helpers\ArrayHelper;
    use yii\web\NotFoundHttpException;
	use yii\web\Response;
	use yii\web\UploadedFile;


    use common\models\Account;
	use common\models\UserAccount;
	use common\models\Directory;
	use common\models\Country;
	use common\models\CountryByDirectory;

   // use common\models\Country;


	class ProfileController extends Controller
	{
		private $_ValidUser;

		public function actionProfile()
		{	

			$UserData =  Yii::$app->AccessControl->Verify();
			
			// $this->layout = $UserData->getLayout();
			$this->layout = "/template2";
			$data = [];
			$data['UserData'] = $UserData;

				return $this->render('profile',$data);
		}

		public function actionIndex()
		{	
			$UserData =  Yii::$app->AccessControl->Verify();
			// 1 = Users Admin
			// 2 = Users moderador
			$data = [];
			$this->layout = $UserData->getLayout();
			// $this->layout = "/main";


			$data['ModelAccount'] = $ModelAccount = Account::findOne($UserData->AccountID);

			$data['ModelAgency'] = (empty($ModelAccount->directory))? false : $ModelAccount->directory;

			if($data['ModelAgency']){
				$data['ModelAgency']->CountryExport = isset($data['ModelAgency']->countrybydirectory)? ArrayHelper::map($data['ModelAgency']->countrybydirectory, 'CountryID', 'CountryID') : [];

				//var_dump($data['ModelAgency']->Certifications);exit();

				//$data['ModelUserAccount'] = $ModelAccount->userAccount;
				$data['Countries'] = ArrayHelper::map(Country::find()->all(), 'CountryID', 'Name');


				$CompleteProfile = 0;
				if(!empty($data['ModelAgency']->Address)){
					$CompleteProfile += 5;
				}
				if(!empty($data['ModelAgency']->NumberPhone)){
					$CompleteProfile += 10;
				}
				if(!empty($data['ModelAgency']->Description)){
					$CompleteProfile += 5;
				}
				if(!empty($data['ModelAgency']->DescriptionEng)){
					$CompleteProfile += 5;
				}
				if(!empty($data['ModelAgency']->WebSite)){
					$CompleteProfile += 10;
				}
				if(!empty($data['ModelAgency']->Facebook)){
					$CompleteProfile += 10;
				}
				if(!empty($data['ModelAgency']->Video)){
					$CompleteProfile += 5;
				}
				if(!empty($data['ModelAgency']->Latitud) && $data['ModelAgency']->Latitud != 'undefined' && $data['ModelAgency']->Latitud != 0 && $data['ModelAgency']->Latitud != 0){
					$CompleteProfile += 5;
				}
				if(!empty($data['ModelAgency']->Longitud) && $data['ModelAgency']->Longitud != 'undefined' && $data['ModelAgency']->Longitud != 0 && $data['ModelAgency']->Longitud != 0){
					$CompleteProfile += 5;
				}
				if(!empty($data['ModelAgency']->Email)){
					$CompleteProfile += 10;
				}
				if(!empty($data['ModelAgency']->PathImage)){
					$CompleteProfile += 10;
				}
				if(!empty($data['ModelAgency']->Keywords)){
					$CompleteProfile += 3;
				}

				//if(!empty($data['ModelAgency']->Prov&Serv)){
				//	$CompleteProfile += 5;
				//}
				if(count($data['ModelAgency']->CountryExport) > 0){
					$CompleteProfile += 5;
				}

				//$data['items'] = $items = ArrayHelper::map(Country::find()->all(), 'CountryID', 'Name');


				$data['CompleteProfile'] = $CompleteProfile +5;
			}

			$data['ModelUserAccount'] = $ModelAccount->userAccount;

			//$data['items'] = $items = ArrayHelper::map(Country::find()->all(), 'CountryID', 'Name');


			
			return $this->render('index',$data);	
		}
		public function actionProfile1($id)
		{	
			$UserData =  Yii::$app->AccessControl->Verify();
			// 1 = Users Admin
			// 2 = Users moderador
			$data = [];
			$this->layout = $UserData->getLayout();
			// $this->layout = "/main";

			if((isset($UserData->cccount->directory->DirectoryID) && $UserData->cccount->directory->DirectoryID == $id) || $UserData->TypeUser == 1){

			}else{
				$this->redirect(['/profile/profile','id'=>$UserData->cccount->directory->DirectoryID]);
			}


			//$data['ModelAccount'] = $ModelAccount = Account::findOne($UserData->AccountID);

			//$data['ModelAgency'] = (empty($ModelAccount->directory))? new Directory() : $ModelAccount->directory;
			$data['ModelAgency'] = Directory::findOne($id);

			$data['ModelAgency']->CountryExport = isset($data['ModelAgency']->countryByDirectory)? ArrayHelper::map($data['ModelAgency']->countryByDirectory, 'CountryID', 'CountryID') : [];

			//var_dump($data['ModelAgency']->Certifications);exit();

			//$data['ModelUserAccount'] = $ModelAccount->userAccount;
			$data['Countries'] = ArrayHelper::map(Country::find()->all(), 'CountryID', 'Name');


			$CompleteProfile = 0;
			if(!empty($data['ModelAgency']->Address)){
				$CompleteProfile += 5;
			}
			if(!empty($data['ModelAgency']->NumberPhone)){
				$CompleteProfile += 10;
			}
			if(!empty($data['ModelAgency']->Description)){
				$CompleteProfile += 5;
			}
			if(!empty($data['ModelAgency']->DescriptionEng)){
				$CompleteProfile += 5;
			}
			if(!empty($data['ModelAgency']->WebSite)){
				$CompleteProfile += 10;
			}
			if(!empty($data['ModelAgency']->Facebook)){
				$CompleteProfile += 10;
			}
			if(!empty($data['ModelAgency']->Video)){
				$CompleteProfile += 5;
			}
			if(!empty($data['ModelAgency']->Latitud) && $data['ModelAgency']->Latitud != 'undefined' && $data['ModelAgency']->Latitud != 0 && $data['ModelAgency']->Latitud != 0){
				$CompleteProfile += 5;
			}
			if(!empty($data['ModelAgency']->Longitud) && $data['ModelAgency']->Longitud != 'undefined' && $data['ModelAgency']->Longitud != 0 && $data['ModelAgency']->Longitud != 0){
				$CompleteProfile += 5;
			}
			if(!empty($data['ModelAgency']->Email)){
				$CompleteProfile += 10;
			}
			if(!empty($data['ModelAgency']->PathImage)){
				$CompleteProfile += 10;
			}
			if(!empty($data['ModelAgency']->Keywords)){
				$CompleteProfile += 3;
			}

			//if(!empty($data['ModelAgency']->Prov&Serv)){
			//	$CompleteProfile += 5;
			//}
			if(count($data['ModelAgency']->CountryExport) > 0){
				$CompleteProfile += 5;
			}

			//$data['items'] = $items = ArrayHelper::map(Country::find()->all(), 'CountryID', 'Name');


			$data['CompleteProfile'] = $CompleteProfile +5;






			//////////////////////POST///////////

			if(Yii::$app->request->post() && $data['ModelAgency']->load(Yii::$app->request->post())){
				$transaction = \Yii::$app->db->beginTransaction();
				try {

					$data['ModelAgency']->LogoPicture  = UploadedFile::getInstance($data['ModelAgency'], 'LogoPicture');
					if($data['ModelAgency']->LogoPicture != null)
						$upload = $data['ModelAgency']->upload();

					//var_dump(Yii::$app->request->post()['Directory']['Prov']); exit();
					$data['ModelAgency']->Export = isset(Yii::$app->request->post()['Directory']['Export'])? Yii::$app->request->post()['Directory']['Export'] : 0;
					$data['ModelAgency']->Prov = isset(Yii::$app->request->post()['Directory']['Prov'])? Yii::$app->request->post()['Directory']['Prov'] : 0;

					if($data['ModelAgency']->Export == 1){
						$data['ModelAgency']->TypeExport = isset(Yii::$app->request->post()['Directory']['TypeExport'])? Yii::$app->request->post()['Directory']['TypeExport'] : 0;
					}else{
						$data['ModelAgency']->TypeExport = 0;
					}

					if($data['ModelAgency']->save()){

						if(count($data['ModelAgency']->CountryExport) > 0){

							CountryByDirectory::deleteAll(['DirectoryID'=>$data['ModelAgency']->DirectoryID]);
						}

						//var_dump($data['ModelAgency']->CountryExport); exit();

						foreach ($data['ModelAgency']->CountryExport as $k => $v) {
							$CbD = new CountryByDirectory(['CountryID' => $v, 'DirectoryID' => $data['ModelAgency']->DirectoryID]);
							if(!$CbD->save()){
								Yii::$app->session->setFlash('error', "Los datos no se actualizaron, verifique eh intente nuevamente.");
								$transaction->rollBack();
								return $this->redirect(['/profile/profile','id'=>$id]);
							}
						}


						Yii::$app->session->setFlash('success', "Datos actualizados correctamente.");
						$transaction->commit();
						return $this->redirect(['/profile/profile','id'=>$id]);


					}else{

						var_dump($data['ModelAgency']->getErrors());
						exit();
					Yii::$app->session->setFlash('error',);
					$transaction->rollBack();
					return $this->redirect(['/profile/profile','id'=>$id]);

					}



					
				} catch (Exception $e) {

					Yii::$app->session->setFlash('error', "There was an error creating the menu.");
					$transaction->rollBack();
					return $this->redirect(['/profile/profile','id'=>$id]);
				}

			}
			//////////////////////////////////			
			return $this->render('html',$data);	
		}

		public function actionUpdate()
		{
			$dataGlobal =  Yii::$app->AccessControl->Verify();
			// 1 = Users Admin
			// 2 = Users moderador
			
			$ModelAccount = Account::findOne($dataGlobal->AccountID);

			$ModelAgency = (empty($ModelAccount->directory))? false : $ModelAccount->directory;

			$ModelUserAccount = UserAccount::findOne(["AccountID" => $dataGlobal->AccountID]);

			$ModelUserAccountRecived =  $ModelAccount->userAccount;

			if($ModelUserAccountRecived->load(Yii::$app->request->post())){

				$transaction = \Yii::$app->db->beginTransaction();
				$valid = $ModelUserAccountRecived->validate();
				$MessageErros = "";
				if($ModelAgency){
						$ModelAgency->load(Yii::$app->request->post());
						$ModelAgency->LogoPicture  = UploadedFile::getInstance($ModelAgency, 'LogoPicture');
						if($ModelAgency->LogoPicture != null)
							$upload = $ModelAgency->upload();

						//var_dump(Yii::$app->request->post()['Directory']['Prov']); exit();
						$ModelAgency->Export = isset(Yii::$app->request->post()['Directory']['Export'])? Yii::$app->request->post()['Directory']['Export'] : 0;
						$ModelAgency->Prov = isset(Yii::$app->request->post()['Directory']['Prov'])? Yii::$app->request->post()['Directory']['Prov'] : 0;

						if($ModelAgency->Export == 1){
							$ModelAgency->TypeExport = isset(Yii::$app->request->post()['Directory']['TypeExport'])? Yii::$app->request->post()['Directory']['TypeExport'] : 0;
						}else{
							$ModelAgency->TypeExport = 0;
						}
				}
				if($valid){
					$upload = true;
					$agencyCommit = true; 
					try {
						if($ModelUserAccountRecived->UserPassword != $ModelUserAccount->UserPassword && !empty($ModelUserAccountRecived->UserPassword))
							$ModelUserAccountRecived->UserPassword = md5($ModelUserAccountRecived->UserPassword);
						

						
							$ModelUserAccountRecived->PhotoProfile  = UploadedFile::getInstance($ModelUserAccountRecived, 'PhotoProfile');
							if($ModelUserAccountRecived->PhotoProfile != null)
								$upload = $ModelUserAccountRecived->upload();

						
						if($upload){
						 	$commit = $ModelUserAccountRecived->save();
						 }else{ $commit = false; }

							if($ModelAgency)
								 $agencyCommit = $ModelAgency->save();

							if($commit && $agencyCommit){


								if(count($ModelAgency->CountryExport) > 0){

									CountryByDirectory::deleteAll(['DirectoryID'=>$ModelAgency->DirectoryID]);
								}

								//var_dump($ModelAgency->CountryExport); exit();

								foreach ($ModelAgency->CountryExport as $k => $v) {
									$CbD = new CountryByDirectory(['CountryID' => $v, 'DirectoryID' => $ModelAgency->DirectoryID]);
									if(!$CbD->save()){
										Yii::$app->session->setFlash('error', "Los datos no se actualizaron, verifique eh intente nuevamente.");
										$transaction->rollBack();
										return $this->redirect(['/profile']);
									}
								}



								$transaction->commit();

		                        Yii::$app->session->setFlash('success', "Actualización de perfil correctamente ");
		                         return $this->redirect(['/profile']);
							}else{
								Yii::$app->session->setFlash('error', "Se ha producido un error al actualizar tu perfil.");
					            $transaction->rollBack();
					            return $this->redirect(['/profile']);
							}
						
					} catch (Exception $e) {
						Yii::$app->session->setFlash('error', "Se ha producido un error al actualizar tu perfil. <br> Mensaje:<br>".$e);
					            $transaction->rollBack();
					            return $this->redirect(['/profile']);
					}
				}else{
					// $MessageErros .= "<br>". var_dump($ModelUserAccountRecived->errors);
					Yii::$app->session->setFlash('error', "Hay una verificación de datos incorrecta, por favor intente de nuevo <br>Mensaje:<br>");
					 $transaction->rollBack();
					return $this->redirect(['/profile']);
				}
				
			}else{
				return $this->redirect(['/profile']);
			}
		}
       
	}