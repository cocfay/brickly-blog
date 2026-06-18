<?php 
	namespace backend\controllers;

	use Yii;
	use yii\web\Controller;
	use yii\helpers\ArrayHelper;
    use yii\data\ActiveDataProvider;
    use yii\web\UploadedFile;
    use yii\helpers\Url;
    use common\models\Porfolio;
    use common\models\SoftCanned;

	class SoftcannedController extends Controller{

        public function actionIndex(){
            $UserData =  Yii::$app->AccessControl->Verify();
            $this->layout = $UserData->getLayout();
    
            $data = [];
    
            $model = Porfolio::findBySql("SELECT * FROM Porfolio INNER JOIN SoftCanned ON Porfolio.PorfolioID = SoftCanned.PorfolioID");
    
            $data['dataProvider']  = new ActiveDataProvider([
                'query' => $model,
                'pagination' => [
                    'pageSize' => 5,
                ],
            ]);
    
            return $this->render('index', $data);
        }

        public function actionAdd(){
            $UserData =  Yii::$app->AccessControl->Verify();

            $data = [];
			$this->layout = $UserData->getLayout();

            $data['ListTitle'] = ArrayHelper::map(Porfolio::findBySql("SELECT p.* FROM Porfolio p LEFT JOIN SoftCanned sc ON p.PorfolioID = sc.PorfolioID WHERE sc.PorfolioID IS NULL ORDER BY Title")->all(), 'PorfolioID', 'Title');
            $data['model'] = new SoftCanned();

            if($data['model']->load(Yii::$app->request->post()) && $data['model']->validate()){
                if($data['model']->save()){
                    Yii::$app->session->setFlash('success', 'Proyecto agregado a software enlatado.');
                    return $this->refresh();
                }
            }

            return $this->render('crear', $data);
        }

        public function actionUpdate($id){
            $UserData =  Yii::$app->AccessControl->Verify();

            $data = [];
			$this->layout = $UserData->getLayout();

            $consulta = SoftCanned::find()->where(['PorfolioID' => $id])->one();
            $data['model'] = SoftCanned::findOne($consulta->SocannedID);

            if($data['model']->load(Yii::$app->request->post()) && $data['model']->validate()){
                if($data['model']->save()){
                    Yii::$app->session->setFlash('success', 'Modificado exitosamente.');
                    return $this->refresh();
                }
            }

            return $this->render('update', $data);
        }

        public function actionDelete($id){

            $consulta = SoftCanned::find()->where(['PorfolioID' => $id])->one();
            $model = SoftCanned::findOne($consulta->SocannedID);

            if($model->delete()){
                Yii::$app->session->setFlash('success', 'Eliminado correctamente.');
                return $this->redirect(['softcanned/index']);
            }
            
        }
    }