<?php 
	namespace backend\controllers;

	use Yii;
	use yii\web\Controller;
	use yii\helpers\ArrayHelper;
    use yii\data\ActiveDataProvider;
    use yii\web\UploadedFile;
    use yii\helpers\Url;
    use common\models\Porfolio;
    use common\models\PorfolioRestriction;
    use common\models\PorfolioAnexos;
    use common\models\SoftCanned;

	class PorfolioController extends Controller{

		public function actionIndex(){
            $UserData =  Yii::$app->AccessControl->Verify();

            $data = [];
			$this->layout = $UserData->getLayout();

            $model = Porfolio::find()->orderBy(['Position' => SORT_ASC]);

            $data['dataProvider']  = new ActiveDataProvider([
				'query' => $model,
				'pagination' => [
					'pageSize' => 8,
				],
			]);

            return $this->render('index', $data);
        }

        public function actionAdd(){
            $UserData =  Yii::$app->AccessControl->Verify();

            $data = [];
			$this->layout = $UserData->getLayout();

            $infoUs = Yii::$app->LocationLang->info();
			$lang = $infoUs->language->LanguageCode;

            $data['model'] = new Porfolio();
            $data['porane'] = new PorfolioAnexos();

            if($data['model']->load(Yii::$app->request->post())){
                if($data['model']->validate()){

                    $translate = Yii::$app->Translate;

                    $idiomas = ['es', 'en'];

                    for($i=0; $i <2 ; $i++) { 
                        $Proyect = 'Proyect'.strtoupper($idiomas[$i]);
                        $Description = 'Description'.strtoupper($idiomas[$i]);

                        $data['model']->$Proyect = ($idiomas[$i] == $lang) ? $data['model']->Proyect : $translate->translate($data['model']->Proyect, ['TargetLG' => $idiomas[$i]])->text;
                        $data['model']->$Description = ($idiomas[$i] == $lang) ? $data['model']->Description : $translate->translate($data['model']->Description, ['TargetLG' => $idiomas[$i]])->text;
                    }

                    $data['model']->Photo = UploadedFile::getInstance($data['model'], 'Photo');
                    if($data['model']->Photo != null)
                        $data['model']->upload();

                    $data['model']->VideoPF = UploadedFile::getInstance($data['model'], 'VideoPF');
                    if($data['model']->VideoPF != null)
                        $data['model']->uploadVideo();

                    $comPosi = Porfolio::find()->orderBy(['Position' => SORT_DESC])->one();
                    $data['model']->Position = ($comPosi->Position + 1);

                    if($data['model']->save()){
                        if($data['porane']->load(Yii::$app->request->post()) && $data['model']->validate()){
                            $PhotoAnexos = UploadedFile::getInstances($data['porane'], 'PhotoAnexos');
                            foreach ($PhotoAnexos as $index => $file) {
                                $newFilename = "ImageAnexo_". substr(md5(uniqid(rand())),0,6) . '.' . $file->extension;
                                $file->saveAs(Yii::$app->basePath.'/../images/porfolio/anexos/' . $newFilename);
    
                                $PorfolioAnexos = new PorfolioAnexos();
                                $Porfolio = Porfolio::find()->orderBy(['PorfolioID' => SORT_DESC])->one();
                                $PorfolioAnexos->Image = Url::to('porfolio/anexos/') . $newFilename;
                                $PorfolioAnexos->PorfolioID = $Porfolio->PorfolioID;
                                $PorfolioAnexos->save();
                            }
                        }
                        Yii::$app->session->setFlash('success', 'Portafolio creado correctamente.');
                        return $this->refresh();
                    }
                }else {
                    // La validación falló
                    $errors = $data['model']->errors;
                    // Puedes imprimir o registrar los errores para depuración
                    var_dump($errors); exit;
                }
            }

            return $this->render('crear', $data);
        }

        public function actionUpdate($id){
            $UserData =  Yii::$app->AccessControl->Verify();

            $infoUs = Yii::$app->LocationLang->info();
			$lang = $infoUs->language->LanguageCode;

            $data = [];
			$this->layout = $UserData->getLayout();

            $model = new Porfolio();

            $data['model'] = $model->porfolio($id);
            //$data['porane'] = PorfolioAnexos::find()->where(['PorfolioID' => $data['model']->PorfolioID])->one();

            if($data['model']->load(Yii::$app->request->post())){
                if($data['model']->validate()){

                    $translate = Yii::$app->Translate;

                    $idiomas = ['es', 'en'];

                    for($i=0; $i <2 ; $i++) { 
                        $Proyect = 'Proyect'.strtoupper($idiomas[$i]);
                        $Description = 'Description'.strtoupper($idiomas[$i]);

                        $data['model']->$Proyect = ($idiomas[$i] == $lang) ? $data['model']->Proyect : $translate->translate($data['model']->Proyect, ['TargetLG' => $idiomas[$i]])->text;
                        $data['model']->$Description = ($idiomas[$i] == $lang) ? $data['model']->Description : $translate->translate($data['model']->Description, ['TargetLG' => $idiomas[$i]])->text;
                    }

                    $data['model']->Photo = UploadedFile::getInstance($data['model'], 'Photo');
                    if($data['model']->Photo != null)
                        $data['model']->upload();

                    $data['model']->VideoPF = UploadedFile::getInstance($data['model'], 'VideoPF');
                    if($data['model']->VideoPF != null)
                        $data['model']->uploadVideo();

                    if($data['model']->save()){
                        $post = Yii::$app->request->post('PorfolioAnexos');
                        foreach ($post as $index => $data) {
                            // Verificamos si hay un AnexosID, lo que significa que es una imagen existente
                            if (!empty($data['AnexosID'])) {
                                $model = PorfolioAnexos::findOne($data['AnexosID']);
                            }else {
                                // Si no hay AnexosID, creamos un nuevo modelo
                                $model = new PorfolioAnexos();
                                $model->PorfolioID = $id; // Asegúrate de asociar el nuevo modelo con el ID de la cartera
                            }

                            // Obtenemos el archivo subido
                            $file = UploadedFile::getInstance($model, "[$index]PhotoAnexos");
                            // Si se subió un archivo, lo guardamos y actualizamos la base de datos
                            if($file && $file instanceof UploadedFile) {
                                $newFilename = "ImageAnexo_". substr(md5(uniqid(rand())),0,6) . '.' . $file->extension;
                                var_dump($newFilename);
                                $file->saveAs(Yii::$app->basePath.'/../images/porfolio/anexos/' . $newFilename);
                                $model->Image = Url::to('porfolio/anexos/') . $newFilename;
                                $model->save();
                            }
                        }
                        Yii::$app->session->setFlash('success', 'Portafolio modificado correctamente.');
                        return $this->refresh();
                    }
                }else {
                    // La validación falló
                    $errors = $data['model']->errors;
                    // Puedes imprimir o registrar los errores para depuración
                    var_dump($errors); exit;
                }
            }

            return $this->render('update', $data);
        }

        public function actionDelete($id){
            $model = Porfolio::findOne($id);
            $model2 = PorfolioAnexos::find()->where(['PorfolioID' => $id])->all();

            if($model->Image != ""){
                $imagen = Yii::$app->basePath.'/../images/'.$model->Image;
                if(is_file($imagen))
                    unlink($imagen);
            }
            if($model->Video != ""){
                $video = Yii::$app->basePath.'/../'.$model->Video;
                if(is_file($video))
                    unlink($video);
            }
            
            foreach($model2 as $mphoto){
                $imagenes = Yii::$app->basePath.'/../images/'.$mphoto->Image;
                if(is_file($imagenes))
                    unlink($imagenes);
            }

            if($model->delete()){
                Yii::$app->session->setFlash('success', 'Portafolio eliminado correctamente.');
                return $this->redirect(['porfolio/index']);
            }
            
        }

        public function actionDeleteitems(){
            $this->layout = false;

            if(!empty($_POST['data']['image'])){
                $model = PorfolioAnexos::findOne($_POST['data']['id']);

                if($model->Image != ""){
                    $imagen = Yii::$app->basePath.'/../images/'.$_POST['data']['image'];
                    if(is_file($imagen))
                        unlink($imagen);
                }

                $data['status'] = $model->delete() ? true : false;
            }elseif(!empty($_POST['data']['video'])){
                $model = Porfolio::findOne($_POST['data']['id']);

                if($model->Video != ""){
                    $video = Yii::$app->basePath.'/../'.$_POST['data']['video'];
                    if(is_file($video))
                        unlink($video);
                }
    
                $model->Video = NULL;

                $data['status'] = $model->save(false) ? true : false;
            }

            echo json_encode($data);
        }

        public function actionPosition(){
			$UserData =  Yii::$app->AccessControl->Verify();
			$this->layout = $UserData->getLayout();

			$data = [];

			$data['position'] = Porfolio::find()->orderBy(['Position' => SORT_ASC])->all();

			return $this->render('ordenposition', $data);

		}

        public function actionAjaxneworden(){
           
			$data = [];

			foreach($_POST['data'] as $items){
				$proyect = Porfolio::findOne($items['id']);
				$proyect->Position = $items['position'];
				$data['response'] = $proyect->save(false) ? true : false;
			}
			echo json_encode($data);
		}

    }