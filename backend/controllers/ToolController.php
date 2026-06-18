<?php 
	namespace backend\controllers;

	// Configuración del algoritmo
	define('METODO_ENCRIPTACION', 'AES-256-CBC');
	date_default_timezone_set('America/Guatemala');

	use Yii;
	use yii\web\Controller;
    use common\components\ValidUsers;

	use yii\filters\VerbFilter;
    use yii\helpers\ArrayHelper;
	use yii\web\NotFoundHttpException;
	use yii\web\Response;
	use yii\web\UploadedFile;

    // use common\models\Menu;
	use common\models\ProjectWeclick;
	use common\models\ProjectBackup;
	use common\models\ProjectBackupAll;
	use common\models\ProjectDemo;
	use common\models\PolicySecure;
	use common\models\ProjectSecure;
	use common\models\ProviderWeclick;
	use common\models\PayConServ;

    
	use yii\data\ActiveDataProvider;


	class ToolController extends Controller{

        public function actionDevProject(){
			$UserData =  Yii::$app->AccessControl->Verify([1]);
			$data = [];

			$this->layout = $UserData->getLayout();

			$data['model'] = new ProjectWeclick;

			if(isset(Yii::$app->request->post('ProjectWeclick')['ProjectWeclickID'])){
				$data['model'] = ProjectWeclick::findOne(Yii::$app->request->post('ProjectWeclick')['ProjectWeclickID']);
			}

			$query = ProjectWeclick::find()->where(['Type' => 0])->orderBy(['Dominio' => SORT_ASC]);

			if($data['model']->load(Yii::$app->request->post())){

				$mi_clave = "MiContraseñaSuperSecreta2025";

				// 1. Encriptar
				$data['model']->Usuario = $this->encriptarPersonalizado($data['model']->Usuario, $mi_clave);
				$data['model']->Password = $this->encriptarPersonalizado($data['model']->Password, $mi_clave);

				//var_dump($data['model']); exit;
				
				if($data['model']->save()){
					Yii::$app->session->setFlash('success', "Datos guardados exitosamente.");
					return $this->refresh();
				}else {
					// Verificar si hay errores específicos de DB
					if($data['model']->hasErrors()) {
						echo '<pre>';
						print_r($data['model']->errors);
						echo '</pre>';
					} else {
						echo 'No hay errores de validación, pero save() retorna false';
						// Podría ser un problema con los atributos seguros
						var_dump($data['model']->attributes);
					}
					exit;
				}
			}

			$data['dataProvider']  = new ActiveDataProvider([
				'query' => $query,
				'pagination' => [
					'pageSize' => 20,
				],
			]);

			return $this->render('viewTable', $data);
		}

		public function actionProdProject(){
			$UserData =  Yii::$app->AccessControl->Verify([1]);
			$data = [];

			$this->layout = $UserData->getLayout();

			$data['model'] = new ProjectWeclick;

			if(isset(Yii::$app->request->post('ProjectWeclick')['ProjectWeclickID'])){
				$data['model'] = ProjectWeclick::findOne(Yii::$app->request->post('ProjectWeclick')['ProjectWeclickID']);
			}

			$query = ProjectWeclick::find()->where(['Type' => 1])->orderBy(['Dominio' => SORT_ASC]);

			$data['ps'] = PolicySecure::find()->all();

			if($data['model']->load(Yii::$app->request->post())){
				$mi_clave = "MiContraseñaSuperSecreta2025";

				// 1. Encriptar
				$data['model']->Usuario = $this->encriptarPersonalizado($data['model']->Usuario, $mi_clave);
				$data['model']->Password = $this->encriptarPersonalizado($data['model']->Password, $mi_clave);

				$data['model']->Type = 1;

				//var_dump($data['model']); exit;
				
				if( $data['model']->save()){
					Yii::$app->session->setFlash('success', "Datos guardados exitosamente.");
					return $this->refresh();
				}
			}

			$data['dataProvider']  = new ActiveDataProvider([
				'query' => $query,
				'pagination' => [
					'pageSize' => 20,
				],
			]);

			return $this->render('viewTableProd', $data);
		}

		public function actionBackupList(){
			$UserData =  Yii::$app->AccessControl->Verify([1]);
			$data = [];

			$this->layout = $UserData->getLayout();

			$data['model'] = new ProjectBackup;

			if(isset(Yii::$app->request->post('ProjectBackup')['ProjectWeclickID'])){
				$data['model'] = ProjectBackup::findOne(Yii::$app->request->post('ProjectBackup')['ProjectWeclickID']);
			}

			$query = ProjectBackup::find()->where(['Type' => 3])->orderBy(['Cliente' => SORT_ASC, 'Descripcion' => SORT_ASC]);

			if($data['model']->load(Yii::$app->request->post())){

				$data['model']->Type = 3;

				//var_dump($data['model']); exit;

				$data['model']->UrlProd = '/mnt/awsS3backup/backup-desarrollo/' . 'Cliente-' . $data['model']->Cliente . '/' . $data['model']->Descripcion;
				
				if( $data['model']->save()){
					Yii::$app->session->setFlash('success', "Datos guardados exitosamente.");
					return $this->refresh();
				}
			}

			$data['dataProvider']  = new ActiveDataProvider([
				'query' => $query,
				'pagination' => [
					'pageSize' => 20,
				],
			]);

			return $this->render('viewBackup', $data);
		}

		public function actionBackup2List(){
			$UserData =  Yii::$app->AccessControl->Verify([1]);
			$data = [];

			$this->layout = $UserData->getLayout();

			$data['model'] = new ProjectBackupAll;

			if(isset(Yii::$app->request->post('ProjectBackupAll')['ProjectWeclickID'])){
				$data['model'] = ProjectBackupAll::findOne(Yii::$app->request->post('ProjectBackupAll')['ProjectWeclickID']);
			}

			$query = ProjectBackupAll::find()->where(['Type' => 4])->orderBy(['Descripcion' => SORT_ASC]);

			if($data['model']->load(Yii::$app->request->post())){

				$data['model']->Type = 4;
				
				if( $data['model']->save()){
					Yii::$app->session->setFlash('success', "Datos guardados exitosamente.");
					return $this->refresh();
				}
			}

			$data['dataProvider']  = new ActiveDataProvider([
				'query' => $query,
				'pagination' => [
					'pageSize' => 20,
				],
			]);

			return $this->render('viewTableBackAll', $data);
		}

		public function actionDemoProject(){
			$UserData =  Yii::$app->AccessControl->Verify([1]);
			$data = [];

			$this->layout = $UserData->getLayout();

			$data['model'] = new ProjectDemo;

			if(isset(Yii::$app->request->post('ProjectDemo')['ProjectWeclickID'])){
				$data['model'] = ProjectDemo::findOne(Yii::$app->request->post('ProjectDemo')['ProjectWeclickID']);
			}

			$query = ProjectDemo::find()->where(['Type' => 2])->orderBy(['Dominio' => SORT_ASC]);

			if($data['model']->load(Yii::$app->request->post())){
				$mi_clave = "MiContraseñaSuperSecreta2025";

				// 1. Encriptar
				$data['model']->Usuario = $this->encriptarPersonalizado($data['model']->Usuario, $mi_clave);
				$data['model']->Password = $this->encriptarPersonalizado($data['model']->Password, $mi_clave);

				$data['model']->Type = 2;

				//var_dump($data['model']); exit;
				
				if( $data['model']->save()){
					Yii::$app->session->setFlash('success', "Datos guardados exitosamente.");
					return $this->refresh();
				}
			}

			$data['dataProvider']  = new ActiveDataProvider([
				'query' => $query,
				'pagination' => [
					'pageSize' => 20,
				],
			]);

			return $this->render('viewDemo', $data);
		}

		public function actionGetDataAjax(){
			$UserData =  Yii::$app->AccessControl->Verify([1]);

			$this->layout = false;
			
			if(isset($_POST['type']))
				$query = PolicySecure::find()->where(['PolicySecureID' => $_POST['id']])->asArray()->one();
			else{
				$query = ProjectWeclick::find()->where(['ProjectWeclickID' => $_POST['id']])->asArray()->one();

				$mi_clave = "MiContraseñaSuperSecreta2025";

				$query['Usuario'] = $this->desencriptarPersonalizado($query['Usuario'], $mi_clave);
				$query['Password'] = $this->desencriptarPersonalizado($query['Password'], $mi_clave);
			}

			

			echo json_encode($query);
		}

		public function actionDeletePliz($id){
			$UserData =  Yii::$app->AccessControl->Verify([1]);

			$this->layout = false;

			$model = isset($_GET['type']) ? PolicySecure::findOne($id) : ProjectWeclick::findOne($id);
			
			if($model->delete()){
				Yii::$app->session->setFlash('success','Datos elimados corectamente.');
				return $this->redirect(Yii::$app->request->referrer);
			}
    	}


		public function actionPolicySecure(){
			$UserData =  Yii::$app->AccessControl->Verify([1]);
			$data = [];

			$this->layout = $UserData->getLayout();

			$data['model'] = new PolicySecure;

			if(isset(Yii::$app->request->post('PolicySecure')['PolicySecureID'])){
				$data['model'] = PolicySecure::findOne(Yii::$app->request->post('PolicySecure')['PolicySecureID']);
			}

			$query = PolicySecure::find()->orderBy(['Nombre' => SORT_ASC]);

			if($data['model']->load(Yii::$app->request->post())){

				//var_dump($data['model']); exit;
				
				if($data['model']->save()){
					Yii::$app->session->setFlash('success', "Datos guardados exitosamente.");
					return $this->refresh();
				}else {
					// Verificar si hay errores específicos de DB
					if($data['model']->hasErrors()) {
						echo '<pre>';
						print_r($data['model']->errors);
						echo '</pre>';
					} else {
						echo 'No hay errores de validación, pero save() retorna false';
						// Podría ser un problema con los atributos seguros
						var_dump($data['model']->attributes);
					}
					exit;
				}
			}

			$data['dataProvider']  = new ActiveDataProvider([
				'query' => $query,
				'pagination' => [
					'pageSize' => 20,
				],
			]);

			return $this->render('viewPolicy', $data);
		}


		public function actionCheckPolicy($id){
			$UserData =  Yii::$app->AccessControl->Verify([1]);
			$data = [];

			$this->layout = $UserData->getLayout();

			$data['model'] = new ProjectSecure;

			$type = ProjectWeclick::find()->select(['TypeProject'])->where(['ProjectWeclickID' => $id])->scalar();
			
			$data['query'] = PolicySecure::find()->where(['Tipo' => ['General', $type]])->orderBy(['Nombre' => SORT_ASC])->all();

			//echo $data['query']->createCommand()->rawSql; exit;

			if($data['model']->load(Yii::$app->request->post())){
				//var_dump($data['model']->PolicySecureID); exit;
				ProjectSecure::deleteAll(['ProjectWeclickID' => $id]);
				foreach($data['model']->PolicySecureID as $psID){
					$model = new ProjectSecure;
					$model->PolicySecureID = $psID;  
					$model->ProjectWeclickID = $id;
					$model->save();
				}

				Yii::$app->session->setFlash('success', "Check completado.");
				return $this->refresh();
			}

			$data['id'] = $id;

			return $this->render('viewCheck', $data);
			
			exit;
		}



		/* ##################################################################################################################### */



		public function actionProviderWeclick(){
			$UserData =  Yii::$app->AccessControl->Verify([1]);
			$data = [];

			$this->layout = $UserData->getLayout();

			$data['model'] = new ProviderWeclick;

			if($data['model']->load(Yii::$app->request->post())){

				$data['model']->TypePay = 2;

				//var_dump($data['model']); exit;
				
				if( $data['model']->save()){
					Yii::$app->session->setFlash('success', "Datos guardados exitosamente.");
					return $this->refresh();
				}
			}

			$data['Mfijo'] = ProviderWeclick::find()->where(['TypePay' => 1])->one();
			$data['Mvariable'] = ProviderWeclick::find()->where(['TypePay' => 2])->all();

			return $this->render('provider/viewProvider', $data);
		}

		public function actionPayServProvider($id){
			$UserData =  Yii::$app->AccessControl->Verify([1, 6]);
			$data = [];

			$this->layout = $UserData->getLayout();

			$data['DataUser'] = $UserData;
			
			$data['model'] = $prowe = ProviderWeclick::findOne($id);

			$data['modelPay'] = new PayConServ;

			$query = PayConServ::find()->where(['ProviderID' => $id])->orderBy(['PayConServID' => SORT_DESC]);


			if($data['modelPay']->load(Yii::$app->request->post())){

				$data['modelPay']->Photo = UploadedFile::getInstance($data['modelPay'], 'Photo');

				if($prowe->TypePay == 1){
					if(($prowe->Debt - $data['modelPay']->Amount) < 0){
						Yii::$app->session->setFlash('error', "Cálculo no válido, da menos de 0.");
						return $this->refresh();
					}

					$data['modelPay']->Balance = ($prowe->Debt - $data['modelPay']->Amount);
				}else{
					if($data['modelPay']->TypeCurrency == "Dolares")
						$data['modelPay']->Conversion = ($data['modelPay']->Amount * 7.65);
					elseif($data['modelPay']->TypeCurrency == "Euros")
						$data['modelPay']->Conversion = ($data['modelPay']->Amount * 8.96);
					else
						$data['modelPay']->Conversion = $data['modelPay']->Amount;
				}

				/* var_dump($data['modelPay']);
				exit; */

				if($data['modelPay']->Photo != null)
					$data['modelPay']->upload();

				//$data['modelPay']->Date = date("Y-m-d H:i");
				$data['modelPay']->ProviderID = $id;

				if($data['modelPay']->save()){
					if($prowe->TypePay == 1){
						$prowe->Debt = ($prowe->Debt - $data['modelPay']->Amount);
						$prowe->save();
					}

					Yii::$app->session->setFlash('success', "Pago realizado exitosamente.");
					return $this->refresh();
				}else{
					if($data['modelPay']->hasErrors()) {
						echo '<pre>';
						print_r($data['modelPay']->errors);
						echo '</pre>';
					}
					exit;
				}

			}

			if($data['model']->load(Yii::$app->request->post())){
				
				if( $data['model']->save()){
					Yii::$app->session->setFlash('success', "Datos guardados exitosamente.");
					return $this->refresh();
				}
			}

			$data['dataProvider']  = new ActiveDataProvider([
				'query' => $query,
				'pagination' => [
					'pageSize' => 10,
				],
			]);

			return $this->render('provider/viewPay', $data);
		}

		public function actionSummaryPay($id){
			$UserData =  Yii::$app->AccessControl->Verify([1, 6]);
			$data = [];

			$this->layout = $UserData->getLayout();

			$query = PayConServ::find()->where(['ProviderID' => $id])->orderBy(['Date' => SORT_DESC]);

			$data['query'] = $query->all();

			$data['dataProvider']  = new ActiveDataProvider([
				'query' => $query,
				'pagination' => [
					'pageSize' => 10,
				],
			]);


			return $this->render('provider/viewReport', $data);
		}


		public function actionDeletePay($id){
			$UserData =  Yii::$app->AccessControl->Verify([1]);
			$data = [];

			$this->layout = $UserData->getLayout();

			$pc = PayConServ::findOne($id);

			if(is_file(Yii::$app->basePath . '/../uploads/' . $pc->Photo)){
			
				if($pc->providerWeck->TypePay == 1){
					$pc->providerWeck->Debt = ($pc->providerWeck->Debt + $pc->Amount);
					$pc->providerWeck->save();
				}
				unlink(Yii::$app->basePath . '/../uploads/' . $pc->Photo);
			}
			if($pc->delete()){
				Yii::$app->session->setFlash('success', "Datos eliminados exitosamente.");
				return $this->redirect(['pay-serv-provider', 'id' => $pc->providerWeck->ProviderID]);
			}
		}

		public function actionIncrConta(){

			$this->layout = false;

			echo 'gola';

			$pw = ProviderWeclick::findOne(1);
			
			$pay = new PayConServ;

			$pay->Amount = $pw->Amount;
			$pay->Balance = ($pw->Debt + $pw->Amount);
			$pay->Date = date("Y-m-d\TH:i");
			$pay->ProviderID = $pw->ProviderID;
			$pay->Type = 1;
			if($pay->save()){
				$pw->Debt = ($pw->Debt + $pw->Amount);
				$pw->save();
			}else{
				echo '<pre>';
				print_r($pay->errors);
				echo '</pre>';
			}

		}

		public function actionNotiService(){

			$this->layout = false;

			$pw = ProviderWeclick::findOne(1);

			//if((date('m', strtotime($pw->payService->Date)) != date('m'))){
				if(date("d") === "01"){
					$pw->Notification = true;
					$pw->save();
					\Yii::$app->SystemNotifications->sendPushNotificationGeneric("Serivicios", "Primer aviso, día " . date("d") . ", debe de pagar a su contador", ['weclickdigital']);
					//echo "activa alerta";
				}elseif(date("d") === "13"){
					\Yii::$app->SystemNotifications->sendPushNotificationGeneric("Serivicios", "Segundo aviso, día " . date("d") . ", debe de pagar a su contador", ['weclickdigital']);
				}
				elseif(date("d") === "22"){
					\Yii::$app->SystemNotifications->sendPushNotificationGeneric("Serivicios", "Tercer aviso, día " . date("d") . ", debe de pagar a su contador", ['weclickdigital']);
				}
			//}

		}


		/* ##################################################################################################################### */


		/**
		 * Encripta un string usando una contraseña clave.
		 */
		function encriptarPersonalizado($informacion, $clave_secreta) {
			// 1. Generar una clave segura de 32 bytes usando SHA256
			$key = hash('sha256', $clave_secreta, true);
			
			// 2. Crear un Vector de Inicialización (IV) aleatorio
			// Esto asegura que el mismo texto encriptado dos veces dé resultados distintos
			$iv_length = openssl_cipher_iv_length(METODO_ENCRIPTACION);
			$iv = openssl_random_pseudo_bytes($iv_length);
			
			// 3. Encriptar la información
			$encrypted = openssl_encrypt($informacion, METODO_ENCRIPTACION, $key, 0, $iv);
			
			// 4. Devolver el resultado codificado en base64
			// Concatenamos el IV al principio porque lo necesitaremos para desencriptar
			return base64_encode($iv . $encrypted);
		}

		/**
		 * Desencripta el string previamente encriptado.
		 */
		function desencriptarPersonalizado($informacion_encriptada, $clave_secreta) {
			// 1. Generar la misma clave segura
			$key = hash('sha256', $clave_secreta, true);
			
			// 2. Decodificar de base64 a binario
			$datos_binarios = base64_decode($informacion_encriptada);
			
			// 3. Extraer el Vector de Inicialización (IV)
			$iv_length = openssl_cipher_iv_length(METODO_ENCRIPTACION);
			$iv = substr($datos_binarios, 0, $iv_length);
			
			// 4. Extraer el texto cifrado real (lo que queda después del IV)
			$texto_cifrado = substr($datos_binarios, $iv_length);
			
			// 5. Desencriptar
			return openssl_decrypt($texto_cifrado, METODO_ENCRIPTACION, $key, 0, $iv);
		}

		// --- EJEMPLO DE USO ---

		/* $mi_clave = "MiContraseñaSuperSecreta2025";
		$mensaje_original = "Este es un dato confidencial de usuario.";

		echo "Mensaje Original: " . $mensaje_original . "<br><br>";

		// 1. Encriptar
		$token = encriptarPersonalizado($mensaje_original, $mi_clave);
		echo "<strong>Información Encriptada (Hash generado):</strong> " . $token . "<br><br>";

		// 2. Desencriptar
		$recuperado = desencriptarPersonalizado($token, $mi_clave);
		echo "<strong>Información Recuperada:</strong> " . $recuperado; */

    }