<?php 
	namespace frontend\controllers;

	use Yii;
	use yii\web\Controller;
    use common\components\ValidUsers;
	use yii\helpers\ArrayHelper;

	class VlogController extends Controller
	{
		public function actionIndex()
		{
			$data = [];
			$this->layout = "/lead"; //archivo para el header y footer, dentro de la carpeta layouts tiene que tener el mismo nombre
			/* $data['model'] = new FormRegistro; //nombre de la clase del modelo

			$infoUs = Yii::$app->LocationLang->info();
			$lang = $infoUs->language->LanguageCode;

			if($infoUs->language->LanguageCode == "es"){
				$countries = Countries::find()->orderBy(['Name' => SORT_ASC])->all();
				$data['countrie'] = ArrayHelper::map($countries, 'Name', 'Name');
				$data['prompt'] = "Selecciona tu país*";
			}else{
				$countries = Countries::find()->orderBy(['Name_en' => SORT_ASC])->all();
				$data['countrie'] = ArrayHelper::map($countries, 'Name_en', 'Name_en');
				$data['prompt'] = "Select your country*";
			}
			
			if($data['model']->load(Yii::$app->request->post())){
				if ($data['model']->valiCaptcha()) {
					$message1 = [
						'en' => 'A business consultant will be contacting you as soon as possible.',
						'fr' => 'Un consultant d\'affaires vous contactera dès que possible.',
						'it' => 'Un consulente aziendale ti contatterà il prima possibile.',
						'es' => 'Un consultor de negocios se estará contactando contigo lo más pronto posible.',
						'de' => 'Ein Unternehmensberater wird sich so schnell wie möglich mit Ihnen in Verbindung setzen.',
						'pt' => 'Um consultor de negócios entrará em contato com você o mais rápido possível.'
					];
					if($data['model']->sendNLContacto()){
						Yii::$app->session->setFlash('message',  $message1[$lang]);
					}
				}else{
					$message2 = [
						'en' => 'Error verifying the request.',
						'fr' => 'Erreur lors de la vérification de la demande.',
						'it' => 'Errore nella verifica della richiesta.',
						'es' => 'Error al verificar la solicitud.',
						'de' => 'Fehler bei der Überprüfung der Anfrage.',
						'pt' => 'Erro ao verificar a solicitação.'
					];
					
					Yii::$app->session->setFlash('message',  $message2[$lang]);
				}
				return $this->refresh();
			} */


			return $this->render('index');

		}
    }