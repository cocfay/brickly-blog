<?php 
	namespace backend\controllers;
	use Yii;
	use yii\web\Controller;
	use yii\filters\VerbFilter;
	use yii\filters\AccessControl;

	use common\models\Account;
	use common\models\Directory;
	use common\models\UserAccount;
    use common\models\Country;
    use common\models\ValidarUser;
    use common\models\Role;
	use common\models\UserByRole;
	use common\models\TypeUsers;

	use common\components\ValidUsers;
	use yii\helpers\ArrayHelper;

	use yii\data\ActiveDataProvider;
	use yii\db\Expression;
	

	class UsuarioController extends Controller
	{
		private $_valiUser;
        
        //funcion que llama la vista principal de usuarios
        public function actionIndex()
        {
        	$UserData =  Yii::$app->AccessControl->Verify([1]);
			// 1 = Users Admin
			// 2 = Users moderador
			// Verificar en tabla TypeUsers
			$data = [];
			$this->layout = $UserData->getLayout();

            // $pAgency = Directory::find();//trae todo de agency de la bd
            $pUserAccount = UserAccount::find();//trae Useraccount de l bd	
            // $Country = Country::find()->asArray()->all();

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
			$data['redirect'] = '';

			// Contar admins para controlar botón de eliminar
			$data['totalAdmins'] = UserAccount::find()->where(['TypeUser' => 1])->count();

            return $this->render('index', $data);
        }

		public function actionMy($id=false)
        {
			if($id){
        		$UserData =  Yii::$app->AccessControl->Verify([1]);
			}else{
        		$UserData =  Yii::$app->AccessControl->Verify([2]);
				$id = $UserData->AccountID;
			}
			// 1 = Users Admin
			// 2 = Users moderador
			// Verificar en tabla TypeUsers
			$data = [];
			$this->layout = $UserData->getLayout();

            
            $pUserAccount = UserAccount::findBySql("SELECT u.* FROM UserAccount u INNER JOIN Account a ON u.AccountID = a.AccountID WHERE a.ParentAccount = {$id};");

            $data['AgencysDat']  = new ActiveDataProvider([
				    'query' => $pUserAccount,
				    'pagination' => [
				        'pageSize' => 20,
				    ],
				]);   

            $data['model'] = new ValidarUser();
			$data['redirect'] = '/my-account#nav-users';
			// Contar admins para controlar botón de eliminar
			$data['totalAdmins'] = UserAccount::find()->where(['TypeUser' => 1])->count();
            return $this->render('index', $data);
        }

        public function actionDelete($id, $url = ""){
			//$UserData =  Yii::$app->AccessControl->Verify([1]);
			// 1 = Users Admin
			// 2 = Users moderador
			// Verificar en tabla TypeUsers
			$data = [];
			$url = !empty($url) ? $url : '/usuario';
			$this->layout = false;

			// Verificar si el usuario a eliminar es administrador
			$ModelUserAccount = UserAccount::findOne(['AccountID' => $id]);
			if ($ModelUserAccount && $ModelUserAccount->TypeUser == 1) {
				$totalAdmins = UserAccount::find()->where(['TypeUser' => 1])->count();
				if ($totalAdmins <= 1) {
					Yii::$app->session->setFlash('error', "No se puede eliminar el único usuario administrador.");
					$this->redirect([$url]);
					return;
				}
			}

			$ModelAccount = Account::findOne($id);
			$transaction = \Yii::$app->db->beginTransaction();
			try {
				if($ModelAccount->delete()){
					$transaction->commit();
					Yii::$app->session->setFlash('success', "Usuario eliminado correctamente.");

					$this->redirect([$url]);
				}else{
					Yii::$app->session->setFlash('error', "There was an error creating the menu.");
					$transaction->rollBack();
					$this->redirect(['/menu']);

				}
			} catch (Exception $e) {

				Yii::$app->session->setFlash('error', "There was an error creating the menu.");
				$transaction->rollBack();
				$this->redirect([$url]);
			}
			
			
		}

////Controlador para Crear usuarios
        public function actionCreateuser()
        {
			$UserData = Yii::$app->AccessControl->Verify([1,2]);

			$data['ModelUserAccount'] = $ModelUserAccount = new UserAccount;
			if (Yii::$app->request->isAjax && $ModelUserAccount->load(Yii::$app->request->post())) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return \yii\widgets\ActiveForm::validate($ModelUserAccount);
              }
			// 1 = Users Admin
			// 2 = Users moderador
			// Verificar en tabla TypeUsers
			$data = [];
			$data['UserData'] = $UserData;
			$this->layout = $UserData->getLayout();
			
			$data['ModelAccount'] = $ModelAccount = new Account;
			$data['ModelUserAccount'] = $ModelUserAccount = new UserAccount;
			// $data['ModelAgency'] = $ModelAgency = new Directory;
			$data['ModelByRole'] = $ModelByRole = new UserByRole;

			if($UserData->TypeUser == 2){
				$ModelAccount->ParentAccount = $UserData->AccountID;
				$data['ItemsRole'] = ArrayHelper::map(Role::find()->where(['ForSubAccount' => 1])->all(), 'RoleID', 'RoleName');
				$data['aTypeUsers'] = ArrayHelper::map(TypeUsers::find()->all(), 'TypeUsersID', 'Name');
				$ModelUserAccount->TypeUser = 4;

			}else{
				$data['ItemsRole'] = ArrayHelper::map(Role::find()->all(), 'RoleID', 'RoleName');
				$data['aTypeUsers'] = ArrayHelper::map(TypeUsers::find()->all(), 'TypeUsersID', 'Name');

			}

			$transaction = \Yii::$app->db->beginTransaction();
			if(Yii::$app->request->post()){
				$ModelUserAccount->load(Yii::$app->request->post());
				$ModelUserAccount->rUserPassword = $ModelUserAccount->UserPassword;
				// $ModelAgency->load(Yii::$app->request->post());
				$ModelByRole->load(Yii::$app->request->post());
				$valid = $ModelUserAccount->validate();
				// $valid = $ModelAgency->validate() && $valid;
				//$valid = $ModelByRole->validate() && $valid;

				/* var_dump($ModelUserAccount);
				var_dump($ModelByRole);
				exit; */

				if($valid){
					try {
						$ModelAccount->IsActive = 1;
						$ModelAccount->AuditDate = new Expression('NOW()');
						$ModelAccount->AuditUser = "System";

						if(!$ModelAccount->save()){
							Yii::$app->session->setFlash('error', "There was an error creating the user.");
					        $transaction->rollBack();

					        echo "create Account";
					        exit();
						}

						$ModelUserAccount->AccountID = $ModelAccount->AccountID;
						$ModelUserAccount->ApiToken = $this->random_str(60);
						$ModelUserAccount->UserPassword = md5($ModelUserAccount->UserPassword);
						$ModelUserAccount->rUserPassword = md5($ModelUserAccount->rUserPassword);
						if(!$ModelUserAccount->save()){
							Yii::$app->session->setFlash('error', "There was an error creating the user.");
					        $transaction->rollBack();
					        echo "create UserAccount";
					        exit();
						}


						// $ModelAgency->AccountID = $ModelAccount->AccountID;

						// if(!$ModelAgency->save()){
						// 	Yii::$app->session->setFlash('error', "There was an error creating the user.");
					    //     $transaction->rollBack();
					    //     echo "create Agency";
					    //     exit();
						// }
						
						//if(!is_array($ModelByRole->RoleID) || count($ModelByRole) <= 0){
						// $ModelByRole->UserName = $ModelUserAccount->UserName;
						// var_dump($ModelByRole->RoleID);exit();
							// if(!$ModelByRole->save()){
								//Yii::$app->session->setFlash('error', "Ocurrio un error al intentar crear el usuario, porfavor intentelo nuevamente.");
								//$transaction->rollBack();
								//echo "UserByRole1";
								//exit();
							// }
						//}

					
						if(!is_array($ModelByRole->RoleID)){
							$modelRole = new UserByRole;
							$modelRole->UserName =  $ModelUserAccount->UserName;
							$modelRole->RoleID = $ModelByRole->getAttributes()["RoleID"];
							if(!$modelRole->save()){
								Yii::$app->session->setFlash('error', "Ocurrio un error al intentar crear el usuario, porfavor intentelo nuevamente.");
								$transaction->rollBack();
								echo "OnlyUserByRole";
								exit();
							}
						}else{
							foreach($ModelByRole->RoleID as $k =>$v){
								$modelRole = new UserByRole;
								$modelRole->UserName =  $ModelUserAccount->UserName;
								$modelRole->RoleID = $v;
								if(!$modelRole->save()){
									Yii::$app->session->setFlash('error', "Ocurrio un error al intentar crear el usuario, porfavor intentelo nuevamente.");
									$transaction->rollBack();
									echo "ArrayUserByRole";
									exit();
								}
							}
						}


						Yii::$app->session->setFlash('success', "Usuario registrado de forma correcta.");
						$transaction->commit();
						if($UserData->TypeUser == 2){
							\Yii::$app->SystemNotifications->sendPushNotificationGeneric('Nuevo usuario creado',$UserData->UserName.' ha creado al sub-usuario: '.$ModelUserAccount->UserName,['weclickdigital','vendedores']);
							return $this->redirect(['/usuario/my']);

						}else{
							\Yii::$app->SystemNotifications->sendPushNotificationGeneric('Nuevo usuario creado',$UserData->UserName.' ha creado al usuario: '.$ModelUserAccount->UserName);
							return $this->redirect(['/usuario']);
						}

					} catch (Exception $e) {
						Yii::$app->session->setFlash('error', "There was an error creating the user.");
					        $transaction->rollBack();
					        $data['ModelAccount'] = $ModelAccount;
							$data['ModelUserAccount'] = $ModelUserAccount;
							// $data['ModelAgency'] = $ModelAgency;
							$data['ModelByRole'] = $ModelByRole;
						
					}
				}else{
					Yii::$app->session->setFlash('error', "There was an error in validation data. Cheked an try again");
					$data['ModelAccount'] = $ModelAccount = new Account;
					$data['ModelUserAccount'] = $ModelUserAccount = new UserAccount;
					// $data['ModelAgency'] = $ModelAgency = new Directory;
					$data['ModelByRole'] = $ModelByRole = new UserByRole;
				}
			}



            return $this->render('userform', $data);
        }


	//Controlador para Actualizar datos de usuario
        public function actionUpdate($id)
        {
			$UserData =  Yii::$app->AccessControl->Verify([1,2]);

			$ModelFindUserAccount = UserAccount::findOne(['AccountID' => $id]);

			if (Yii::$app->request->isAjax && $ModelFindUserAccount->load(Yii::$app->request->post())) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return \yii\widgets\ActiveForm::validate($ModelFindUserAccount);
              }

        	
			// 1 = Users Admin
			// 2 = Users moderador
			// Verificar en tabla TypeUsers
			$data = [];
			$data['UserData'] = $UserData;
			$this->layout = $UserData->getLayout();
			
			
			

			$ModelAccount = Account::findOne($id);
			$ModelAccount->isNewRecord = false;
			$data['ModelAccount'] = $ModelAccount;
			$data['ModelUserAccount'] = $ModelUserAccount = $ModelFindUserAccount;
			// $data['ModelAgency'] = $ModelAgency = $ModelAccount->directory;
			//$data['ModelByRole'] = $ModelByRole = $ModelAccount->userAccount->userByRole;
			$ModelByRole = new UserByRole; ////$ModelAccount->userAccount->userByRole;
			$ModelByRole->RoleID =   ArrayHelper::map($ModelAccount->userAccount->userByRoles, 'RoleID', 'RoleID');
			$data['ModelByRole'] = $ModelByRole;

			if($UserData->TypeUser == 2){
				$ModelAccount->ParentAccount = $UserData->AccountID;
				$data['ItemsRole'] = ArrayHelper::map(Role::find()->where(['ForSubAccount' => 1])->all(), 'RoleID', 'RoleName');
				$data['aTypeUsers'] = ArrayHelper::map(TypeUsers::find()->all(), 'TypeUsersID', 'Name');
				$ModelUserAccount->TypeUser = 4;

			}else{
				$data['ItemsRole'] = ArrayHelper::map(Role::find()->all(), 'RoleID', 'RoleName');
				$data['aTypeUsers'] = ArrayHelper::map(TypeUsers::find()->all(), 'TypeUsersID', 'Name');

			}

			$transaction = \Yii::$app->db->beginTransaction();
			if(Yii::$app->request->post()){
				$ModelUserAccount->load(Yii::$app->request->post());
				$ModelUserAccount->rUserPassword = $ModelUserAccount->UserPassword;
				// $ModelAgency->load(Yii::$app->request->post());
				$ModelByRole->load(Yii::$app->request->post());
				$valid = $ModelUserAccount->validate();
				// $valid = $ModelAgency->validate() && $valid;
				//$valid = $ModelByRole->validate() && $valid;

				// Proteger usuarios admin: no permitir cambiar su tipo de usuario ni roles
				$isTargetAdmin = ($ModelFindUserAccount->TypeUser == 1);
				if ($isTargetAdmin) {
					// Forzar mantener el tipo de usuario como administrador
					$ModelUserAccount->TypeUser = 1;
					// Restaurar los roles originales del admin
					$ModelByRole->RoleID = ArrayHelper::map($ModelFindUserAccount->userByRoles, 'RoleID', 'RoleID');
				}

				if($ModelUserAccount->TypeUser != 4){
					$ModelAccount->ParentAccount = NULL;
				}
				

				if($valid){
					try {
							
						$ModelAccount->IsActive = 1;
						$ModelAccount->AuditDate = new Expression('NOW()');
						$ModelAccount->AuditUser = "System";

						if(!$ModelAccount->save()){
							Yii::$app->session->setFlash('error', "There was an error updating the user.");
					        $transaction->rollBack();

					        echo "create Account";
					        exit();
						}

						$ModelUserAccount->AccountID = $ModelAccount->AccountID;

						// Solo procesar si hay una nueva contraseña
						if(!empty($ModelUserAccount->UserPassword)){
							$ModelUserAccount->UserPassword = md5($ModelUserAccount->UserPassword);
							$ModelUserAccount->rUserPassword = $ModelUserAccount->UserPassword;
						} else {
							// Mantener la contraseña existente (ya encriptada)
							$ModelUserAccount->UserPassword = $ModelFindUserAccount->UserPassword;
						}
						if(!$ModelUserAccount->save()){
							Yii::$app->session->setFlash('error', "There was an error updating the user.");
					        $transaction->rollBack();
					        echo "create UserAccount";
					        exit();
						}

						// Si es admin, saltar la actualización de roles
						if (!$isTargetAdmin) {
							if(!is_array($ModelByRole->RoleID)){
								$modelRole = UserByRole::find()->where(['UserName' => $ModelUserAccount->UserName])->one();
								$modelRole->RoleID = $ModelByRole->getAttributes()["RoleID"];
								if(!$modelRole->save()){
									Yii::$app->session->setFlash('error', "Ocurrio un error al intentar crear el usuario, porfavor intentelo nuevamente.");
									$transaction->rollBack();
									echo "OnlyUserByRole";
									exit();
								}
							}else{
								UserByRole::deleteAll(['UserName' => $ModelUserAccount->UserName]);
								foreach($ModelByRole->RoleID as $k =>$v){
									$modelRole = new UserByRole;
									$modelRole->UserName =  $ModelUserAccount->UserName;
									$modelRole->RoleID = $v;
									if(!$modelRole->save()){
										Yii::$app->session->setFlash('error', "Ocurrio un error al intentar crear el usuario, porfavor intentelo nuevamente.");
										$transaction->rollBack();
										echo "UserByRole";
										exit();
									}
								}
							}
						}


						Yii::$app->session->setFlash('success', "Usuario actualizado correctamente");
						$transaction->commit();
						if($UserData->TypeUser == 2){
							return $this->redirect(['/usuario/my']);
						}else{
							return $this->redirect(['/usuario']);
						}

					} catch (Exception $e) {
						Yii::$app->session->setFlash('error', "There was an error updating the user.");
					        $transaction->rollBack();
					        $data['ModelAccount'] = $ModelAccount;
							$data['ModelUserAccount'] = $ModelUserAccount;
							// $data['ModelAgency'] = $ModelAgency;
							$data['ModelByRole'] = $ModelByRole;

							return $this->refresh();
						
					}
				}else{
					Yii::$app->session->setFlash('error', "There was an error in validation data. Cheked an try again");
					$data['ModelAccount'] = $ModelAccount = new Account;
					$data['ModelUserAccount'] = $ModelUserAccount = new UserAccount;
					// $data['ModelAgency'] = $ModelAgency = new Agency;
					$data['ModelByRole'] = $ModelByRole = new UserByRole;
				}
			}



            return $this->render('userform', $data);
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

    }
?>