<?php 
	namespace backend\controllers;

	use Yii;
	use yii\helpers\Url;
	use yii\db\Expression;

	use yii\web\Controller;
    use common\components\ValidUsers;
    use yii\data\ActiveDataProvider;
    //use common\models\Countries;
    use common\models\Hook;
    use yii\helpers\ArrayHelper;

	class VideosController extends Controller{

		public function actionIndex(){	
            $data['UserData'] = $UserData =  Yii::$app->AccessControl->Verify();
            $data = [];
            
			$this->layout = $UserData->getLayout();

        }

        public function actionHook(){
            $data['UserData'] = $UserData =  Yii::$app->AccessControl->Verify();
            $data = [];
            
			$this->layout = $UserData->getLayout();

            $sql = Hook::find();

            $data['model'] = new Hook;

            $data['dataProvider']  = new ActiveDataProvider([
				'query' => $sql,
				'pagination' => [
					'pageSize' => 8,
				],
			]);

            if($data['model']->load(Yii::$app->request->post())){
                if($data['model']->validate()){
                    if($data['model']->save()){
                        Yii::$app->session->setFlash('success', 'Datos insertados correctamente.');
                        return $this->refresh();
                    }else{
                        Yii::$app->session->setFlash('error', 'Error al guardar.');
                    }

                }
            }
            
            return $this->render('hook', $data);
        }

        public function actionDeleteHook($id){
            Yii::$app->AccessControl->Verify();

            $model = Hook::findOne($id);
            
            if($model->delete())
                Yii::$app->session->setFlash('success', 'Datos eliminado correctamente.');
            
            return $this->redirect(['videos/hook']);
            
        }

        public function actionGetDataHook(){
            Yii::$app->AccessControl->Verify();

            $model = Hook::findOne($_POST['id']);
            $data = ['name' => $model->Name];
            echo json_encode($data);
        }

        public function actionUpdateHook(){
            Yii::$app->AccessControl->Verify();

            $data = Yii::$app->request->post('Hook');

            $model = Hook::findOne($data['HookID']);
            $model->Name = $data['Name'];

            if($model->save())
                Yii::$app->session->setFlash('success', 'Datos actualizados correctamente.');
            else
                Yii::$app->session->setFlash('success', 'Error al actualizar.');
            
            return $this->redirect(['videos/hook']);
        }
    
    }