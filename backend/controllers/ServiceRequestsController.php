<?php 
	namespace backend\controllers;

	use Yii;
	use yii\web\Controller;
	use yii\helpers\ArrayHelper;
    use yii\data\ActiveDataProvider;
    use yii\web\UploadedFile;
    use yii\helpers\Url;
    use common\models\Services;
    use common\models\RequestServiceClient;

	class ServiceRequestsController extends Controller{

		public function actionIndex($id){
            $UserData =  Yii::$app->AccessControl->Verify();

            $data = [];
			$this->layout = $UserData->getLayout();

            $model = RequestServiceClient::find()->where(['ServiceID' => $id])->orderBy(['Status' => SORT_ASC]);
    
            $data['dataProvider']  = new ActiveDataProvider([
				'query' => $model,
				'pagination' => [
					'pageSize' => 8,
				],
			]);

            $ns = $model->one();

            $service = Services::findOne($id);
            $data['NameService'] = $service->Name;

            return $this->render('index', $data);
        }

        public function actionInfoService(){
            $model = RequestServiceClient::find()->where(['RequestServiceClientID' => $_POST['id']])->one();
     
            $items = ['description' => $model->Description, 'status' => $model->Status, 'options' => []];
            for($n = 1 ; $n <= 6 ; $n++){

                $check = "Check{$n}";

                if(!is_null($model->$check) && $model->$check !== "0"){
                    $items['options'][] = $model->$check;
                }
            }

            echo json_encode($items);

        }

        public function actionStatus(){
            $UserData =  Yii::$app->AccessControl->Verify();
           
            //$data = [];
			$this->layout = false;

            $model = RequestServiceClient::findOne($_POST['id']);
            $model->Status = 1;

            if($model->save()){
                Yii::$app->session->setFlash('success', "Estado cambiado correctamente");
            }else{
                Yii::$app->session->setFlash('error', "No se pudo cambiar el estado");
            }

            //return $this->redirect(['/service-requests']);
            return $this->redirect(Yii::$app->request->referrer);
        }
    }