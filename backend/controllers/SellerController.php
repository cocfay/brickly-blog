<?php 
	namespace backend\controllers;

	use Yii;
	use yii\helpers\Url;
	use yii\db\Expression;

	use yii\web\Controller;
    use common\components\ValidUsers;
    use common\models\FormSeller;
    use common\models\FormSellerAnexos;
    use common\models\Countries;
    use yii\helpers\ArrayHelper;

	class SellerController extends Controller{

		public function actionIndex(){	

			$data['UserData'] = $UserData =  Yii::$app->AccessControl->Verify();

            $data = [];
            
			$this->layout = 'sellerLayout';

            $infoUs = Yii::$app->LocationLang->info();
			$lang = $data['lang'] = $infoUs->language->LanguageCode;

			$nameC = $lang == 'es' ? 'Name' : 'Name_en';
			$contryList = Countries::find()->select(['*', $nameC.' AS Name'])->orderBy([$nameC => SORT_ASC])->all();
			$cc = Countries::find()->select(['CountryID'])->where(['Abbreviation' => $infoUs->country_code])->one();
			$data['contryList'] = ArrayHelper::map($contryList, 'CountryID', 'Name');
			$data['countryCode'] = $cc->CountryID;
			
            $data['model'] = new FormSeller();

            if($data['model']->load(Yii::$app->request->post())){
                if($data['model']->validate()){
                    $data['model']->CountryID = $data['model']->Country;
                    $data['model']->AccountID = $UserData->AccountID;
                    //var_dump(array_merge($data['model']->Expe, [1, ''])); 
                    //var_dump($data['model']->Source);
                    //var_dump($data['model']->Language);
                    //exit;
                    if($data['model']->save()){
                        if(count($data['model']->Expe) > 0){
                            foreach ($data['model']->Expe as $key => $value) {
                                $e = new FormSellerAnexos();
                                $e->Text = $value;
                                $e->Type = 1;
                                $e->FormSellerID = $data['model']->FormSellerID;
                                $e->save();
                            }
                        }
                        if(count($data['model']->Source) > 0){
                            foreach ($data['model']->Source as $key => $value) {
                                $s = new FormSellerAnexos();
                                $s->Text = $value;
                                $s->Type = 2;
                                $s->FormSellerID = $data['model']->FormSellerID;
                                $s->save();
                            }
                        }
                        if(count($data['model']->Language) > 0){
                            foreach ($data['model']->Language as $key => $value) {
                                $l = new FormSellerAnexos();
                                $l->Text = $value;
                                $l->Type = 3;
                                $l->FormSellerID = $data['model']->FormSellerID;
                                $l->save();
                            }
                        }
                        Yii::$app->session->setFlash('success', "Datos enviados exitosamente.");
                        //return $this->refresh();
                        return $this->redirect('/');
                    }else{
                        var_dump($data['model']->getErrors()); 
                        exit;
                    }
                }
            }

            return $this->render('index', $data);
        }

    }
    
?>