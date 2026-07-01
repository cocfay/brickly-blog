<?php 
	namespace backend\controllers;
/* 
	error_reporting(E_ERROR | E_PARSE); */

	use Yii;
	use yii\db\Command;
	use yii\web\Controller;
	use yii\filters\VerbFilter;
	use yii\filters\AccessControl;
	use yii\data\ActiveDataProvider;

	use common\components\ValidUsers;
	use common\models\Blog;
	use common\models\Collections;
	use common\models\Porfolio;
	use common\models\CollectionByPost;
	use common\models\BlogByProject;
	use yii\web\UploadedFile;
	use yii\helpers\ArrayHelper;
	use yii\db\Expression;
	use common\models\UserAccount;

	use yii\helpers\Url;
	use yii\data\Pagination;


	use common\models\PostBlog;
	use common\models\PostBlogTitle;
	use common\models\ChecklistFilesForm;



	use common\models\PostBlogCenterComponents;

	use common\models\TextBoxComponents;
	use common\models\TextBoxComponentsData;

	use common\models\ImagesComponents;
	use common\models\ImagesComponentsDescription;

	use common\models\YtVideoComponents;

	//use common\models\CarouselComponents;
	//use common\models\CarouselComponentsImages;




	class BlogController extends Controller
	{
		private $_ValidUser;
		public $_MenuController = "";
		public $_PagePath = "";

		public function init(){
			parent::init();
			$infoUs = Yii::$app->LocationLang->info();
			$lang = $infoUs->language->LanguageCode;

			Yii::$app->language = $lang;
    	}

		public function beforeAction($action)
		{
		    if ($action->id === 'featured' || $action->id === 'ajaxhome' || $action->id === 'massive-delete') {
		        $this->enableCsrfValidation = false;
		    }
		    return parent::beforeAction($action);
		}

		public function actionIndex(){	

			$UserData =  Yii::$app->AccessControl->Verify([1]);

            $data = [];
			$this->layout = $UserData->getLayout();

			$infoUs = Yii::$app->LocationLang->info();

			$model = PostBlog::find()->where(['Verified' => 1])->orderBy(['Featured' => SORT_DESC, 'PostBlogID' => SORT_DESC]);
			$data['dataProvider']  = new ActiveDataProvider([
			    'query' => $model,
			    'pagination' => [
			        'pageSize' => 10,
			    ],
			]);

			return $this->render('index', [
				'dataProvider' => $data['dataProvider'],
			]);
		}

		public function actionOrderhome(){	

			$UserData =  Yii::$app->AccessControl->Verify([1]);

            $data = [];
			$this->layout = $UserData->getLayout();

			$infoUs = Yii::$app->LocationLang->info();

			$data['modelL'] = PostBlog::find()->where(['Verified' => 1, 'Featured' => 0, 'Home' => 0])->orderBy(['PostBlogID' => SORT_DESC])->all();
			$data['modelR'] = PostBlog::find()->where(['Verified' => 1, 'Featured' => 0])->andWhere(['!=', 'Home', 0])->orderBy(['Home' => SORT_ASC])->all();
			
			return $this->render('order', $data);
		}

		public function actionAjaxhome(){	

			$UserData =  Yii::$app->AccessControl->Verify([1]);

            $data = [];
			$this->layout = false;

			PostBlog::updateAll(['Home' => 0]);

			foreach($_POST['ids'] as $i => $id){
				$model = PostBlog::findOne($id);
				$model->Home = ($i + 1);
				$model->save(false);
			}

		}

		public function actionFeatured(){
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

			try {
				$UserData =  Yii::$app->AccessControl->Verify([1]);

				$id = Yii::$app->request->post('id');

				if(!$id){
					return ['error' => true, 'message' => 'ID de artículo no válido.'];
				}

				$model = PostBlog::findOne($id);
				if(!$model){
					return ['error' => true, 'message' => 'El artículo no existe.'];
				}

				PostBlog::updateAll(['Featured' => 0]);
				$model->Featured = 1;
				$model->save(false);

				return ['error' => false, 'message' => 'Artículo Destacado'];
			} catch (\Exception $e) {
				return ['error' => true, 'message' => 'Error: ' . $e->getMessage()];
			}
		}

		public function actionTendencia(){	

			$UserData =  Yii::$app->AccessControl->Verify([1]);

            $data = [];
			$this->layout = $UserData->getLayout();

			$infoUs = Yii::$app->LocationLang->info();

			$model = PostBlog::find()->where(['Verified' => 1, 'Featured' => 1])->orderBy(['PostBlogID' => SORT_DESC]);
			$data['dataProvider']  = new ActiveDataProvider([
			    'query' => $model,
			    'pagination' => [
			        'pageSize' => 10,
			    ],
			]);

			return $this->render('tendencia', [
				'dataProvider' => $data['dataProvider'],
			]);
		}

	
		public function actionPicturecomponents()
		{	
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

			$infoUs = Yii::$app->LocationLang->info();
			$lang = $infoUs->language->LanguageCode;

			if(Yii::$app->user->isGuest){
				return ['error'=>true, 'message' => "Debe iniciar session para poder cargar su checklist"];
			}


			$UpFile = new ChecklistFilesForm();
			if($UpFile->load(Yii::$app->request->post())){
				
				$UpFile->ImageFile  = UploadedFile::getInstance($UpFile, 'ImageFile');
					$user = Yii::$app->user->identity;
					$fPath = \Yii::getAlias('@proyectroot');

					if($UpFile->ConditionID == 2){
						$dirUserTemp = $fPath.'/images/BlogPostImages/temp/'.$user->AccountID.'/post/';
						$dirUser = $fPath.'/images/BlogPostImages/'.$user->AccountID.'/post/';
					}elseif($UpFile->ConditionID == 4){
						$dirUserTemp = $fPath.'/images/BlogPostImages/temp/'.$user->AccountID.'/carousel/';
						$dirUser = $fPath.'/images/BlogPostImages/'.$user->AccountID.'/carousel/';
					}else{
						return ['error'=>true, 'message' => "La solicitud enviada es incorrecta."];
					}
					//return $dirUserTemp;
					if(!file_exists($dirUserTemp.'temp.txt')) {
						mkdir($dirUserTemp.'temp.txt', 0777, true);

					}
					if(!file_exists($dirUser.'user.txt')) {
						mkdir($dirUser.'user.txt', 0777, true);
					}

					if($UpFile->upload($dirUserTemp)){
						if($UpFile->ConditionID == 2){
							$completeurlTemp = Url::to('@raizweb').'/images/BlogPostImages/temp/'.$user->AccountID.'/post/'.$UpFile->NameFileSv;
						}else{
							$completeurlTemp = Url::to('@raizweb').'/images/BlogPostImages/temp/'.$user->AccountID.'/carousel/'.$UpFile->NameFileSv;
						}

						return ['error'=>false,'url' => $UpFile->NameFileSv, 'urlabsolute'=>$completeurlTemp];

					}else{
						return ['error'=>true, 'message' => "No se pudo guardar temporalmente su imagen"];
					}

			}else{
				return ['error'=>true, 'message' => "La solicitud enviada es incorrecta"];
			}

		}

		private function deleteAllFile($dir,$omit) {
		    foreach(glob($dir . '/*') as $file) {
		        if(is_dir($file)){
		          //  deleteAll($file);
		        }
		        elseif(pathinfo($file, PATHINFO_BASENAME) != $omit){
		            unlink($file);
		    	}
		    }
		}

		public function actionFormPost($edit=false){
			$UserData =  Yii::$app->AccessControl->Verify([1]);

            $data = [];
			$this->layout = $UserData->getLayout();

			$roles = $UserData->userByRoles;
			$ArrayRoleID = ArrayHelper::map($roles, 'RoleID', 'RoleID');

			if(!in_array(4, $ArrayRoleID) && !in_array(1, $ArrayRoleID)){
				return Yii::$app->response->redirect(['blog']);
			}
			
			$langs = ['es'];
			//$idiomas = ['Es', 'En', 'Pt', 'It', 'Fr', 'De'];
			$langInUse = $data['lang'] = 'es';

			$data['CbyB'] = new CollectionByPost;
			$data['Project'] = new BlogByProject;

			// $data['ModelBlog'] = PostBlog::findOne(1);
			if($edit){
				$data['ModelBlog'] = $postBlogModel = PostBlog::findOne($edit);
				if(!$data['ModelBlog']){
					return $this->redirect(['form-post']);
				}

				$data['ModelBlog']->CreateAT = date("Y-m-d", strtotime($data['ModelBlog']->CreateAT));

				$data['CbyB']->Labels = array_keys(ArrayHelper::map($data['ModelBlog']->blogBy, 'CollectionID', 'Name'.ucfirst($data['lang'])));
				$data['Project']->Project = array_keys(ArrayHelper::map($data['ModelBlog']->project, 'PorfolioID', 'Title'));

			}else{
				$data['ModelBlog'] = $postBlogModel = new PostBlog;
				$data['ModelBlog']->CreateAT = date("Y-m-d");
				//$colecciones = Collections::find()->select(["*", "Name" . ucfirst($data['lang']) . " AS Name"])->where(['Display' => '1'])->orderBy(['CollectionID' => SORT_ASC])->all();
			}

			$colecciones = Collections::find()->select(["*", "Name" . ucfirst($data['lang']) . " AS Name"])->where(['Display' => '1'])->orderBy(['CollectionID' => SORT_ASC])->all();
			$projects = Porfolio::find()->all();

			$data['projectsList'] = ArrayHelper::map($projects, 'PorfolioID', 'Title');
			$data['collectionList'] = ArrayHelper::map($colecciones, 'CollectionID', 'Name');

			if($postBlogModel->load(Yii::$app->request->post())){

				$postBlogModel->RequestFile  = UploadedFile::getInstance($postBlogModel, 'RequestFile');
				$postBlogModel->AccountID = $UserData->AccountID;

				$Components = isset(Yii::$app->request->post()['Components'])? Yii::$app->request->post()['Components'] : false;
				if(!$Components){
					if($postBlogModel->RequestFile != null){
						$postBlogModel->upload();
					}
					Yii::$app->session->setFlash('error', "Debe incluir como minimo 1 componente para generar un Post.");
					$data['CbyB']->load(Yii::$app->request->post());
					$data['Project']->load(Yii::$app->request->post());
					$data['Components'] = [];
					return $this->render('postform', $data);
				}

				$postBlogModel->CreateAT = $postBlogModel->CreateAT . ' ' . date("H:i:s");
				if (!$edit) {
					$postBlogModel->Featured = 0;
				}
				/* if(!isset(Yii::$app->request->post()['PostBlog']['CollectionID'])){
					$postBlogModel->CollectionID = new \yii\db\Expression('NULL');
				} */


				$transaction = \Yii::$app->db->beginTransaction();
				$fPath = \Yii::getAlias('@proyectroot');
				$dirUserTemp = $fPath.'/images/BlogPostImages/temp/'.$UserData->AccountID.'/post/';
				$dirUser = $fPath.'/images/BlogPostImages/'.$UserData->AccountID.'/post/';

				$dirUserTempCarousel = $fPath.'/images/BlogPostImages/temp/'.$UserData->AccountID.'/carousel/';
				$dirUserCarousel = $fPath.'/images/BlogPostImages/'.$UserData->AccountID.'/carousel/';
				try {
					$unlinkImage = [];
					if($edit){

						$ImagesDelete = ImagesComponents::find()->where(['PostBlogID' => $edit])->all();

						foreach ($ImagesDelete as $ImageF) {
							$NameImageExtract = explode('/'.$UserData->AccountID.'/post/', $ImageF->ImagePatch);
							if(isset($NameImageExtract[1])){
								$unlinkImage[] = $dirUser.$NameImageExtract[1];
							}
						}

						/* $carouComp = CarouselComponents::find()->where(['PostBlogID' => $edit])->all();

						foreach ($carouComp as $cmpCaro) {
							foreach ($cmpCaro->imagesCarousel as $imgCarous) {
								$NameImageExtractC = explode('/'.$UserData->AccountID.'/carousel/', $imgCarous->ImagePatch);
								if(isset($NameImageExtractC[1])){
									$unlinkImage[] = $dirUserCarousel.$NameImageExtractC[1];
								}
							}
						} */

						PostBlogTitle::deleteAll(['PostBlogID' => $edit]);
						PostBlogCenterComponents::deleteAll(['PostBlogID' => $edit]);
					}

					$tp = \Yii::$app->request->post('typesave');
					switch ($tp) {
						case 'g':
							//$postBlogModel->Status = 0;
							$postBlogModel->Verified = 1;
							break;
						case 'p':
							//$postBlogModel->Status = 1;
							$postBlogModel->Verified = 1;
							break;
						case 'e':
							if($postBlogModel->delete()){
								Yii::$app->session->setFlash('success', "Artículo eliminado correctamente");
				              	$transaction->commit();
				              	$this->deleteAllFile($dirUserTemp,'temp.txt');
				              	$this->deleteAllFile($dirUserTempCarousel,'temp.txt');

				              	foreach ($unlinkImage as $key => $unlinkroute) {
				              		if(file_exists($unlinkroute)){
				              			if(is_dir($unlinkroute)){
								          //  deleteAll($file);
								        }else{
								            unlink($unlinkroute);
								    	}
				              		}
				              	}
				              	return $this->redirect(['form-post']);
				              }else{
				              	Yii::$app->session->setFlash('error', "Ocurrio un error al eliminar el artículo intente nuevamete.");
					            $transaction->rollBack();
					            return $this->refresh();
				              }
							break;
						
						default:
							Yii::$app->session->setFlash('error', "Ocurrio un error al guardar el artículo intente nuevamete.");
				              $transaction->rollBack();
				              return $this->refresh();
							break;
					}
					


					if($postBlogModel->RequestFile != null){
						if(!empty($postBlogModel->ImagePost)){
							$NameImageExtractP = explode('/post/', $postBlogModel->ImagePost);
							if(isset($NameImageExtractP[1])){
								$unlinkImage[] =  $fPath.'/post/'.$NameImageExtractP[1];
							}
						}
						$upload = $postBlogModel->upload();
					}



					if (!$postBlogModel->Slug) {
						$baseSlug = \yii\helpers\Inflector::slug($postBlogModel->VTitle);
						$slug = $baseSlug;
						$counter = 1;
						while (PostBlog::find()->where(['Slug' => $slug])->andFilterWhere(['!=', 'PostBlogID', $postBlogModel->PostBlogID])->exists()) {
							$slug = $baseSlug . '-' . ++$counter;
						}
						$postBlogModel->Slug = $slug;
					}

					if(!$postBlogModel->save()){

						var_dump($postBlogModel->getErrors());
						exit();
						Yii::$app->session->setFlash('error', "Ocurrio un error al guardar el artículo intente nuevamete.");
			              $transaction->rollBack();
			              return $this->refresh();
					}



					foreach ($langs as $key => $LangTarget) {
						$modelPostBlogTitle = new PostBlogTitle();
						$modelPostBlogTitle->PostBlogID = $postBlogModel->PostBlogID;
						if(strtoupper($langInUse) == strtoupper($LangTarget)){
							$modelPostBlogTitle->Data = $postBlogModel->VTitle;
						}else{
							$modelPostBlogTitle->Data = $postBlogModel->VTitle;
						}
						$modelPostBlogTitle->Lang = $LangTarget;
						if(!$modelPostBlogTitle->save()){
							var_dump($modelPostBlogTitle->getErrors());
							exit();
							Yii::$app->session->setFlash('error', "Ocurrio un error al guardar el artículo intente nuevamete.");
				              $transaction->rollBack();
				              return $this->refresh();
						}
					}

					foreach ($Components as $Componenet) {
						$Center = new PostBlogCenterComponents(['PostBlogID'=>$postBlogModel->PostBlogID]);
						switch ($Componenet['Type']) {
							case '1':
								if( !empty($Componenet['TextBox'])){

									$Center->Type = 1;
									if(!$Center->Save()){
										var_dump($Center->getErrors());
										exit();
										Yii::$app->session->setFlash('error', "Ocurrio un error al guardar el artículo intente nuevamete.");
							              $transaction->rollBack();
							              return $this->refresh();
									}

									$TextComponent = new TextBoxComponents(['PostBlogID'=>$postBlogModel->PostBlogID, 
																			'PostBlogCenterComponentID' => $Center->PostBlogCenterComponentID
																		]);

									if(empty($Componenet['MovilTextBox']) || $Componenet['MovilTextBox'] == ""){
										$Componenet['MovilTextBox'] = strip_tags($Componenet['TextBox']);
									}

									if(!$TextComponent->Save()){
										var_dump($TextComponent->getErrors());
										exit();
										Yii::$app->session->setFlash('error', "Ocurrio un error al guardar el artículo intente nuevamete.");
							              $transaction->rollBack();
							              return $this->refresh();
									}
									foreach ($langs as $key => $LangTarget) {
										$TexBoxDataModel = new TextBoxComponentsData();
										if(strtoupper($langInUse) == strtoupper($LangTarget)){
											$TexBoxDataModel->Data = $Componenet['TextBox'];
											$TexBoxDataModel->DataMovil = $Componenet['MovilTextBox'];

										}else{
											$TexBoxDataModel->Data = $Componenet['TextBox'];
											$TexBoxDataModel->DataMovil = $Componenet['MovilTextBox'];
										}
										$TexBoxDataModel->Lang = $LangTarget;
										$TexBoxDataModel->TexBoxComponentID = $TextComponent->TexBoxComponentID;
										if(!$TexBoxDataModel->save()){
											var_dump($TexBoxDataModel->getErrors());
											exit();
											Yii::$app->session->setFlash('error', "Ocurrio un error al guardar el artículo intente nuevamete.");
								              $transaction->rollBack();
								              return $this->refresh();
										}

									}
								}
								break;
							case '2':
								if(!empty($Componenet['ImageName'])
								){
									$Center->Type = 2;
									if(!$Center->Save()){
										var_dump($Center->getErrors());
										exit();
										Yii::$app->session->setFlash('error', "Ocurrio un error al guardar el artículo intente nuevamete.");
							              $transaction->rollBack();
							              return $this->refresh();
									}

									$user = $UserData;

									$NameFileTemp = $Componenet['ImageName'];
									
									$ImageComponenet = new ImagesComponents(['PostBlogID'=>$postBlogModel->PostBlogID, 
																			'PostBlogCenterComponentID' => $Center->PostBlogCenterComponentID
																			]);

									if(preg_match('/\/BlogPostImages\//', $NameFileTemp)){
										$ImageComponenet->ImagePatch = $NameFileTemp;

										$explDName = explode('/'.$UserData->AccountID.'/post/', $NameFileTemp);
										$dirSearch = $dirUser.$explDName[1];
										$indexDeleteImage = array_search($dirSearch, $unlinkImage);
										if($indexDeleteImage || $indexDeleteImage === 0){
											unset($unlinkImage[$indexDeleteImage]);
										}

									}else{
										$ImageComponenet->ImagePatch = Url::to('@raizweb').'/images/BlogPostImages/'.$user->AccountID.'/post/'.$NameFileTemp;
									}
									
									$ImageComponenet->Position = $Componenet['Position'];

									if(!$ImageComponenet->Save()){
										var_dump($ImageComponenet->getErrors());
										exit();
										Yii::$app->session->setFlash('error', "Ocurrio un error al guardar el artículo intente nuevamete.");
							              $transaction->rollBack();
							              return $this->refresh();
									}

									if(file_exists($dirUserTemp.$NameFileTemp)){
										rename($dirUserTemp.$NameFileTemp, $dirUser.$NameFileTemp);
									}
									if(!empty($Componenet['Description']) || !empty($Componenet['ImageBy'])){

										if(empty($Componenet['MovilDescription']) || $Componenet['MovilDescription'] == ""){
											$Componenet['MovilDescription'] = strip_tags($Componenet['Description']);
										}

										foreach ($langs as $key => $LangTarget) {
											$ImagenDescriptComp = new ImagesComponentsDescription();
											if(strtoupper($langInUse) == strtoupper($LangTarget)){
												if(!empty($Componenet['Description'])){
													$ImagenDescriptComp->Data = $Componenet['Description'];
												}

												if(!empty($Componenet['MovilDescription'])){
													$ImagenDescriptComp->DataMovil = $Componenet['MovilDescription'];
												}

												if(!empty($Componenet['ImageBy'])){
													$ImagenDescriptComp->ImageBy = $Componenet['ImageBy'];
												}

											}else{
												if(!empty($Componenet['Description'])){
													$ImagenDescriptComp->Data = $Componenet['Description'];
												}
												if(!empty($Componenet['MovilDescription'])){
													$ImagenDescriptComp->DataMovil = $Componenet['MovilDescription'];
												}
												if(!empty($Componenet['ImageBy'])){
													$ImagenDescriptComp->ImageBy = $Componenet['ImageBy'];
												}

											}
											$ImagenDescriptComp->Lang = $LangTarget;
											$ImagenDescriptComp->ImageComponentID = $ImageComponenet->ImageComponentID;
											if(!$ImagenDescriptComp->save()){
												var_dump($ImagenDescriptComp->getErrors());
												exit();
												Yii::$app->session->setFlash('error', "Ocurrio un error al guardar el artículo intente nuevamete.");
									              $transaction->rollBack();
									              return $this->refresh();
											}

										}
									}

								}
								break;
							case '3':
								if(!empty($Componenet['UrlVideo']) && (preg_match('/watch\?v=/', $Componenet['UrlVideo']) || preg_match('/youtu\.be\//', $Componenet['UrlVideo']) || preg_match('/youtube\.com\/embed\//', $Componenet['UrlVideo']))
								){
									$Center->Type = 3;
									if(!$Center->Save()){
										var_dump($Center->getErrors());
										exit();
										Yii::$app->session->setFlash('error', "Ocurrio un error al guardar el artículo intente nuevamete.");
							              $transaction->rollBack();
							              return $this->refresh();
									}
									$linksave = '';
									if(preg_match('/watch\?v=/', $Componenet['UrlVideo'])){
										$linksave = explode('watch?v=',$Componenet['UrlVideo']);
										$linksave = $linksave[1];
									}
									if(preg_match('/youtu\.be\//', $Componenet['UrlVideo'])){
										$linksave = explode('youtu.be/',$Componenet['UrlVideo']);
										$linksave = $linksave[1];
									}
									if(preg_match('/youtube\.com\/embed\//', $Componenet['UrlVideo'])){
										$linksave = explode('youtube.com/embed/',$Componenet['UrlVideo']);
										$linksave = $linksave[1];
									}

									$VideoComponenet = new YtVideoComponents(['PostBlogID'=>$postBlogModel->PostBlogID, 
																				'PostBlogCenterComponentID' => $Center->PostBlogCenterComponentID
																			]);

									$VideoComponenet->UrlVideo = "https://www.youtube.com/embed/".$linksave;

									if(!$VideoComponenet->Save()){
										var_dump($VideoComponenet->getErrors());
										exit();
										Yii::$app->session->setFlash('error', "Ocurrio un error al guardar el artículo intente nuevamete.");
							              $transaction->rollBack();
							              return $this->refresh();
									}
								}
								break;
							default:
								# code...
								break;
						} 
					}

					Yii::$app->session->setFlash('success', "Artículo guardado correctamente");
	              	$transaction->commit();
	              	$this->deleteAllFile($dirUserTemp,'temp.txt');
	              	$this->deleteAllFile($dirUserTempCarousel,'temp.txt');

					CollectionByPost::deleteAll(['PostBlogID' => $postBlogModel->PostBlogID]);
					BlogByProject::deleteAll(['PostBlogID' => $postBlogModel->PostBlogID]);
					
					if($data['CbyB']->load(Yii::$app->request->post())){	
						foreach($data['CbyB']->CollectionID?:$data['CbyB']->Labels as $CID){
							$cbp = new CollectionByPost();
							$cbp->PostBlogID = $postBlogModel->PostBlogID;
							$cbp->CollectionID = $CID;
							$cbp->save();
						}
					}

					if($data['Project']->load(Yii::$app->request->post())){	
						foreach($data['Project']->Project ?: [] as $PJ){
							$prjct = new BlogByProject();
							$prjct->PostBlogID = $postBlogModel->PostBlogID;
							$prjct->PorfolioID = $PJ;
							$prjct->save();
						}
					}

	             	return $this->redirect(['/blog']);


				} catch (Exception $e) {
						var_dump($e); exit();
					  Yii::$app->session->setFlash('error', "Ocurrio un error inesperado intente nuevamete.");
		              $transaction->rollBack();
		              return $this->refresh();
				}				
			}

			$data['ModelBlog']->VTitle = $data['ModelBlog']->Title;
			$data['Components'] = $data['ModelBlog']->centerComponents ?: [];

			return $this->render('postform', $data);

		}

		public function actionDeletepts($id){

			$UserData =  Yii::$app->AccessControl->Verify([1]);

			$model = PostBlog::findOne($id);

			if($model->delete()){
				Yii::$app->session->setFlash('success', "Artículo eliminado");
				return Yii::$app->response->redirect(['blog']);
			}
			
		}

		public function actionMassiveDelete(){
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

			try {
				$UserData =  Yii::$app->AccessControl->Verify([1]);

				$ids = Yii::$app->request->post('ids', []);

				if(empty($ids) || !is_array($ids)){
					return ['success' => false, 'error' => 'No se recibieron IDs válidos.'];
				}

				$ids = array_map('intval', $ids);
				$count = PostBlog::deleteAll(['PostBlogID' => $ids]);

				return ['success' => true, 'deleted' => $count, 'message' => "$count artículo(s) eliminado(s)."];
			} catch (\Exception $e) {
				return ['success' => false, 'error' => 'Error: ' . $e->getMessage()];
			}
		}

		public function actionCategory(){
            $UserData =  Yii::$app->AccessControl->Verify([1]);

            $data = [];
			$this->layout = $UserData->getLayout();

			$infoUs = Yii::$app->LocationLang->info();
			$data['lang'] = $infoUs->language->LanguageCode;

            $data['model'] = new Collections;
            $model = Collections::find()->select(["*", "Name" . ucfirst($data['lang']) . " AS Name"]);

			$data['dataProvider']  = new ActiveDataProvider([
			    'query' => $model,
			    'pagination' => [
			        'pageSize' => 10,
			    ],
			]);

	            return $this->render('category', [
				'dataProvider' => $data['dataProvider'],
				'model' => $data['model'],
				'lang' => $data['lang'],
			]);
        }

        public function actionAccioncategory() {
        	$UserData =  Yii::$app->AccessControl->Verify([1]);

			$idiomas = ['Es', 'En', 'Pt', 'It', 'Fr', 'De'];

			$infoUs = Yii::$app->LocationLang->info();
			$data['lang'] = $infoUs->language->LanguageCode;
			$translate = Yii::$app->Translate;

			$model = empty(Yii::$app->request->post('Collections')['CollectionID']) ? new Collections : Collections::findOne(Yii::$app->request->post('Collections')['CollectionID']);
		
				
            if($model->load(Yii::$app->request->post())){

				if(empty(Yii::$app->request->post('Collections')['CollectionID'])){
					$pc = Collections::find()->select(['PositionColle'])->orderBy(['CollectionID' => SORT_DESC])->one();
					$model->PositionColle = ($pc->PositionColle + 1);
				}
					
				for($i=0; $i <6 ; $i++) { 
					$Name = 'Name'.$idiomas[$i];

					$nameText = ($idiomas[$i] == $data['lang']) ? $model->Name : $translate->translate($model->Name, ['TargetLG' => $idiomas[$i]])->text;
					$model->$Name = $nameText;
				}

                if ($model->save()){
                    Yii::$app->session->setFlash('success', "Categoría guardado correctamente..");
                    return $this->redirect(['category']);
                }else{
                    Yii::$app->session->setFlash('error', "There was an error while saving the role.");
                    $this->redirect(['category']);
                } 	
            }
        }

        public function actionEcategory(){
    		$UserData =  Yii::$app->AccessControl->Verify([1]);


			$infoUs = Yii::$app->LocationLang->info();
			$data['lang'] = $infoUs->language->LanguageCode;

			$id = $_POST['id'];

			$dataRole = Collections::find()->select(["*", "Name" . ucfirst($data['lang']) . " AS Name"])->where(['CollectionID' => $id])->one();
			$data['CollectionID'] = $dataRole->CollectionID;
			$data['Name'] = $dataRole->Name;
			echo json_encode($data);
		}

        public function actionDcategory($id) {
        	$UserData =  Yii::$app->AccessControl->Verify([1]);
			$id = Collections::findOne($id);
			$transaction = \Yii::$app->db->beginTransaction();
			try {
				if($id->delete()){
					$transaction->commit();
					Yii::$app->session->setFlash('success', "Categoría eliminada.");
					$this->redirect(['category']);
				}else{
					Yii::$app->session->setFlash('error', "There was an error.");
					$transaction->rollBack();
					$this->redirect(['category']);
				}
			} catch (Exception $e) {
				Yii::$app->session->setFlash('error', "There was an error.");
				$transaction->rollBack();
				$this->redirect(['category']);	
			}	
		}

	}