<?php 
	namespace backend\controllers;
    
	use Yii;
	use yii\web\Controller;
	use yii\filters\VerbFilter;
	use yii\filters\AccessControl;

	use common\models\Account;
	use common\models\ProjectsClients;
    use common\models\ProjectsClientsAnexos;
	use common\models\UserAccount;
    use common\models\ProjectFollowers;
    use common\models\ProjectTasks;
    use common\models\Services;


	use common\components\ValidUsers;
	use yii\helpers\ArrayHelper;
	use yii\helpers\Url;


	use yii\data\ActiveDataProvider;
	use yii\db\Expression;
    use yii\web\UploadedFile;

    use yii\web\Response;

	

	class ProjectsController extends Controller
	{


        public function actionList($id){
            $UserData =  Yii::$app->AccessControl->Verify([1]);
            // 1 = Users Admin
            // 2 = Users moderador
            // Verificar en tabla TypeUsers
            $data = [];
            $this->layout = $UserData->getLayout();
            $data['model'] = new ProjectsClients(['AccountID' => $id]);

            if(isset(Yii::$app->request->post()['ProjectsClients']['ProjectClientID'])){
                $data['model'] =  ProjectsClients::findOne(Yii::$app->request->post()['ProjectsClients']['ProjectClientID']);
            }

            if($data['model']->load(Yii::$app->request->post())){

                $data['model']->uploadedFile = UploadedFile::getInstance($data['model'], 'uploadedFile');
                if($data['model']->uploadedFile){
                    $data['model']->upload();
                }

                $data['model']->FileGantt = UploadedFile::getInstance($data['model'], 'FileGantt');
                if($data['model']->FileGantt){
                    $data['model']->uploadGantt();
                }
                $newProyect = false;
                if($data['model']->isNewRecord){
                    $newProyect = true;
                }
                if($data['model']->save()){
                    ProjectFollowers::deleteAll(['ProjectClientID' => $data['model']->ProjectClientID]);
                    $aidFollows = [];
                    foreach($data['model']->UsersFollowers as $follows){
                        $Follow = new ProjectFollowers();
                        $Follow->AccountID = $follows;
                        $Follow->ProjectClientID = $data['model']->ProjectClientID;
                        $Follow->DateFollow = date('Y-m-d H:i:s');
                        $aidFollows[] = $follows;

                        if(!$Follow->save()){
                            Yii::$app->session->setFlash('error','Ha ocurrido un error y no se pudo actualizar la información');
                            return $this->refresh();
                        }

                    }

                    if($newProyect){
                        $notiTitl = 'Nuevo proyecto';
                        $notiMsg = 'Se ha añadido un nuevo proyecto a tu lista ['.$data['model']->Name.']';
                        $accIds = [];
                        $accIds[] = $data['model']->AccountID;
                        Yii::$app->SystemNotifications->create([
                                'Title'=>$notiTitl,
                                'Body'=>$notiMsg,
                                'UrlIcon'=>Url::to('@raizweb',true).'/uploads/projects/logos/'.$data['model']->Logo
                            ],
                            $accIds,
                            ['SendPush'=>['weclickdigital']]
                        );
                    }

                    if(count($aidFollows) > 0){
                        $notiTitl = 'Seguimiento de proyecto';
                        $notiMsg = 'Se te ha asignado como seguidor del proyecto ['.$data['model']->Name.']';
                        Yii::$app->SystemNotifications->create([
                                'Title'=>$notiTitl,
                                'Body'=>$notiMsg,
                                'UrlIcon'=>Url::to('@raizweb',true).'/uploads/projects/logos/'.$data['model']->Logo
                            ],
                            $aidFollows,
                            ['SendPush'=>['weclickdigital']]
                        );
                    }
                    Yii::$app->session->setFlash('success','Información registrada corectamente.');
                    return $this->refresh();
                }else{
                    
                    Yii::$app->session->setFlash('error','Ha ocurrido un error y no se pudo actualizar la información');
                    return $this->refresh();
                }

            }

            $Usuarios = UserAccount::find()->where(['TypeUser' => [1,5]])->all();
            
            $data['Client'] =  UserAccount::find()->where(['AccountID' => $id])->one();
            
            $projects = ProjectsClients::find()->where(['AccountID'=>$id]);
            $data['ListUsers'] = ArrayHelper::map($Usuarios,'AccountID','UserName');


            $data['ProjectsProvider']  = new ActiveDataProvider([
                    'query' => $projects,
                    'pagination' => [
                        'pageSize' => 20,
                    ],
                ]);   

            
            return $this->render('list', $data);
        }

        public function actionListAll(){
            $UserData =  Yii::$app->AccessControl->Verify([1]);
            // 1 = Users Admin
            // 2 = Users moderador
            // Verificar en tabla TypeUsers
            $data = [];
            $this->layout = $UserData->getLayout();
            $data['model'] = new ProjectsClients();

            if(isset(Yii::$app->request->post()['ProjectsClients']['ProjectClientID'])){
                $data['model'] =  ProjectsClients::findOne(Yii::$app->request->post()['ProjectsClients']['ProjectClientID']);
            }

            if($data['model']->load(Yii::$app->request->post())){

                $data['model']->uploadedFile = UploadedFile::getInstance($data['model'], 'uploadedFile');
                if($data['model']->uploadedFile){
                    $data['model']->upload();
                }

                $data['model']->FileGantt = UploadedFile::getInstance($data['model'], 'FileGantt');
                if($data['model']->FileGantt){
                    $data['model']->uploadGantt();
                }
                $newProyect = false;
                if($data['model']->isNewRecord){
                    $newProyect = true;
                }

                $serv = Services::find()->all();
                foreach($serv as $s){
                    if(stripos($data['model']->Type, $s->Name) !== false){
                        $serviceID = $s->ServiceID;
                    }
                }

                $data['model']->ServiceID = $serviceID;

                //var_dump($data['model']); exit;

                if($data['model']->save()){
                    ProjectFollowers::deleteAll(['ProjectClientID' => $data['model']->ProjectClientID]);
                    $aidFollows = [];
                    foreach((array)$data['model']->UsersFollowers as $follows){
                        $Follow = new ProjectFollowers();
                        $Follow->AccountID = $follows;
                        $Follow->ProjectClientID = $data['model']->ProjectClientID;
                        $Follow->DateFollow = date('Y-m-d H:i:s');
                        $aidFollows[] = $follows;

                        if(!$Follow->save()){
                            Yii::$app->session->setFlash('error','Ha ocurrido un error y no se pudo actualizar la información');
                            return $this->refresh();
                        }

                    }
                    if($newProyect){
                        $notiTitl = 'Nuevo proyecto';
                        $notiMsg = 'Se ha añadido un nuevo proyecto a tu lista ['.$data['model']->Name.']';
                        $accIds = [];
                        $accIds[] = $data['model']->AccountID;
                        Yii::$app->SystemNotifications->create([
                                'Title'=>$notiTitl,
                                'Body'=>$notiMsg,
                                'UrlIcon'=>Url::to('@raizweb',true).'/uploads/projects/logos/'.$data['model']->Logo
                            ],
                            $accIds,
                            ['SendPush'=>['weclickdigital']]
                        );
                    }

                    if(count($aidFollows) > 0){
                        $notiTitl = 'Seguimiento de proyecto';
                        $notiMsg = 'Se te ha asignado como seguidor del proyecto ['.$data['model']->Name.']';
                        $accIds = [];
                        Yii::$app->SystemNotifications->create([
                            'Title'=>$notiTitl,
                            'Body'=>$notiMsg,
                            'UrlIcon'=>Url::to('@raizweb',true).'/uploads/projects/logos/'.$data['model']->Logo
                        ],
                        $aidFollows,
                        ['SendPush'=>['weclickdigital']]
                    );
                    }



                    Yii::$app->session->setFlash('success','Información registrada corectamente.');
                    return $this->refresh();
                }else{
                    
                    Yii::$app->session->setFlash('error','Ha ocurrido un error y no se pudo actualizar la información');
                    return $this->refresh();
                }

            }

            $Usuarios = UserAccount::find()->where(['TypeUser' => [1,5]])->all();
            $ClientsList = UserAccount::find()->where(['TypeUser' => [2]])->all();

            
            
            $projects = ProjectsClients::find()->where(['not in', 'ServiceID', [2, 4, 5, 7]])->orderBy(['ProjectClientID' => SORT_DESC]);
            $data['ListUsers'] = ArrayHelper::map($Usuarios,'AccountID','UserName');
            $data['ListClients'] = ArrayHelper::map($ClientsList,'AccountID',function($model){
                return "$model->UserName | $model->Name";
            });


            $data['ProjectsProvider']  = new ActiveDataProvider([
                    'query' => $projects,
                    'pagination' => [
                        'pageSize' => 20,
                    ],
                ]);   

            
            return $this->render('list-all', $data);
        }

        public function actionCompleteProject($id){
            $UserData =  Yii::$app->AccessControl->Verify([1]);
            $project = ProjectsClients::findOne($id);
            $v = $project->Completed == 1 ? 0 : 1;
            $project->Completed = $v;
            if($project->save()){
                return $this->redirect(['projects/list-all']);
            }
        }

        public function actionGetDataProject($id){
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $UserData =  Yii::$app->AccessControl->Verify([1]);

            $project = ProjectsClients::findOne($id);

            $UsersFollowers = ArrayHelper::map($project->followers,'AccountID','AccountID');

            $projectR = $project->attributes;
            $projectR['UsersFollowers'] = array_values($UsersFollowers);
            return $projectR;
        }

        public function actionDelete($id){
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $UserData =  Yii::$app->AccessControl->Verify([1]);

            $project = ProjectsClients::findOne($id);
            $AcID = $project->AccountID;
            if($project->delete()){
                return $this->redirect((Yii::$app->request->referrer));
            }else{
                return $this->redirect((Yii::$app->request->referrer));
            }
        }

        public function actionFollowing(){
            $UserData =  Yii::$app->AccessControl->Verify([1,5]);
            // 1 = Users Admin
            // 2 = Users moderador
            // Verificar en tabla TypeUsers
            $data = [];
            $this->layout = $UserData->getLayout();

            $projects = ProjectFollowers::find()->joinWith('projectsClient')->where(['ProjectFollowers.AccountID'=>$UserData->AccountID, 'Completed' => 0])->orderBy(['ProjectFollowerID' => SORT_DESC]);

            // var_dump($projects->all()); exit;

            $data['ProjectsProvider']  = new ActiveDataProvider([
                'query' => $projects,
                'pagination' => [
                    'pageSize' => 20,
                ],
            ]); 

        
            return $this->render('following', $data);
        }

        public function actionSee($id){
            $UserData =  Yii::$app->AccessControl->Verify([1,5]);
            // 1 = Users Admin
            // 2 = Users moderador
            // Verificar en tabla TypeUsers
            $data = [];
            $this->layout = $UserData->getLayout();

            $data['project'] = ProjectsClients::findOne($id);

            $data['model'] = new ProjectTasks([
                'ProjectClientID' => $id,
                'OwnerTaskID'=> $UserData->AccountID,
                'EstimatedStart' => date('Y-m-d H:i'), 
                'EstimatedEnd'=>date('Y-m-d H:i'),
                'Status' => 0
            ]);


           
            if(isset(Yii::$app->request->post()['ProjectTaskID'])){
                $data['model'] =   ProjectTasks::findOne(Yii::$app->request->post()['ProjectTaskID']);
                
            }

            if($data['model']->load(Yii::$app->request->post())){
                $updateTask = false;
                $notiMsg = 'Se ah añadido una nueva tarea al proyecto ['.$data['project']->Name.']';
                $notiTitl = 'Nueva tarea agregada';
                if(!$data['model']->isNewRecord){
                    $updateTask = true;
                    $notiMsg = 'Se ah actualizado la información de una tarea en el proyecto ['.$data['project']->Name.']';
                    $notiTitl = 'Tarea actualizada';
                }

                $data['model']->uploadedFile = UploadedFile::getInstance($data['model'], 'uploadedFile');
                if($data['model']->uploadedFile){
                    $data['model']->upload();
                }

                if($data['model']->save()){
                    Yii::$app->session->setFlash('success','Tarea registrada corectamente.');
                    $accIds = [];
                    $accIds[] = $data['project']->AccountID; //Agregamos la id del cliente para ser notificado
                    if($data['model']->AccountID){
                        $accIds[] = $data['model']->AccountID; // se agrega la id del usuario asignado a la tarea para ser notificado
                    }
                    foreach($data['project']->followers as $follower){
                        $accIds[] = $follower->AccountID;  //Se agregan las id de los usuarios que siguen este proyecto
                    }
                    $accIds = array_filter($accIds,function($aid)use($UserData){ return $aid != $UserData->AccountID; }); // se filtra la id del usuario logueado en caso que exista para evitar notificacion propia

                    Yii::$app->SystemNotifications->create([
                            'Title'=>$notiTitl,
                            'Body'=>$notiMsg,
                            'UrlIcon'=>Url::to('@raizweb',true).'/uploads/projects/logos/'.$data['project']->Logo
                        ],
                        $accIds,
                        ['SendPush'=>['weclickdigital']]
                    );
                    return $this->refresh();
                }else{
                    // var_dump($data['model']->getErrors());
                    //     exit();
                    Yii::$app->session->setFlash('error','No se ha podido registrar la tarea por favor intenta nuevamente.');
                        return $this->refresh();
                }

            }
            $data['UserData'] = $UserData;
            $data['printGantt'] = (count($data['project']->tasksGantt) > 0 && $data['project']->UseGantt == 1)? true:false;
            $Usuarios = UserAccount::find()->where(['TypeUser' => [1,5]])->all();
            $data['ListUsers'] = ArrayHelper::map($Usuarios,'AccountID','UserName');

            $servicios = ['Software a la medida', 'Servicio outsourcing', 'Soporte wordpress', 'Aplicación móvil'];

            if(in_array($data['project']->Type, $servicios)){
                if($data['project']->UseGantt == 0){
                    $data['typetasks']=[   
                        'qa'=>'QA'
                    ];
                }else{
                    $data['typetasks']=[   
                        'gantt' => 'GANTT',
                        'qa'=>'QA',
                    ];
                }
            }else{
                $data['typetasks']=[   
                    'qa'=>'QA'
                ];
            }
            
            /* if($data['project']->Type == 'SAAS'){
                $data['typetasks']=[   
                    'qa'=>'QA',
                ];
            } */
    
            $data['TaskGanttProvider']  = new ActiveDataProvider([
                'query' => ProjectTasks::find()->where(['ProjectClientID'=>$id])->andWhere(['IS NOT','AccountID', new Expression('NULL')])->orderBy(['Status'=>SORT_ASC, 'EstimatedStart'=>SORT_ASC]),
                'pagination' => [
                    'pageSize' => 5,
                ],
            ]); 
            $data['TaskGanttProviderNo']  = new ActiveDataProvider([
                'query' => ProjectTasks::find()->where(['ProjectClientID'=>$id])->andWhere(['IS','AccountID', new Expression('NULL')])->orderBy(['Status'=>SORT_ASC, 'EstimatedStart'=>SORT_ASC]),
                'pagination' => [
                    'pageSize' => 5,
                ],
            ]); 

            $data['changeProject'] = ['back' => ['value' => null, 'title' => 'Anterior', 'icon' => 'left'], 'next' => ['value' => null, 'title' => 'Siguiente', 'icon' => 'right']];

            $listProject = ProjectsClients::find()->select(['ProjectsClients.ProjectClientID'])->joinWith('followers')->where(['Completed' => 0, 'ProjectFollowers.AccountID' => $UserData->AccountID])->orderBy(['ProjectFollowerID' => SORT_DESC])->column(); 

            $posicion = array_search($id, $listProject);

            if ($posicion !== false) {
                // Obtener el valor siguiente (si existe)
                $siguiente = isset($listProject[$posicion + 1]) ? $listProject[$posicion + 1] : null;
                
                // Obtener el valor anterior (si existe)
                $anterior = isset($listProject[$posicion - 1]) ? $listProject[$posicion - 1] : null;
            }

            $data['changeProject']['back']['value'] = $anterior;

            $data['changeProject']['next']['value'] = $siguiente;
        
            return $this->render('see', $data);
        }

        public function actionGetTask($id){
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $UserData =  Yii::$app->AccessControl->Verify([]);

            return  ProjectTasks::findOne($id);
        }
        public function actionDeleteTask($id){
            $UserData =  Yii::$app->AccessControl->Verify([]);

            $task =  ProjectTasks::findOne($id);
            if($task){
                if($task->delete()){
                    Yii::$app->session->setFlash('success','Tarea eliminada exitosamente.');
                }else{
                    Yii::$app->session->setFlash('error','No se ha podido eliminar la tarea.');
                }
            }else{
                Yii::$app->session->setFlash('error','No se ha podido encontrado la tarea a eliminar.');
            }

            return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
        }

        public function actionPersonalized($id){
            $UserData =  Yii::$app->AccessControl->Verify([2,3,4]);

            $data = [];

            function getRelatedAccountIds($currentAccountId){
                // Buscar si el usuario actual es un subusuario
                $currentAccount = Account::findOne($currentAccountId);
                
                if ($currentAccount->ParentAccount) {
                    // Es subusuario - retornar [todos los subusuarios del mismo padre + el padre]
                    $siblings = Account::find()
                        ->select(['AccountID'])
                        ->where(['ParentAccount' => $currentAccount->ParentAccount])
                        ->column();
                    
                    return array_merge([$currentAccount->ParentAccount], $siblings);
                } else {
                    // Es usuario padre - retornar [padre] + todos los subusuarios
                    $subUsers = Account::find()
                        ->select(['AccountID'])
                        ->where(['ParentAccount' => $currentAccountId])
                        ->column();
                    
                    return array_merge([$currentAccountId], $subUsers);
                }
            }

            // En tu acción:
            $relatedAccountIds = getRelatedAccountIds($UserData->AccountID);


            $this->layout = $UserData->getLayout();
            $data['id'] = $id;
            $data['ProjectsProvider']  = new ActiveDataProvider([
                'query' => ProjectsClients::find()->where(['AccountID'=> $relatedAccountIds, 'ServiceID' => $id])->orderBy(['ProjectClientID' => SORT_DESC]),
                'pagination' => [
                    'pageSize' => 5,
                ],
            ]); 
            return $this->render('personalized', $data);

        }

        public function actionPerCotiza(){
            $UserData =  Yii::$app->AccessControl->Verify([2,3,4]);

            //$data = [];
            $this->layout = false;
            $query = ProjectsClientsAnexos::find()->where(['ProjectClientID' => $_POST['id'], 'Type' => $_POST['type']])->asArray()->all();
            echo json_encode($query); 
        }

        public function actionDetail($id){
            $UserData =  Yii::$app->AccessControl->Verify([2,3,4]);
            // 1 = Users Admin
            // 2 = Users moderador
            // Verificar en tabla TypeUsers
            $data = [];
            $this->layout = $UserData->getLayout();

            $data['project'] = ProjectsClients::findOne($id);

            $data['model'] = new ProjectTasks([
                'ProjectClientID' => $id,
                'OwnerTaskID'=> $UserData->AccountID,
                'EstimatedStart' => date('Y-m-d H:i'), 
                'EstimatedEnd'=>date('Y-m-d H:i'),
                'Status' => 0
            ]);
            
            if(isset(Yii::$app->request->post()['ProjectTaskID'])){
                $data['model'] = ProjectTasks::findOne(Yii::$app->request->post()['ProjectTaskID']);
                
            }

            if($data['model']->load(Yii::$app->request->post())){
                $updateTask = false;

                $notiMsg = 'Se ah añadido una nueva tarea al proyecto ['.$data['project']->Name.']';
                $notiTitl = 'Nueva tarea agregada';
                if(!$data['model']->isNewRecord){
                    $updateTask = true;
                    $notiMsg = 'Se ah actualizado la información de una tarea en el proyecto ['.$data['project']->Name.']';
                    $notiTitl = 'Tarea actualizada';
                }

                $data['model']->uploadedFile = UploadedFile::getInstance($data['model'], 'uploadedFile');
                if($data['model']->uploadedFile){
                    $data['model']->upload();
                }

                if($data['model']->save()){
                    Yii::$app->session->setFlash('success','Tarea registrada corectamente.');
                    $accIds = [];
                    $accIds[] = $data['project']->AccountID; //Agregamos la id del cliente para ser notificado
                    if($data['model']->AccountID){
                        $accIds[] = $data['model']->AccountID; // se agrega la id del usuario asignado a la tarea para ser notificado
                    }
                    foreach($data['project']->followers as $follower){
                        $accIds[] = $follower->AccountID;  //Se agregan las id de los usuarios que siguen este proyecto
                    }
                    $accIds = array_filter($accIds,function($aid)use($UserData){ return $aid != $UserData->AccountID; }); // se filtra la id del usuario logueado en caso que exista para evitar notificacion propia

                    Yii::$app->SystemNotifications->create([
                            'Title'=>$notiTitl,
                            'Body'=>$notiMsg,
                            'UrlIcon'=>Url::to('@raizweb',true).'/uploads/projects/logos/'.$data['project']->Logo
                        ],
                        $accIds,
                        ['SendPush'=>['weclickdigital']]
                    );
                    return $this->refresh();
                }else{
                    // var_dump($data['model']->getErrors());
                    //     exit();
                    Yii::$app->session->setFlash('error','No se ha podido registrar la tarea por favor intenta nuevamente.');
                        return $this->refresh();
                }

            }
            $data['UserData'] = $UserData;
            $data['printGantt'] = (count($data['project']->tasksGantt) > 0 && $data['project']->UseGantt == 1)? true:false;

            $data['typetasks']=[   
                'qa'=>'QA',
            ];

            // var_dump($projects->all()); exit;

            $query = ProjectTasks::find()->where(['ProjectClientID' => $id, 'Type' => 'qa'])->orderBy(['Status' => SORT_ASC, 'EstimatedStart' => SORT_ASC]);

            $data['TaskProvider']  = new ActiveDataProvider([
                'query' => $query,
                'pagination' => [
                    'pageSize' => 10,
                ],
            ]); 

            function getRelatedAccountIds($currentAccountId){
                // Buscar si el usuario actual es un subusuario
                $currentAccount = Account::findOne($currentAccountId);
                
                if ($currentAccount->ParentAccount) {
                    // Es subusuario - retornar [todos los subusuarios del mismo padre + el padre]
                    $siblings = Account::find()
                        ->select(['AccountID'])
                        ->where(['ParentAccount' => $currentAccount->ParentAccount])
                        ->column();
                    
                    return array_merge([$currentAccount->ParentAccount], $siblings);
                } else {
                    // Es usuario padre - retornar [padre] + todos los subusuarios
                    $subUsers = Account::find()
                        ->select(['AccountID'])
                        ->where(['ParentAccount' => $currentAccountId])
                        ->column();
                    
                    return array_merge([$currentAccountId], $subUsers);
                }
            }

            // En tu acción:
            $relatedAccountIds = getRelatedAccountIds($UserData->AccountID);

            $data['changeProject'] = ['back' => ['value' => null, 'title' => 'Anterior', 'icon' => 'left'], 'next' => ['value' => null, 'title' => 'Siguiente', 'icon' => 'right']];

            $listProject = ProjectsClients::find()->select(['ProjectClientID'])->where(['ServiceID' => $data['project']->ServiceID, 'AccountID' => $relatedAccountIds])->orderBy(['ProjectClientID' => SORT_DESC])->column();

            $posicion = array_search($id, $listProject);

            $anterior = isset($listProject[$posicion - 1]) ? $listProject[$posicion - 1] : null;
            
            $siguiente = isset($listProject[$posicion + 1]) ? $listProject[$posicion + 1] : null;

            $data['changeProject']['back']['value'] = $anterior;

            $data['changeProject']['next']['value'] = $siguiente;

            return $this->render('detail', $data);
        }

        public function actionGantt($id){
            $UserData =  Yii::$app->AccessControl->Verify([]);
            // 1 = Users Admin
            // 2 = Users moderador
            // Verificar en tabla TypeUsers
            $data = [];
            $this->layout = 'gantt';

            $data['project'] = ProjectsClients::findOne($id);
            $data['UserData'] = $UserData;
            $data['printGantt'] = (count($data['project']->tasksGantt) > 0 &&  $data['project']->UseGantt == 1)? true:false;
        
            return $this->render('only-gantt', $data);
        }

        public function actionTestmail(){

            //   $response =   Yii::$app->mailerSes->compose()
            //     ->setFrom('no-reply@dev.mydesk.digital')
            //     ->setTo('info@dev.mydesk.digital')
            //     ->setSubject('Send Mail from SES WeclickDigital')
            //     ->setHtmlBody('This is a Email sender from Amazon SES')
            //     ->send();
    
    
            $response =  Yii::$app
            ->mailerSes
            ->compose()
            ->setFrom('no-reply@dev.mydesk.digital')
            ->setTo('info@dev.mydesk.digital')
            ->setSubject('Send Mail from SES Dev.Mydesk.Digital ')
            ->setTextBody('This is a Email sender from SMTP Amazon SES')
            ->send();
    
    
                var_dump($response);
                exit();
    
        }
        public function actionBurndown($id){
            $UserData =  Yii::$app->AccessControl->Verify();

            $this->layout = $UserData->getLayout();
            $project = ProjectsClients::findOne($id);
            $sprints = ProjectTasks::find()
                ->select(['Sprint'])
                ->distinct()
                ->where(['ProjectClientID' => $id, 'Type' => 'gantt'])
                ->orderBy(['Sprint' => SORT_ASC])
                ->column();

            return $this->render('burndown', [
                'sprints' => $sprints,
                'project' =>$project
            ]);
        }

        public function actionLoadBurndownChart($sprint,$id){
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            $tasks = ProjectTasks::find()
                ->where(['Sprint' => $sprint,'ProjectClientID' => $id, 'Type' => 'gantt'])
                ->all();

            $totalTasks = count($tasks);
            if ($totalTasks === 0) {
                return ['error' => 'No hay tareas para este Sprint'];
            }

            $taskPendding = 0;
            $taskInit = 0;
            $taskComplete = 0;

            // Obtener fechas mínima y máxima truncadas a solo fecha
            $start = null;
            $end = null;
            foreach ($tasks as $task) {
                $taskStart = date('Y-m-d', strtotime($task->EstimatedStart));
                $taskEnd = date('Y-m-d', strtotime($task->EstimatedEnd));
                if (!$start || $taskStart < $start) {
                    $start = $taskStart;
                }
                if (!$end || $taskEnd > $end) {
                    $end = $taskEnd;
                }

                switch($task->Status){
                    case 1:
                        $taskInit++;
                        break;
                    case 2:
                        $taskComplete++;
                        break;
                    case 0:
                        $taskPendding++;
                        break;
                }
            }

            $interval = new \DateInterval('P1D');
            $period = new \DatePeriod(new \DateTime($start), $interval, (new \DateTime($end))->modify('+1 day'));

            $ideal = [];
            $real = [];
            foreach ($period as $date) {
                $currentDate = $date->format('Y-m-d');

                $daysTotal = (new \DateTime($start))->diff(new \DateTime($end))->days;
                $dayIndex = (new \DateTime($currentDate))->diff(new \DateTime($start))->days;
                if($daysTotal == 0){
                    $daysTotal = 1;
                }
                $ideal[$currentDate] = round($totalTasks * (1 - ($dayIndex / $daysTotal)));

                $doneCount = ProjectTasks::find()
                    ->where(['Sprint' => $sprint,'ProjectClientID' => $id, 'Type' => 'gantt'])
                    ->andWhere(['Status' => 2])
                    ->andWhere(new \yii\db\Expression('DATE(EndTask) <= :date', [':date' => $currentDate]))
                    ->count();

                $real[$currentDate] = $totalTasks - $doneCount;
            }

            
            return [
                'labels' => array_keys($ideal),
                'ideal' => array_values($ideal),
                'real' => array_values($real),
                'countPendding' => $taskPendding,
                'conutInit' => $taskInit,
                'countComplete' => $taskComplete,
            ];
        }
    }




