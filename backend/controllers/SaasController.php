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

	

	class SaasController extends Controller{

        public function actionListEnlatado(){
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

                /* $data['model']->uploadedFile = UploadedFile::getInstance($data['model'], 'uploadedFile');
                if($data['model']->uploadedFile){
                    $data['model']->upload();
                } */

                /* $data['model']->FileGantt = UploadedFile::getInstance($data['model'], 'FileGantt');
                if($data['model']->FileGantt){
                    $data['model']->uploadGantt();
                } */
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
                                //'UrlIcon'=>Url::to('@raizweb',true).'/uploads/projects/logos/'.$data['model']->Logo
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
                            //'UrlIcon'=>Url::to('@raizweb',true).'/uploads/projects/logos/'.$data['model']->Logo
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

            
            
            $projects = ProjectsClients::find()->where(['ServiceID' => 2]);
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

            
            return $this->render('/projects/list-enlatado', $data);
        }

        public function actionListMonitoreo(){
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

                /* $data['model']->uploadedFile = UploadedFile::getInstance($data['model'], 'uploadedFile');
                if($data['model']->uploadedFile){
                    $data['model']->upload();
                } */

                /* $data['model']->FileGantt = UploadedFile::getInstance($data['model'], 'FileGantt');
                if($data['model']->FileGantt){
                    $data['model']->uploadGantt();
                } */
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
                                //'UrlIcon'=>Url::to('@raizweb',true).'/uploads/projects/logos/'.$data['model']->Logo
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
                            //'UrlIcon'=>Url::to('@raizweb',true).'/uploads/projects/logos/'.$data['model']->Logo
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

            
            
            $projects = ProjectsClients::find()->where(['ServiceID' => 5]);
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

            
            return $this->render('/projects/list-monitoreo', $data);
        }

        public function actionListEscaneo(){
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

                /* $data['model']->uploadedFile = UploadedFile::getInstance($data['model'], 'uploadedFile');
                if($data['model']->uploadedFile){
                    $data['model']->upload();
                } */

                /* $data['model']->FileGantt = UploadedFile::getInstance($data['model'], 'FileGantt');
                if($data['model']->FileGantt){
                    $data['model']->uploadGantt();
                } */
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
                                //'UrlIcon'=>Url::to('@raizweb',true).'/uploads/projects/logos/'.$data['model']->Logo
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
                            //'UrlIcon'=>Url::to('@raizweb',true).'/uploads/projects/logos/'.$data['model']->Logo
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

            
            
            $projects = ProjectsClients::find()->where(['ServiceID' => 4]);
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

            
            return $this->render('/projects/list-escaneo', $data);
        }

        public function actionListDiseweb(){
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

                /* $data['model']->uploadedFile = UploadedFile::getInstance($data['model'], 'uploadedFile');
                if($data['model']->uploadedFile){
                    $data['model']->upload();
                } */

                /* $data['model']->FileGantt = UploadedFile::getInstance($data['model'], 'FileGantt');
                if($data['model']->FileGantt){
                    $data['model']->uploadGantt();
                } */
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
                                //'UrlIcon'=>Url::to('@raizweb',true).'/uploads/projects/logos/'.$data['model']->Logo
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
                            //'UrlIcon'=>Url::to('@raizweb',true).'/uploads/projects/logos/'.$data['model']->Logo
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

            
            
            $projects = ProjectsClients::find()->where(['ServiceID' => 7]);
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

            
            return $this->render('/projects/list-design', $data);
        }

        public function actionProjectClientAnexos($id, $sid, $type = 1){
            $UserData =  Yii::$app->AccessControl->Verify([1]);

           /*if(empty($id) || empty($sid) || empty($type))
                return $this->redirect(['/home']); */

            $this->layout = $UserData->getLayout();

            $data['model'] = new ProjectsClientsAnexos(['ProjectClientID' => $id, 'ServiceID' => $sid, 'Type' => $type]);

            if(isset(Yii::$app->request->post()['ProjectsClientsAnexos']['ProjectClientAnexoID'])){
                $data['model'] =  ProjectsClientsAnexos::findOne(Yii::$app->request->post()['ProjectsClientsAnexos']['ProjectClientAnexoID']);
            }

            $project = ProjectsClientsAnexos::find()->where(['ProjectClientID' => $id, 'Type' => $type]);

            $data['info'] = ProjectsClients::findOne($id);

            $data['ProjectsProvider']  = new ActiveDataProvider([
                'query' => $project,
                'pagination' => [
                    'pageSize' => 10,
                ],
            ]); 

            $data['type'] = $type;

            if($data['model']->load(Yii::$app->request->post())){
                if($data['model']->validate()){
                    
                    $file = $type == 0 ? 'FilePrice' : 'FileService';

                    $data['model']->$file = UploadedFile::getInstance($data['model'], $file);

                    if($data['model']->$file)
                        $data['model']->upload($type);

                    if($data['model']->save()){

                        $notiTitl = 'Tienes un documento';
                        $text = "un nuevo documento";
                        if($type == 0){
                            $data['info']->Status = 1;
                            $data['info']->save();
                            $notiTitl = 'Tienes una cotización';
                            $text = "una nueva cotización";
                        }

                
                        $notiMsg = "Se ha añadido {$text} al proyecto [{$data['info']->Name}]";
                        $accIds = [];
                        $accIds[] = $data['info']->account->AccountID;
                        Yii::$app->SystemNotifications->create([
                                'Title'=>$notiTitl,
                                'Body'=>$notiMsg,
                                'UrlIcon'=>Url::to('@raizweb',true).'/uploads/projects/logos/'.$data['info']->Logo
                            ],
                            $accIds,
                            ['SendPush'=>['weclickdigital']]
                        );

                        Yii::$app->session->setFlash('success','Datos subidos corectamente.');
                        return $this->refresh();
                    }else{
                        echo '<pre>';
                        echo print_r($data['model']->getErrors());
                        echo '</pre> 1';
                        exit;
                    }
                }else{
                    echo '<pre>';
                    echo print_r($data['model']->getErrors());
                    echo '</pre> 2';
                    exit;
                }
            }

            return $this->render('/projects/pcanexos', $data);
        }

        public function actionGetDataAjax(){
            $UserData =  Yii::$app->AccessControl->Verify([1]);

            $this->layout = false;

            $query = ProjectsClientsAnexos::find()->where(['ProjectClientAnexoID' => $_POST['id']])->asArray()->one();
            echo json_encode($query);
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

        public function actionDeleteAnexos($id, $type = ''){
            $UserData =  Yii::$app->AccessControl->Verify([1]);

            $this->layout = false;

            $model = ProjectsClientsAnexos::findOne($id);
            
             if($type == 0){
                $file = Yii::$app->basePath.'/../'.$model->File;
                if(is_file($file)){
                    unlink($file);
                }
            }

            if($model->delete()){
                Yii::$app->session->setFlash('success','Datos elimados corectamente.');
                return $this->redirect(['list-enlatado']);
            }
        }
    }