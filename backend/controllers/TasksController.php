<?php 
	namespace backend\controllers;
	use Yii;
	use yii\web\Controller;
	use yii\filters\VerbFilter;
	use yii\filters\AccessControl;

	use common\models\Account;
	use common\models\ProjectsClients;
	use common\models\UserAccount;
    use common\models\ProjectFollowers;
    use common\models\ProjectTasks;
    use common\models\DevelopersWorkTimeTasks;
    use common\models\TaskComments;


	use common\components\ValidUsers;
	use yii\helpers\ArrayHelper;

	use yii\data\ActiveDataProvider;
	use yii\db\Expression;
    use yii\web\UploadedFile;
    use yii\helpers\Url;
	
    date_default_timezone_set('America/Guatemala'); // Ajusta la zona horaria

	class TasksController extends Controller
	{

        public function actionIndex(){
            $UserData =  Yii::$app->AccessControl->Verify([1,5]);
            $this->layout = $UserData->getLayout();

            $data=[];

            $data['UserData'] = $UserData;

            $TasksPendding = ProjectTasks::find()->where(['AccountID' => $UserData->AccountID,'Status' => 0])->orderBy([ 'EstimatedStart'=>SORT_ASC ]);
            $TasksInit = ProjectTasks::find()->where(['AccountID' => $UserData->AccountID,'Status' => 1])->orderBy([ 'EstimatedStart'=>SORT_ASC ]);

            $DateNowC = new \DateTime("now");
            $ToDate = $DateNowC->format('Y-m-d H:i:s');
            $DateNowC->modify("-5 day");
            $FromDate =  $DateNowC->format('Y-m-d H:i:s');
            
            $TasksFinish = ProjectTasks::find()->where(['AccountID' => $UserData->AccountID,'Status' => 2])->andWhere(['between','EndTask',$FromDate,$ToDate])->orderBy([ 'EndTask'=>SORT_DESC ]);

            // SELECT t.* FROM ProjectTasks t INNER JOIN DevelopersWorkTimeTasks dt ON dt.ProjectTaskID = t.ProjectTaskID WHERE dt.EndDate > dt.EndDate AND t.Status = 2 AND AccountID = 207 GROUP BY t.ProjectTaskID

            $data['TasksPenddingProvider']  = new ActiveDataProvider([
                'query' => $TasksPendding,
                'pagination' => [
                    'pageSize' => 20,
                ],
            ]); 

            $data['TasksInitProvider']  = new ActiveDataProvider([
                'query' => $TasksInit,
                'pagination' => [
                    'pageSize' => 20,
                ],
            ]); 

            $data['TasksFinishProvider']  = new ActiveDataProvider([
                'query' => $TasksFinish,
                'pagination' => [
                    'pageSize' => 20,
                ],
            ]); 

        
            return $this->render('tasks', $data);
        }
        public function actionSee($id){
            date_default_timezone_set("America/Guatemala");
            $UserData =  Yii::$app->AccessControl->Verify([1,5]);
            $this->layout = $UserData->getLayout();

            $data=[];

            $data['UserData'] = $UserData;

            $data['Task'] = $Task = ProjectTasks::findOne($id);

            if($Task){
                if($Task->AccountID != $UserData->AccountID && $Task->OwnerTaskID != $UserData->AccountID){
                    return $this->redirect(['/tasks']);
                }
            }else{
                return $this->redirect(['/tasks']);
            }

            $data['modalComments'] = new TaskComments(['ProjectTaskID'=>$id,'AccountID'=>$UserData->AccountID]);

            if($data['modalComments']->load(Yii::$app->request->post())){
                $data['modalComments']->DateCreate = date('Y-m-d H:i:s');

                $data['modalComments']->uploadedFile = UploadedFile::getInstance($data['modalComments'], 'uploadedFile');

                if($data['modalComments']->uploadedFile){
                    $data['modalComments']->upload();
                }

                if($data['modalComments']->save()){
                    Yii::$app->session->setFlash('success','Comentario realizado');
                }else{
                    Yii::$app->session->setFlash('error','Ha ocurrido un error y no se pudo agregar tu comentario');
                }

                return $this->refresh();

            }

            $data['textStatusClass'] = "";
            $data['textStatus'] = "";

            $DateNow = new \DateTime("now");
            $DateEndtask = new \DateTime($Task->EstimatedEnd);

            
            $DiffDateNowTask = $DateNow->diff($DateEndtask); 
            $DaysDiffNow = $DiffDateNowTask->days;

            $DateStarTask = new \DateTime($Task->EstimatedStart);

            if($Task->Status != 2){
                switch(true){
                    case ($DateNow < $DateEndtask):
                        $DiffDateStartEnd = $DateStarTask->diff($DateEndtask);
                        $DaysDiffStart = $DiffDateStartEnd->days;

                        $cc = $DaysDiffStart * 0.2;
                        $data['textStatus'] = "En tiempo";
                        if($DaysDiffNow > $cc){
                            $data['textStatusClass'] = "text-success";
                        }elseif($DaysDiffNow <= $cc){
                            $data['textStatusClass'] = "text-warning";
                        }
                    break;
                    case ($DateNow > $DateEndtask):
                        $data['textStatus'] = "Atrasada";
                        $data['textStatusClass'] = "text-danger";
                    break;
                    case ($DateNow == $DateEndtask):
                        $data['textStatus'] = "En tiempo";
                        $data['textStatusClass'] = "text-warning";
                    break;
                }
            }else{
                $data['textStatusClass'] = "text-success";
                $data['textStatus'] = "Terminada";
            }

           

            // $data['TasksPenddingProvider']  = new ActiveDataProvider([
            //     'query' => $TasksPendding,
            //     'pagination' => [
            //         'pageSize' => 20,
            //     ],
            // ]); 

            $data['listUsers'] = ArrayHelper::map(UserAccount::find()->where(['!=', 'AccountID', $data['UserData']->AccountID])->orderBy('UserName', SORT_ASC)->all(), 'AccountID', 'UserName');

            $taskComp = DevelopersWorkTimeTasks::find()->where(['ProjectTaskID' => $id])->all();

            if(isset($_POST['actBtn'])){
                $actBtn = $_POST['actBtn'];

                $sendNoti = false;
                $notiTitl = '';
                $notiMsg = '';
                $sendNotifyCLient = true;
                $timeTask = new DevelopersWorkTimeTasks;

                if($actBtn == 1){
                    $Task->Status = 1;
                    $timeTask->Status = 1;
                    $timeTask->StartDate = date("Y-m-d H:i:s");
                    $text = "Jornada Iniciada";
                    if(!$Task->StartTask){
                        $notiTitl = 'Tarea iniciada';
                        $notiMsg = 'Se ha iniciado una tarea del proyecto ['.$Task->project->Name.']';
                        $sendNoti = true;
                        $Task->StartTask = $timeTask->StartDate;
                    }
                }
                else if($actBtn == 2){
                    $timeTask = DevelopersWorkTimeTasks::find()->where(['ProjectTaskID' => $id, 'Status' => 1])->one();
                    if(!empty($timeTask)){
                        $timeTask->Status = 2;
                        $timeTask->EndDate = date("Y-m-d H:i:s");
                        $text = "Jornada Finalizada";
                    }
                }
                else if($actBtn == 3){

                    if($data['Task']->load(Yii::$app->request->post())){
                        $result = 0;
                        
                        foreach($Task->project->tasks as $hours){
                            $result += $hours->HoursWorked;
                        }

                        $result = $Task->project->HoursCompleted - $result;

                        if($result - $data['Task']->HoursWorked < 0){
                            Yii::$app->session->setFlash('error','Esta colocando mas horas de las establecidas en el proyecto');
                            return $this->refresh();
                        }else{
                            $data['Task']->save();
                        }
                    }

                    $timeT = DevelopersWorkTimeTasks::find()->where(['ProjectTaskID' => $id, 'Status' => 1])->one();
                    if(!empty($timeT)){
                        $timeT->Status = 2;
                        $timeT->EndDate = date("Y-m-d H:i:s");
                        $timeT->TextAction = "Jornada Finalizada";
                        $timeT->save();
                    }
                    $Task->Status = 2;
                    $timeTask->Status = 3;
                    $timeTask->StartDate = date("Y-m-d H:i:s");
                    $timeTask->EndDate = date("Y-m-d H:i:s");
                    $text = "Tarea Completada";
                    if(!$Task->StartTask){
                        $Task->StartTask = $timeTask->StartDate;
                    }
                    if(!$Task->EndTask){
                        $Task->EndTask = $timeTask->EndDate;
                    }
                    $notiTitl = 'Tarea completada';
                    $notiMsg = 'Se ha completado una tarea del proyecto ['.$Task->project->Name.']';
                    $sendNoti = true;
                }else{
                    $timeT = DevelopersWorkTimeTasks::find()->where(['ProjectTaskID' => $id, 'Status' => 1])->one();
                    if(!empty($timeT)){
                        $timeT->EndDate = date("Y-m-d H:i:s");
                        $timeT->TextAction = "Jornada Finalizada";
                        $timeT->save();
                    }
                    if($data['Task']->load(Yii::$app->request->post())){
                        $nUser = UserAccount::find()->where(['AccountID' => $data['Task']->AccountID])->one();
                        $Task->AccountID = $data['Task']->AccountID;
                        $timeTask->StartDate = date("Y-m-d H:i:s");
                        $timeTask->EndDate = date("Y-m-d H:i:s");
                        $text = "Tarea transferida a " . $nUser->UserName; 
                        $sendNoti = true;
                        $notiTitl = 'Tarea transferida';
                        $notiMsg = 'Se ha transferido una tarea a '.$nUser->UserName.' del proyecto ['.$Task->project->Name.']';
                        $sendNotifyCLient = false;
                    }
                    $timeTask->Status = 2;
                }


                if($actBtn == 1 || $actBtn == 3 || $actBtn == 4){
                    $Task->save();
                    if($sendNoti){
                        $accIds =[];
                        if($sendNotifyCLient){
                            $accIds[] = $Task->project->AccountID;// Notificacion al cliente del proyecto
                        }else{
                            $accIds[] = $Task->AccountID;
                        }
                        foreach((array)$Task->project->followers as $follow){
                            $accIds[] = $follow->AccountID; //Notificacion a seguidores del proyecto
                        }
                        $accIds = array_filter($accIds,function($aid)use($UserData){ return $aid != $UserData->AccountID; });
                        Yii::$app->SystemNotifications->create([
                                'Title'=>$notiTitl,
                                'Body'=>$notiMsg,
                                'UrlIcon'=>Url::to('@raizweb',true).'/uploads/projects/logos/'.$Task->project->Logo
                            ],
                            $accIds,
                            ['SendPush'=>['weclickdigital']]
                        );
                    }
                }

                $timeTask->ProjectTaskID = $id;
                $timeTask->AccountID = $data['UserData']->AccountID;
                $timeTask->TextAction = $text;

                if($timeTask->save()){
                    return $this->refresh();
                }else{
                    // La validación falló
                    $errors = $timeTask->errors;
                    // Puedes imprimir o registrar los errores para depuración
                    var_dump($errors); exit;
                }
            }

        
            return $this->render('detail-task', $data);
        }

        public function actionDeleteComment($id){
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $UserData =  Yii::$app->AccessControl->Verify();

            $Comment = TaskComments::findOne($id);
            $idT = $Comment->ProjectTaskID;
            if($Comment->delete()){
                return $this->redirect(['see','id'=>$idT ]);
            }else{
                return $this->redirect(['see','id'=>$idT ]);
            }
        }

        public function actionGetTask($id){
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $UserData =  Yii::$app->AccessControl->Verify([1,5]);

            return  ProjectTasks::findOne($id);
        }

    }