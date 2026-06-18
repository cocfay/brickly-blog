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
			// if(yii::$app->params['CounterPlatform'] > 0 ){
			// 	$this->redirect(Yii::$app->urlManager->createUrl('/'));
			// }
    	}

		public function actionIndex(){	

			$UserData =  Yii::$app->AccessControl->Verify([1]);

            $data = [];
			$this->layout = $UserData->getLayout();

			$infoUs = Yii::$app->LocationLang->info();

			$model = PostBlog::find()->where(['Verified' => 1, 'Featured' => 0])->orderBy(['PostBlogID' => SORT_DESC]);
			$data['dataProvider']  = new ActiveDataProvider([
			    'query' => $model,
			    'pagination' => [
			        'pageSize' => 10,
			    ],
			]);

			return $this->render('index', $data);
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

			return $this->render('tendencia', $data);
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
			
			$langs = ['es','en'];
			//$idiomas = ['Es', 'En', 'Pt', 'It', 'Fr', 'De'];
			$infoUs = Yii::$app->LocationLang->info();
			$langInUse = $data['lang'] = $infoUs->language->LanguageCode;

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

				$postBlogModel->CreateAT = $postBlogModel->CreateAT . ' ' . date("H:i:s");
				/* if(!isset(Yii::$app->request->post()['PostBlog']['CollectionID'])){
					$postBlogModel->CollectionID = new \yii\db\Expression('NULL');
				} */


				$translate = Yii::$app->Translate;
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
								Yii::$app->session->setFlash('success', "Post eliminado correctamente");
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
				              	Yii::$app->session->setFlash('error', "Ocurrio un error al eliminar el Post intente nuevamete.");
					            $transaction->rollBack();
					            return $this->refresh();
				              }
							break;
						
						default:
							Yii::$app->session->setFlash('error', "Ocurrio un error al guardar el Post intente nuevamete.");
				              $transaction->rollBack();
				              return $this->refresh();
							break;
					}
					


					$postBlogModel->RequestFile  = UploadedFile::getInstance($postBlogModel, 'RequestFile');
					$postBlogModel->AccountID = $UserData->AccountID;
					if($postBlogModel->RequestFile != null){
						$NameImageExtractP = explode('/post/', $postBlogModel->ImagePost);
						if(isset($NameImageExtractP[1])){
							$unlinkImage[] =  $fPath.'/post/'.$NameImageExtractP[1];
						}
						$upload = $postBlogModel->upload();
					}



					if(!$postBlogModel->save()){

						var_dump($postBlogModel->getErrors());
						exit();
						Yii::$app->session->setFlash('error', "Ocurrio un error al guardar el Post intente nuevamete.");
			              $transaction->rollBack();
			              return $this->refresh();
					}



					foreach ($langs as $key => $LangTarget) {
						$modelPostBlogTitle = new PostBlogTitle();
						$modelPostBlogTitle->PostBlogID = $postBlogModel->PostBlogID;
						if(strtoupper($langInUse) == strtoupper($LangTarget)){
							$modelPostBlogTitle->Data = $postBlogModel->VTitle;
						}else{
							$modelPostBlogTitle->Data = $translate->translate($postBlogModel->VTitle ,['TargetLG'=>$LangTarget])->text;
						}
						$modelPostBlogTitle->Lang = $LangTarget;
						if(!$modelPostBlogTitle->save()){
							var_dump($modelPostBlogTitle->getErrors());
							exit();
							Yii::$app->session->setFlash('error', "Ocurrio un error al guardar el Post intente nuevamete.");
				              $transaction->rollBack();
				              return $this->refresh();
						}
					}

					$Components = isset(Yii::$app->request->post()['Components'])? Yii::$app->request->post()['Components'] : false;
					if(!$Components){
						Yii::$app->session->setFlash('error', "Debe incluir como minimo 1 componente para generar un Post.");
		             	$transaction->rollBack();
		             	return $this->refresh();
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
										Yii::$app->session->setFlash('error', "Ocurrio un error al guardar el Post intente nuevamete.");
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
										Yii::$app->session->setFlash('error', "Ocurrio un error al guardar el Post intente nuevamete.");
							              $transaction->rollBack();
							              return $this->refresh();
									}
									foreach ($langs as $key => $LangTarget) {
										$TexBoxDataModel = new TextBoxComponentsData();
										if(strtoupper($langInUse) == strtoupper($LangTarget)){
											$TexBoxDataModel->Data = $Componenet['TextBox'];
											$TexBoxDataModel->DataMovil = $Componenet['MovilTextBox'];

										}{
											$TexBoxDataModel->Data = $translate->translate($Componenet['TextBox'] ,['TargetLG'=>$LangTarget])->text;
											$TexBoxDataModel->DataMovil = $translate->translate($Componenet['MovilTextBox'] ,['TargetLG'=>$LangTarget])->text;
										}
										$TexBoxDataModel->Lang = $LangTarget;
										$TexBoxDataModel->TexBoxComponentID = $TextComponent->TexBoxComponentID;
										if(!$TexBoxDataModel->save()){
											var_dump($TexBoxDataModel->getErrors());
											exit();
											Yii::$app->session->setFlash('error', "Ocurrio un error al guardar el Post intente nuevamete.");
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
										Yii::$app->session->setFlash('error', "Ocurrio un error al guardar el Post intente nuevamete.");
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
										Yii::$app->session->setFlash('error', "Ocurrio un error al guardar el Post intente nuevamete.");
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
													$ImagenDescriptComp->Data = $translate->translate($Componenet['Description'] ,['TargetLG'=>$LangTarget])->text;
												}
												if(!empty($Componenet['MovilDescription'])){
													$ImagenDescriptComp->DataMovil = $translate->translate($Componenet['MovilDescription'] ,['TargetLG'=>$LangTarget])->text;
												}
												if(!empty($Componenet['ImageBy'])){
													$ImagenDescriptComp->ImageBy = $translate->translate($Componenet['ImageBy'],['TargetLG'=>$LangTarget])->text;
												}

											}
											$ImagenDescriptComp->Lang = $LangTarget;
											$ImagenDescriptComp->ImageComponentID = $ImageComponenet->ImageComponentID;
											if(!$ImagenDescriptComp->save()){
												var_dump($ImagenDescriptComp->getErrors());
												exit();
												Yii::$app->session->setFlash('error', "Ocurrio un error al guardar el Post intente nuevamete.");
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
										Yii::$app->session->setFlash('error', "Ocurrio un error al guardar el Post intente nuevamete.");
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
										Yii::$app->session->setFlash('error', "Ocurrio un error al guardar el Post intente nuevamete.");
							              $transaction->rollBack();
							              return $this->refresh();
									}
								}
								break;
							/* case '4':
								if(count($Componenet['Image']) > 0 ){

									$Center->Type = 4;
									if(!$Center->Save()){
										var_dump($Center->getErrors());
										exit();
										Yii::$app->session->setFlash('error', "Ocurrio un error al guardar el Post intente nuevamete.");
							              $transaction->rollBack();
							              return $this->refresh();
									}

									$user = $UserData;
									
									$CarouselComponent = new CarouselComponents(['PostBlogID'=>$postBlogModel->PostBlogID, 
                                    'PostBlogCenterComponentID' => $Center->PostBlogCenterComponentID
                                    ]);

									if(!$CarouselComponent->Save()){
										var_dump($CarouselComponent->getErrors());
										exit();
										Yii::$app->session->setFlash('error', "Ocurrio un error al guardar el Post intente nuevamete.");
							              $transaction->rollBack();
							              return $this->refresh();
									}

									// var_dump($Componenet['Image']);
									// exit();
									foreach ($Componenet['Image'] as $it) {

										$modelImagesCarousel = new CarouselComponentsImages;
										$NameFileTemp = $it;

										// echo "<br>".$NameFileTemp;
										// continue;
										$modelImagesCarousel->CarouselComponentID = $CarouselComponent->CarouselComponentID;

										if(preg_match('/\/BlogPostImages\//', $NameFileTemp)){
											$modelImagesCarousel->ImagePatch = $NameFileTemp;

											$explDName = explode('/'.$UserData->AccountID.'/carousel/', $NameFileTemp);
											$dirSearch = $dirUserCarousel.$explDName[1];
											$indexDeleteImage = array_search($dirSearch, $unlinkImage);
											if($indexDeleteImage || $indexDeleteImage === 0){
												unset($unlinkImage[$indexDeleteImage]);
											}

										}else{
											$modelImagesCarousel->ImagePatch = Url::to(['/']).'images/BlogPostImages/'.$user->AccountID.'/carousel/'.$NameFileTemp;
										}

										if(!$modelImagesCarousel->save()){
											var_dump($modelImagesCarousel->getErrors());
											exit();
											Yii::$app->session->setFlash('error', "Ocurrio un error al guardar el Post intente nuevamete.");
								              $transaction->rollBack();
								              return $this->refresh();
										}

										if(file_exists($dirUserTempCarousel.$NameFileTemp)){
											rename($dirUserTempCarousel.$NameFileTemp, $dirUserCarousel.$NameFileTemp);
										}

									}
									// exit();

								}
								
								break; */
							default:
								# code...
								break;
						} 
					}

					Yii::$app->session->setFlash('success', "Post Guardado corectamente");
	              	$transaction->commit();
	              	$this->deleteAllFile($dirUserTemp,'temp.txt');
	              	$this->deleteAllFile($dirUserTempCarousel,'temp.txt');

	              	// foreach ($unlinkImage as $key => $unlinkroute) {
	              	// 	if(file_exists($unlinkroute)){
	              	// 		if(is_dir($unlinkroute)){
					//           //  deleteAll($file);
					//         }else{
					//             unlink($unlinkroute);
					//     	}
	              	// 	}
	              	// }

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
						foreach($data['Project']->Project as $PJ){
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
			// var_dump($data['ModelBlog']->centerComponents);exit();
			// foreach ($data['Components'] as $k => $c):
			// 		var_dump($c->Type); exit();
			// endforeach;

			return $this->render('postform', $data);

		}


		/* public function actionGetCollectionList($id){
			$this->layout = false;
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			$compareCollection = CollectionsPrimary::findOne($id);
			$Rtn = ['error' => true, 'data'=>''];
			if($compareCollection){

				if($compareCollection->CollectionPrimaryID == 1){
					$Elems = Collections::find()->where(['Display' => 1])->orderBy(['CollectionID' => SORT_ASC])->all();
					$html = '<option value>Seleccione una colección</option>';
					foreach(ArrayHelper::map($Elems, 'CollectionID', 'Name') as  $k => $v):
						$html .= "<option value='{$k}'>{$v}</option>";
					endforeach;

					$Rtn['data'] = $html;
					$Rtn['error'] = false;
				}else{

					$Rtn['error'] = true;
					$Rtn['data'] = '';
				}


			}

			return $Rtn;
			


		} */

		/* public function actionPost($id)
		{	

			if(!Yii::$app->user->isGuest)
				$UserData =  Yii::$app->AccessControl->Verify();

			$this->layout = "/lead";
			$data = [];

			$infoUs = Yii::$app->LocationLang->info();

			$data['lang'] = $infoUs->language->LanguageCode;
			$blogTranslate = ['es' => '', 'en' => 2, 'pt' => 3, 'it' => 4, 'fr' => 5, 'de' => 6]; 
			$idiomas = ['es', 'en', 'pt', 'it', 'fr', 'de'];
			//$coll = Collections::find()->where(['CollectionID' => '1'])->all();
			//$collp = CollectionsPrimary::find()->select(["CollectionPrimaryID", "NameCp".strtoupper($infoUs->language->LanguageCode) . " AS NameCp"])->where(['DisplayCp' => '1'])->all();

			$data['model'] = PostBlog::find()->where(['PostBlogID' => $id])->orderBy(['PostBlogID' => SORT_DESC])->one();
			$data['model']->VTitle = $data['model']->Title;
			$data['Components'] = $data['model']->centerComponents ?: [];

			// ######################################################################################################################### 

			$seed = rand();
			$data['more'] = PostBlog::find()->where(['!=', 'PostBlogID', $id])->andWhere(['Verified' => 1])->orderBy(new Expression('RAND(' . $seed . ')'))->limit(3)->all();

			// ######################################################################################################################### 

			$data['ModelBlogComment'] = new BlogComments;
			if($data['ModelBlogComment']->load(Yii::$app->request->post()) && !Yii::$app->user->isGuest){
				$data['ModelBlogComment']->PublicationDate = date('Y-m-d H:i:s',  time()); 
				$data['ModelBlogComment']->PostBlogID = $id;
				$data['ModelBlogComment']->AccountID = $UserData->AccountID;
					$translate = Yii::$app->Translate;
					for ($i=0; $i <6 ; $i++) { 			
						$Content='Content_'.$idiomas[$i];
						$conText = ($idiomas[$i] == $data['lang']) ? $data['ModelBlogComment']->Content : $translate->translate($data['ModelBlogComment']->Content, ['TargetLG' => $idiomas[$i]])->text;
						$data['ModelBlogComment']->$Content = $conText;
					}
				if ($data['ModelBlogComment']->save()) {
					return $this->refresh();
				}
			}
			$data['ModelBlogSubComment'] = new BlogSubComment;
				if($data['ModelBlogSubComment']->load(Yii::$app->request->post()) && !Yii::$app->user->isGuest){
					$data['ModelBlogSubComment']->CreateDate = date('Y-m-d H:i:s',  time()); 
					$data['ModelBlogSubComment']->AccountID = $UserData->AccountID;
						$translate = Yii::$app->Translate;
					for ($i=0; $i <6 ; $i++) { 
						$Content='Content_'.$idiomas[$i];
						$conText = ($idiomas[$i] == $data['lang']) ? $data['ModelBlogSubComment']->Content : $translate->translate($data['ModelBlogSubComment']->Content, ['TargetLG' => $idiomas[$i]])->text;
						$data['ModelBlogSubComment']->$Content = $conText;
					}
						if ($data['ModelBlogSubComment']->save()) {
						return $this->refresh();
				}
			}

			return $this->render('post', array_merge($data, ['collp' => $collp]));
		} */

		/* public function actionMyposts(){
			$UserData =  Yii::$app->AccessControl->Verify();
			$roles = $UserData->userByRoles;

			if(count($roles) == 1 && $roles[0]->role->RoleID == 3)
				return Yii::$app->response->redirect(['/']);
			else{
				$data = [];
				$this->layout = "/lead";

				$infoUs = Yii::$app->LocationLang->info();
				
				$data['lang'] = $infoUs->language->LanguageCode;

				$data['result'] = PostBlog::find()
				->where(['AccountID' => $UserData->AccountID])
				->orderBy(['PostBlogID' => SORT_DESC])
				->all();

				return $this->render('myposts', $data);
			}
		} */

		/* public function actionEditpost($id){
			$UserData =  Yii::$app->AccessControl->Verify();

			$infoUs = Yii::$app->LocationLang->info();
			$data['lang'] = $infoUs->language->LanguageCode;

			$translate = Yii::$app->Translate;
			
			$data = [];
			$this->layout = "/lead";

			$roles = $UserData->userByRoles;

			$BlogPost = Blog::findOne($id);

			if($BlogPost->AccountID == $UserData->AccountID){
				if(count($roles) == 1 && $roles[0]->role->RoleID == 3)
					return Yii::$app->response->redirect(['blog']);
				else{

					$idiomas = ['es', 'en', 'fr', 'it', 'pt', 'de'];

					$data['ModelBlog'] = Blog::findOne($id);
				
					$colecciones = Collections::find()
					->where(['Display' => '1'])
					->orderBy(['CollectionID' => SORT_ASC])
					->all();
					$data['collectionList'] = ArrayHelper::map($colecciones, 'CollectionID', 'Name');

					$coleccionescp = CollectionsPrimary::find()
					->select(["CollectionPrimaryID", "NameCp".strtoupper($infoUs->language->LanguageCode) . " AS NameCp"])
					->where(['DisplayCp' => '1'])
					->orderBy(['CollectionPrimaryID' => SORT_ASC])
					->all();

					$data['collectionListCp'] = ArrayHelper::map($coleccionescp, 'CollectionPrimaryID', 'NameCp');

					if($data['ModelBlog']->load(Yii::$app->request->post()) && $data['ModelBlog']->validate()){

						$collection = ($data['ModelBlog']->CollectionPrimaryID == 1) ? $data['ModelBlog']->CollectionID : 0;
						$data['ModelBlog']->CollectionID = $collection;


						for($i = 0; $i<=5; $i++){
							$name = ($i > 0) ? "Name".($i + 1) : "Name";
							$description = ($i > 0) ? "Description".($i + 1) : "Description";
							$descriptionMovil = ($i > 0) ? "DescriptionMovil".($i + 1) : "DescriptionMovil";

							$data['ModelBlog']->$name = $translate->translate($data['ModelBlog']->Name, ['TargetLG'=>$idiomas[$i]])->text;
							$data['ModelBlog']->$description = $translate->translate($data['ModelBlog']->Description, ['TargetLG'=>$idiomas[$i]])->text;
							$data['ModelBlog']->$descriptionMovil = $translate->translate($data['ModelBlog']->DescriptionMovil, ['TargetLG'=>$idiomas[$i]])->text;
						}

						$data['ModelBlog']->FrontPhoto = UploadedFile::getInstance($data['ModelBlog'], 'FrontPhoto');

						if($data['ModelBlog']->FrontPhoto != null)
							$upload = $data['ModelBlog']->upload();

						if($data['ModelBlog']->save()){

							$blogDetailsValue = Yii::$app->request->post('BlogDetails');
							if(!is_null($blogDetailsValue)){
								$count = 1;
								for($i = 0 ; $i < count(Yii::$app->request->post('BlogDetails')) ; $i++){

									$DBlog = BlogDetails::findOne(['BlogDetailsID' => $blogDetailsValue[$i]['BlogDetailsID']]);

									for($j = 0; $j<=5; $j++){
										$name = ($j > 0) ? "Name".($j + 1) : "Name";
										$description = ($j > 0) ? "Description".($j + 1) : "Description";
										$descriptionMovil = ($j > 0) ? "DescriptionMovil".($j + 1) : "DescriptionMovil";

										$DBlog->$name = $translate->translate($blogDetailsValue[$i]['Name'], ['TargetLG'=>$idiomas[$j]])->text;
										$DBlog->$description = $translate->translate($blogDetailsValue[$i]['Description'], ['TargetLG'=>$idiomas[$j]])->text;
										$DBlog->$descriptionMovil = $translate->translate($blogDetailsValue[$i]['DescriptionMovil'], ['TargetLG'=>$idiomas[$j]])->text;
									}

									$files = [];
									$name = 'BlogDetails';
									if (isset($_FILES[$name])) {
										foreach ($_FILES[$name]['name'] as $key => $value) {
											if ($value != '') {
												$files[] = [
													'name' => $value,
													'type' => $_FILES[$name]['type'][$key],
													'size' => $_FILES[$name]['size'][$key],
													'tmp_name' => $_FILES[$name]['tmp_name'][$key],
													'error' => $_FILES[$name]['error'][$key],
												];
											}
										}
									}

									if(isset($files[$i])){
										if($files[$i]['type']['Photo'] != ""){
											$extension = explode("/", $files[$i]['type']['Photo']);
											$NameFile = $blogDetailsValue[$i]['Name'] . '-doc-' . substr(md5(uniqid(rand())), 0, 6) . '.' . end($extension);
											if(move_uploaded_file($files[$i]["tmp_name"]['Photo'], Yii::$app->basePath . '/../post/' . $NameFile)) 
												$DBlog->PhotoBDetails = Url::to('@web/post/') . $NameFile;
										}
									}

									$DBlog->save(); 
								}
							}

							Yii::$app->session->setFlash('success', "Datos actualizados con exito");
							return $this->refresh();
						}
					}

					return $this->render('editpost', $data);
				}
			}else{
				return $this->redirect(['my_posts']);
			}
		}
 */
		public function actionDeletepts($id){

			$UserData =  Yii::$app->AccessControl->Verify([1]);

			$model = PostBlog::findOne($id);

			if($model->delete()){
				Yii::$app->session->setFlash('success', "Post Eliminado");
				return Yii::$app->response->redirect(['blog']);
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

            return $this->render('category', $data);
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

		
		/* public function actionApp(){
		    $data = [];
		    $this->layout = false;
		    $data['InternalView'] = $this->render('login',$data);
		    
		    return $this->render('tablet',$data);
		}

		public function actionPrueba(){
			echo print_r($_POST);
		} */

	}