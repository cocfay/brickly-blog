<?php

	namespace backend\controllers;

	use Yii;
	use yii\web\Controller;
    use common\components\ValidUsers;

	use yii\filters\VerbFilter;
    use yii\helpers\ArrayHelper;
    use yii\helpers\Url;
	use yii\web\NotFoundHttpException;
	use yii\web\Response;

	use common\models\Promotions;
    use yii\data\ActiveDataProvider;
    use yii\web\UploadedFile;

	class PromotionController extends Controller{

        
        public function actionIndex(){

            $UserData =  Yii::$app->AccessControl->Verify([1]);
            // 1 = Users Admin
            // 2 = Users moderador
            $data = [];
            $this->layout = $UserData->getLayout();

            $data['model'] = new Promotions;
            $query = Promotions::find()->orderBy(['Visible' => SORT_DESC]);

            $data['dataProvider']  = new ActiveDataProvider([
                    'query' => $query,
                    'pagination' => [
                        'pageSize' => 20,
                    ],
                ]);
            

            // $data['searchModel'] = $searchModel = new Menu();
            // $data['dataProvider'] = $dataProvider = Menu::find()->all();

            return $this->render('index', $data);
        }

        public function actionPromoaction(){
            $UserData =  Yii::$app->AccessControl->Verify([1]);
            $post = Yii::$app->request->post('Promotions');

            $model = empty($post['PromotionsID']) ? new Promotions : Promotions::findOne($post['PromotionsID']);
            $msg = empty($post['PromotionsID']) ? 'Datos guardado correctamente.' : 'Datos editados correctamente.';
            if($model->load(Yii::$app->request->post())){
                if(!empty($post['PromotionsID'])){
                    if($post['Visible'] == 1){
                        Promotions::updateAll(['Visible' => 0]);
                    }

                    $model->Text = str_replace('<p>', '<p style="margin-bottom: 0;">', $post['Text']);
                    $model->Visible = $post['Visible'];
                }else{
                    if($model->Visible == 1){
                        Promotions::updateAll(['Visible' => 0]);
                    }
                    
                    $model->Text = str_replace('<p>', '<p style="margin-bottom: 0;">', $post['Text']);
                }

                $model->FileNewsletter = UploadedFile::getInstance($model, 'FileNewsletter');
                if ($model->FileNewsletter && $model->validate()) {
                    $bName =  str_replace(' ', '_' ,$model->FileNewsletter->baseName) . '.' . $model->FileNewsletter->extension;
                    $filePath = \Yii::getAlias('@proyectroot/_promotions/newsletters/') .$bName;
                    $model->FileNewsletter->saveAs($filePath);
                    $model->ImageNewsLetter =Url::to('@raizweb',true).'/_promotions/newsletters/'.$bName;
                    $model->FileNewsletter = null;
                }

                if($model->save()){
                    Yii::$app->session->setFlash('success', $msg);
                    $this->redirect(['/promotion/']);
                }
            }
        }
        public function actionRunNewsletter($id){

                
                $promo = Promotions::findOne($id);
                if(!$promo){
                    Yii::$app->session->setFlash('error', 'No se encontro la promoción para enviar los NL');
                    return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
                }

                $urlScript = Url::to('@raizweb',true)."/cpanel/promotion/process-nl?id=".$id;

            

            $promo->StatusShipped = 2;
            if($promo->save()){
                $command = "wget '".$urlScript."' >> /dev/null 2>/dev/null &";
                //  echo $command;
                //  exit();
                $oupt = shell_exec($command);

                Yii::$app->session->setFlash('success', 'El NL esta en proceso de envio.');
                return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
            }else{
                Yii::$app->session->setFlash('error', 'No se pudo realizar el envio');
                return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);

            }
         }

          public function actionProcessNl($id){
                $this->layout = false;
                ignore_user_abort(true);
                set_time_limit(0);
                sleep(20);
                 $promo = Promotions::findOne($id);

                $Clients = \common\models\UserAccount::find()->where(['TypeUser' => 2])->all();
                $data = [
                    'image' => $promo->ImageNewsLetter,
                    'description' => $promo->DescriptionNewsletter,
                    'pretext' => $promo->Text
                ];
                $html = $this->renderPartial('html-nl',$data);
               
                foreach($Clients as $client){
                        Yii::$app->mailer->compose()
                        ->setFrom(['noreply@weclickdigital.com' => 'Weclick Newsletter'])
                        ->setTo($client->Email)
                        ->setSubject($promo->SubjectNewsLetter)
                        ->setHtmlBody($html)
                        ->send();

                }
                $promo->StatusShipped = 1;
                $promo->save();
                echo "Complete";
                exit();
          }

        public function actionAjaxpromoval(){
            $UserData =  Yii::$app->AccessControl->Verify([1]);
            $id = $_POST['id'];
            $datapromo = Promotions::findOne($id);
            $data['PromotionID'] = $datapromo->PromotionsID;
            $data['Text'] = $datapromo->Text;
            $data['Visible'] = $datapromo->Visible;

            $data['ImageNewsLetter'] = $datapromo->ImageNewsLetter;

            $data['SubjectNewsLetter'] = $datapromo->SubjectNewsLetter;

            $data['DescriptionNewsletter'] = $datapromo->DescriptionNewsletter;

            $data['isShipped'] = $datapromo->isShipped;

            echo json_encode($data);
        }

        public function actionDeletepromo($id){
            $UserData =  Yii::$app->AccessControl->Verify([1]);
            $model = Promotions::findOne($id);
            if($model->delete()){
                Yii::$app->session->setFlash('success', 'Promoción eliminada');
                $this->redirect(['/promotion/']);
            }
        }

    }