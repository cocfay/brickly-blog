<?php 
	/* namespace backend\controllers;
    
	use Yii;
	use yii\web\Controller;
	use yii\filters\VerbFilter;
	use yii\filters\AccessControl;

	use common\models\Account;
	use common\models\UserAccount;
    use backend\models\Email;
	use common\components\ValidUsers;
	use yii\helpers\ArrayHelper;
	use yii\helpers\Url;
	use yii\data\ActiveDataProvider;
	use yii\db\Expression;
    use yii\web\Response;

    
	class EmailController extends Controller{

        public function actionIndex(){

            $UserData =  Yii::$app->AccessControl->Verify([1]);
            // 1 = Users Admin
            // 2 = Users moderador
            // Verificar en tabla TypeUsers
            $data = [];
            $this->layout = $UserData->getLayout();
            $data['model'] = new Email();

            if(isset(Yii::$app->request->post()['Email']['EmailID'])){
                $data['model'] =  Email::findOne(Yii::$app->request->post()['Email']['EmailID']);
            }

            if($data['model']->load(Yii::$app->request->post())){
                if($data['model']->save()){
                    Yii::$app->session->setFlash('success','Información registrada corectamente.');
                    return $this->refresh();
                }else{
                    
                    Yii::$app->session->setFlash('error','Ha ocurrido un error y no se pudo actualizar la información');
                    return $this->refresh();
                }

            }

            $projects = Email::find();

            $data['ProjectsProvider']  = new ActiveDataProvider([
                'query' => $projects,
                'pagination' => [
                    'pageSize' => 20,
                ],
            ]);   

            
            return $this->render('index', $data);

        }

        public function actionGetDataAjax(){
            $UserData =  Yii::$app->AccessControl->Verify([1]);

            $this->layout = false;

            $query = Email::find()->where(['EmailID' => $_POST['id']])->asArray()->one();
            echo json_encode($query);
        }

        public function actionDelete($id){
            $UserData =  Yii::$app->AccessControl->Verify([1]);

            $this->layout = false;

            $model = Email::findOne($id);
            
            if($model->delete()){
                Yii::$app->session->setFlash('success','Datos elimados corectamente.');
                return $this->redirect(Yii::$app->request->referrer);
            }
        }
    
    } */