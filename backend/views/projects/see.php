<?php
 
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap5\Modal;
use yii\bootstrap5\Button;
use yii\bootstrap5\ActiveForm;
use common\components\datatables\DataTables;
$this->title = $project->Name;
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
    .fn-label{
        z-index: 1;
    }
    .fn-gantt-hint {
    border: 2px solid #edc332;
    background-color: #fff;
    padding: 10px;
    position: absolute;
    display: none;
    -webkit-border-radius: 4px;
   -moz-border-radius: 4px;
        border-radius: 4px;
    z-index: 1055;
    color:#000;
}

</style>

<div class="d-flex gap-3 align-items-center">
    <?php foreach($changeProject as $cp): ?>
        <?php if(!is_null($cp['value'])): ?>
            <?= Html::a('<i class="fa-regular fa-circle-'.$cp['icon'].' fs-1" style="color: #7219cbff"></i>', Url::to(['see', 'id' => $cp['value']]), ['title' => $cp['title']]); ?>
        <?php endif ?>
    <?php endforeach ?>
</div>
<div class="d-flex justify-content-between align-items-center mt-4 mb-3">
    <span class="fs-3 fw-bold d-block" style="color: var(--bs-dark)">Proyecto <?= $project->Name; ?></span>
    <a href="<?= Url::to(['projects/following']) ?>" title="Atrás"><i class="fa-regular fa-circle-left fs-1" style="color: #FF0351"></i></a>
</div>
<div class="row mt-4">
    <div class="col-md-8">
        <div class="d-flex align-items-center gap-3 mb-4">
            <div style="background: var(--bg-catalog); border-radius: 5px;" class="p-2">
                <img src="<?= \Yii::getAlias('@raizweb') . '/uploads/projects/logos/'.$project->Logo; ?>" onError="this.src='https://dev.mydesk.digital/NewWeclickUp/images/logo.png'" class="d-block" style="height:70px; object-fit: contains; border-radius: 6%"/>
            </div>
            <span style="color: var(--bs-dark);"><?= $project->Name; ?></span>
        </div>
       
       <!--  <br>  -->
        <!-- <h6>Tipo de proyecto < <?= $project->Type; ?> ></h6> -->
    </div>
    <?php
        $verify = false;
        $result = 0;
        foreach($project->tasks as $worked){
            $result += $worked->HoursWorked;
        }
        $hworked = $result;
        $result = $project->HoursCompleted - $result;
        if(!empty($project->HoursCompleted) && $result != 0){
            $verify = true;
        }else if(empty($project->HoursCompleted)){
            $verify = true;
        }
    ?>

    <?php if($verify): ?>
        <div class="col-md-4 d-flex align-items-end justify-content-end">
            <div class="btn-group">
                <button class="btn d-flex gap-2 align-items-center" style="background: #FF0351;; color: #fff;" onClick="$('#create-modal').modal('show');"><i class="fa fa-plus"></i>Agregar Tarea</button>
                <?php if($printGantt): ?>
                <button class="btn btn-warning openGantt"><i class="fa fa-eye"></i> GANTT</button>
                <?php endif;?>
            </div>
        </div>
    <?php endif ?>
    
</div>

<?php if(!empty($project->HoursCompleted)): ?>
    <div class="my-2 fs-4">
        Horas de la tarea:  <?= $project->HoursCompleted ?> / <?= $hworked ?>
    </div>
<?php endif ?>

<?php if(!in_array('20', $UserData->rolesId)): ?>

    <div class="row mx-0 mt-5 mb-4">
        <div class="col-md-12 p-2" style="background: #FEF1F7; border-radius: 6px;">
            <div class="fs-3" style="font-weight: 500; color: var(--bs-black);">Tareas sin asignar</div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <?php   

                $columns[] = ['class' => 'yii\grid\SerialColumn', 'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;']];

                $columns[] = [
                    'label' => 'Titúlo',
                    'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                    'value' => function ($data) {
                        return $data->Title; // $data['name'] for array data, e.g. using SqlDataProvider.
                    },
                    'format' => 'text',
                    'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;'],
                ];

                $columns[] =  [
                    'label' => 'Tipo',
                    'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                    'value' => function ($data) {
                        return $data->Type; // $data['name'] for array data, e.g. using SqlDataProvider.
                    },
                    'format' => 'text',
                    'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;'],
                ];

                $columns[] = [
                    'label' => 'Fecha inicio',
                    'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                    'value' => function ($data) {
                        return date('d/m/Y H:i', strtotime($data->EstimatedStart));
                    },
                    'format' => 'text',
                    'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;'],
                ];

                $columns[] = [
                    'label' => 'Fecha fin',
                    'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                    'value' => function ($data) {
                        return date('d/m/Y H:i', strtotime($data->EstimatedEnd));
                    },
                    'format' => 'text',
                    'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;'],
                ];
                
                $columns[] = [
                    'label' => 'Estado',
                    'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                    'value' => function ($data) {
                        switch($data->Status){
                            case 0:
                                return "PENDIENTE";
                            break;
                            case 1:
                                return "EN PROCESO";
                            break;
                            case 2:
                                return "COMPLETADA";
                            break;
                            case 3:
                                return "PUBLICADO EN DEV";
                            break;
                            case 4:
                                return "PUBLICADO EN PRD";
                            break;
                            default :
                                return "";
                            break;
                        }
                    },
                    'format' => 'text',
                    'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;'],
                ];

                $columns[] = [
                    'class' => 'yii\grid\ActionColumn',
                    'header' => 'Acciones',
                    'template' => '<div class="btn-group" > {edit}{view}{delete} </div>',
                    'buttons' => [
                        'edit' => function($url, $model){
                            
                            return "<button class='btn btn-info press-edit-task' data-id='".$model->ProjectTaskID."' title='editar'><i class='fa fa-edit'></i></button>";
                            
                        },
                        'view' => function($url,$model){
                            return "<button class='btn btn-success press-view-task' data-id='".$model->ProjectTaskID."' title='ver'> <i class='fa fa-eye'></i></button>";
                        },
                        'delete' => function($url,$model) use ($UserData){
                            if($UserData->AccountID == $model->OwnerTaskID){
                                return Html::a('<span class="fa fa-trash"></span>', ['delete-task', 'id' => $model->ProjectTaskID], [
                                    'class' => 'btn btn-danger click-confirm',
                                    'tittle-alert' => 'Eliminar información',
                                    'text-alert'  => '¿Estás seguro? Cuando elimines el registro, no podrás recuperarlo más tarde.',
                                ]);
                            }else{
                                return "";
                            }
                        }
                        
                    ],
                    'contentOptions'=>['style'=>'min-width: 100px; text-align: center; vertical-align:middle;'],
                ];

                echo DataTables::widget([
                        'dataProvider' => $TaskGanttProviderNo,
                        'columns' => $columns,
                        'clientOptions' => [
                        "lengthMenu"=> [[10,20,-1], [10,20,Yii::t('app',"All")]],
                        "info"=>false,
                        "retrieve" => true,
                        "responsive"=>'true', 
                        "dom"=> 'lfTrtip',
                        "tableTools"=>[
                            "aButtons"=> [  
                            ]
                        ],
                        'language'=>[
                            'processing'    => Yii::t('app', 'Procesando...'),
                            'search'        => Yii::t('app', 'Buscar:'),
                            'lengthMenu'    => Yii::t('app','Mostrar _MENU_ Entradas'),
                            'info'        => Yii::t('app','Mostrando del _START_ al _END_ de _TOTAL_ entradas'),
                            'infoEmpty'  => Yii::t('app','Mostrando del 0 al 0 de 0 entradas'),
                            'infoFiltered'  => Yii::t('app','(Filtrado de _MAX_ entradas totales)'),
                            'infoPostFix'   => '',
                            'loadingRecords'=> Yii::t('app','Cargando...'),
                            'zeroRecords'   => Yii::t('app','No se encontraron registros coincidentes'),
                            'emptyTable'    => Yii::t('app','No hay datos disponibles en la tabla'),
                            'paginate' => [
                                'first'  => Yii::t('app','<<'),
                                'previous'  => Yii::t('app','<i class="fa-solid fa-chevron-left"></i>'),
                                'next'    => Yii::t('app','<i class="fa-solid fa-chevron-right"></i>'),
                                'last'    => Yii::t('app','>>'),
                            ],
                            'aria' => [
                                'sortAscending' => Yii::t('app',': activate to sort column ascending'),
                                'sortDescending'=> Yii::t('app',': activate to sort column descending'),
                            ]
                        ],
                    ],
                ]);
            ?>
        </div> 
        
    </div>

<?php endif ?>

<div class="row mx-0 mt-5 mb-4">
    <div class="col-md-12 p-2" style="background: #E5FCF9; border-radius: 6px;">
        <div class="fs-3" style="font-weight: 500; color: var(--bs-black);">Tareas asignadas</div>
    </div>
</div>


<div class="row">
    
    <div class="col-12">
        <?php   
            echo DataTables::widget([
                    'dataProvider' => $TaskGanttProvider,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        // Simple columns defined by the data contained in $dataProvider.
                        // Data from the model's column will be used.
                            [
                            'label' => 'Titúlo',
                                'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                                'value' => function ($data) {
                                    return $data->Title; // $data['name'] for array data, e.g. using SqlDataProvider.
                                },
                                'format' => 'text',
                                'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;'],
                            ],
                            [
                                'label' => 'Asignado a',
                                'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                                'value' => function ($data) {
                                    return $data->account->userAccount->UserName . " | ". $data->account->userAccount->Name; // $data['name'] for array data, e.g. using SqlDataProvider.
                                },
                                'format' => 'text',
                                'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;'],
                            ],
                            [
                                'label' => 'Tipo',
                                'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                                'value' => function ($data) {
                                    return $data->Type; // $data['name'] for array data, e.g. using SqlDataProvider.
                                },
                                'format' => 'text',
                                'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;'],
                            ],
                            /* [
                                'label' => 'Creada por',
                                'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                                'value' => function ($data) {
                                    return $data->owner->userAccount->UserName. ' | '. $data->owner->userAccount->Name; // $data['name'] for array data, e.g. using SqlDataProvider.
                                },
                                'format' => 'text',
                                'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;'],
                            ], */
                            [
                                'label' => 'Fecha inicio',
                                'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                                'value' => function ($data) {
                                    return date('d/m/Y H:i', strtotime($data->EstimatedStart));
                                },
                                'format' => 'text',
                                'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;'],
                            ],
                            [
                                'label' => 'Fecha fin',
                                'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                                'value' => function ($data) {
                                    return date('d/m/Y H:i', strtotime($data->EstimatedEnd));
                                },
                                'format' => 'text',
                                'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;'],
                            ],
                            [
                                'label' => 'Estado',
                                'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                                'value' => function ($data) {
                                    switch($data->Status){
                                        case 0:
                                            return "PENDIENTE";
                                        break;
                                        case 1:
                                            return "EN PROCESO";
                                        break;
                                        case 2:
                                            return "COMPLETADA";
                                        break;
                                        case 3:
                                            return "PUBLICADO EN DEV";
                                        break;
                                        case 4:
                                            return "PUBLICADO EN PRD";
                                        break;
                                        default :
                                            return "";
                                        break;
                                    }
                                },
                                'format' => 'text',
                                'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;'],
                            ],
                        
                            // [
                            // 'label' => 'Descripción de la tarea',
                            //     'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                            //     'value' => function ($data) {
                            //         $contChatr = (strlen($data->Description) > 22)? '...':'';
                            //         return substr($data->Description,0,22).$contChatr; // $data['name'] for array data, e.g. using SqlDataProvider.
                            //     },
                            //     'format' => 'text',
                            //     'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;'],
                            // ],
                            // [
                            //     'label' => 'Adjuntos',
                            //         'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                            //         'value' => function ($data) {
                            //             return '<a href="'.\Yii::getAlias('@raizweb') . '/uploads/tasks/'.$data->File.'" target="_blank">Ver</a>'; // $data['name'] for array data, e.g. using SqlDataProvider.
                            //         },
                            //         'format' => 'raw',
                            //         'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;'],
                            // ],
                            // [
                            // 'label' => 'Fecha de inicio estimado',
                            //     'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                            //     'value' => function ($data) {
                            //         return date('d/m/Y H:i', strtotime($data->EstimatedStart)); // 
                            //     },
                            //     'format' => 'raw',
                            //     'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;'],
                            // ],
                            // [
                            // 'label' => 'Fecha fin estimada',
                            //     'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                            //     'value' => function ($data) {
                            //         return date('d/m/Y H:i', strtotime($data->EstimatedEnd)); // 
                            //     },
                            //     'format' => 'raw',
                            //     'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;'],
                            // ],
                            // [
                            // 'label' => 'Asignada a',
                            //     'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                            //     'value' => function ($data) {
                            //     return isset($data->account->userAccount->UserName)?$data->account->userAccount->UserName:NULL;
                            //     },
                            //     'format' => 'raw',
                            //     'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;'],
                            // ],

                            [
                                'class' => 'yii\grid\ActionColumn',
                                'header' => 'Acciones',
                                'template' => '<div class="btn-group" > {edit}{view}{delete} </div>',
                                'buttons' => [
                                    'edit' => function($url, $model){
                                        
                                        return "<button class='btn btn-info press-edit-task' data-id='".$model->ProjectTaskID."' title='editar'><i class='fa fa-edit'></i></button>";
                                        
                                    },
                                    'view' => function($url,$model){
                                        return "<button class='btn btn-success press-view-task' data-id='".$model->ProjectTaskID."' title='ver'> <i class='fa fa-eye'></i></button>";
                                    },
                                    'delete' => function($url,$model) use ($UserData){
                                        if($UserData->AccountID == $model->OwnerTaskID){
                                            return Html::a('<span class="fa fa-trash"></span>', ['delete-task', 'id' => $model->ProjectTaskID], [
                                                'class' => 'btn btn-danger click-confirm',
                                                'tittle-alert' => 'Eliminar información',
                                                'text-alert'  => '¿Estás seguro? Cuando elimines el registro, no podrás recuperarlo más tarde.',
                                            ]);
                                        }else{
                                            return "";
                                        }
                                    }
                                    
                                ],
                                'contentOptions'=>['style'=>'min-width: 100px; text-align: center; vertical-align:middle;'],
                            ],
                        
                    ],
                    'clientOptions' => [
                    "lengthMenu"=> [[10,20,-1], [10,20,Yii::t('app',"All")]],
                    "info"=>false,
                    "retrieve" => true,
                    "responsive"=>'true', 
                    "dom"=> 'lfTrtip',
                    "tableTools"=>[
                        "aButtons"=> [  
                        ]
                    ],
                    'language'=>[
                        'processing'    => Yii::t('app', 'Procesando...'),
                        'search'        => Yii::t('app', 'Buscar:'),
                        'lengthMenu'    => Yii::t('app','Mostrar _MENU_ Entradas'),
                        'info'        => Yii::t('app','Mostrando del _START_ al _END_ de _TOTAL_ entradas'),
                        'infoEmpty'  => Yii::t('app','Mostrando del 0 al 0 de 0 entradas'),
                        'infoFiltered'  => Yii::t('app','(Filtrado de _MAX_ entradas totales)'),
                        'infoPostFix'   => '',
                        'loadingRecords'=> Yii::t('app','Cargando...'),
                        'zeroRecords'   => Yii::t('app','No se encontraron registros coincidentes'),
                        'emptyTable'    => Yii::t('app','No hay datos disponibles en la tabla'),
                        'paginate' => [
                            'first'  => Yii::t('app','<<'),
                            'previous'  => Yii::t('app','<i class="fa-solid fa-chevron-left"></i>'),
                            'next'    => Yii::t('app','<i class="fa-solid fa-chevron-right"></i>'),
                            'last'    => Yii::t('app','>>'),
                        ],
                        'aria' => [
                            'sortAscending' => Yii::t('app',': activate to sort column ascending'),
                            'sortDescending'=> Yii::t('app',': activate to sort column descending'),
                        ]
                    ],
                ],
            ]);
        ?>
    </div> 
       
</div>

<!-- Modal  UPDATE-->
<?php Modal::begin(['id'=>'update-modal','title'=>'Información de la tarea','size'=>'modal-lg']); ?>
        <?php $form = ActiveForm::begin(['id' => 'update-task-modal', 'method' => 'post']); ?>
        <!-- Modal content-->
            <div class="row">
                <div class="col-md-6">   
                    <?= $form->field($model, 'Title')->textInput(['maxlength' => true,'id'=>'u-Title']); ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'Status')->dropDownList([0=>'PENDIENTE',
                        1 => 'EN PROCESO',
                        2 => 'COMPLETADA'
                        ],['id'=>'u-Status']); ?>
                </div>
                <div class="col-12">   
                    <?= $form->field($model, 'Description')->textarea(['maxlength' => true,'id'=>'u-Description']); ?>
                </div>
                <div class="col-md-6">   
                    <?= $form->field($model, 'uploadedFile')->fileinput(['maxlength' => true,'id'=>'u-upload'])->label('Adjunto <a id="u-File" target="_blank" href="#">Ver</a>'); ?>
                </div>
                <?php if(in_array('20', $UserData->rolesId)): ?>
                    <?= $form->field($model, 'AccountID')->hiddenInput(['value' => $UserData->AccountID, 'id' => 'u-AccountID'])->label(false) ?>
                <?php else: ?>
                    <div class="col-md-6">   
                        <?= $form->field($model, 'AccountID')->dropdownList($ListUsers,['id'=>'u-AccountID','prompt' => ' -- Seleccione --']); ?>
                    </div>
                <?php endif ?>
                <div class="col-md-6">   
                    <?= $form->field($model, 'EstimatedStart')->textInput(['type' => 'datetime-local','id'=>'u-EstimatedStart']); ?>
                </div>
                <div class="col-md-6">   
                    <?= $form->field($model, 'EstimatedEnd')->textInput(['type' => 'datetime-local','id'=>'u-EstimatedEnd']); ?>
                </div>
                
                <?php if(count($typetasks) == 1): ?>
                    <div class="col-md-6">
                        <?= $form->field($model, 'Type')->textInput(['id'=>'u-Type', 'readonly' => true, "class"=>"typetask-chg form-control"]); //$form->field($model, 'Type')->dropDownList($typetasks,['maxlength' => true,'id'=>'u-Type']); ?>
                    </div>
                <?php else: ?>
                    <?php if(count($typetasks) == 1):  $keyValTypeTask = array_key_first($typetasks); ?>
                    <?php else: ?>
                        <div class="col-sm-6">   
                            <?= $form->field($model, 'Type')->dropDownList($typetasks,['maxlength' => true, "class"=>"typetask-chg u-TypeListGantt", 'id'=>'u-Type']); ?>
                        </div>
                    <?php endif; ?>
                    <div class="col-sm-6 sprint-section only-viewGantt">   
                        <?= $form->field($model, 'Sprint')->dropDownList([
                            1 => "Sprint 1",
                            2 => "Sprint 2",
                            3 => "Sprint 3",
                            4 => "Sprint 4",
                            5 => "Sprint 5",
                            6 => "Sprint 6",
                            7 => "Sprint 7",
                            8 => "Sprint 8",
                            9 => "Sprint 9",
                            10 => "Sprint 10",
                            11 => "Sprint 11",
                            12 => "Sprint 12",
                            13 => "Sprint 13",
                            14 => "Sprint 14",
                            15 => "Sprint 15",
                            16 => "Sprint 16",
                            17 => "Sprint 17",
                            18 => "Sprint 18",
                            19 => "Sprint 19",
                            20 => "Sprint 20",
                        ],['maxlength' => true, 'id' => 'list-gantt']); ?>
                    </div>        
                <?php endif ?>

                <div class="col-12 mt-4 d-flex justify-content-end">
                    <?= Html::submitButton('Actualizar tarea', ['class' => 'btn click-confirm','id'=>'u-ProjectTaskID', 'name'=>'ProjectTaskID', 'style' => 'background: #FF0351; color: #fff;']) ?>
                </div>
            </div>
        <?php ActiveForm::end(); ?>
<?php Modal::end(); ?>

<!-- Modal  Create-->
<?php Modal::begin(['id'=>'create-modal', 'title'=>'Crear tarea para el proyecto', 'size'=>'modal-lg']); ?>
        <?php $form = ActiveForm::begin(['id' => 'create-task-modal', 'method' => 'post']); ?>
        <!-- Modal content-->
            <div class="row">
                <div class="col-md-6">   
                    <?= $form->field($model, 'Title')->textInput(['maxlength' => true]); ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'Status')->dropDownList([0=>'PENDIENTE',
                        1 => 'EN PROCESO',
                        2 => 'COMPLETADA'
                        ],['id'=>'u-Status']); ?>
                </div>
                <div class="col-12">   
                    <?= $form->field($model, 'Description')->textarea(['maxlength' => true]); ?>
                </div>
                <div class="col-md-6">   
                    <?= $form->field($model, 'uploadedFile')->fileinput(['maxlength' => true])->label('Adjunto <a id="u-File" target="_blank" href="#">Ver</a>'); ?>
                </div>
                <?php if(in_array('20', $UserData->rolesId)): ?>
                    <?= $form->field($model, 'AccountID')->hiddenInput(['value' => $UserData->AccountID])->label(false) ?>
                <?php else: ?>
                    <div class="col-md-6">   
                        <?= $form->field($model, 'AccountID')->dropdownList($ListUsers,['prompt' => ' -- Seleccione --']); ?>
                    </div>
                <?php endif ?>
                <div class="col-md-6">   
                    <?= $form->field($model, 'EstimatedStart')->textInput(['type' => 'datetime-local']); ?>
                </div>
                <div class="col-md-6">   
                    <?= $form->field($model, 'EstimatedEnd')->textInput(['type' => 'datetime-local']); ?>
                </div>
                <?php if(count($typetasks) == 1):  $keyValTypeTask = array_key_first($typetasks); ?>
                <!-- <div class="col-sm-6">  -->  
                    <div>
                    <?= $form->field($model, 'Type')->hiddenInput(['value' => $keyValTypeTask,"class"=>"typetask-chg"])->label(false) //$form->field($model, 'Type')->dropDownList($typetasks,['maxlength' => true]); ?>
                    </div>
                <!-- </div> -->
                <?php else: ?>
                     <div class="col-sm-6">   
                        <?= $form->field($model, 'Type')->dropDownList($typetasks,['maxlength' => true, "class"=>"typetask-chg"]); ?>
                    </div>
                <?php endif; ?>
                <div class="col-sm-6 sprint-section">   
                    <?= $form->field($model, 'Sprint')->dropDownList([
                        1 => "Sprint 1",
                        2 => "Sprint 2",
                        3 => "Sprint 3",
                        4 => "Sprint 4",
                        5 => "Sprint 5",
                        6 => "Sprint 6",
                        7 => "Sprint 7",
                        8 => "Sprint 8",
                        9 => "Sprint 9",
                        10 => "Sprint 10",
                        11 => "Sprint 11",
                        12 => "Sprint 12",
                        13 => "Sprint 13",
                        14 => "Sprint 14",
                        15 => "Sprint 15",
                        16 => "Sprint 16",
                        17 => "Sprint 17",
                        18 => "Sprint 18",
                        19 => "Sprint 19",
                        20 => "Sprint 20",
                    ],['maxlength' => true]); ?>
                </div>
                <div class="col-12 mt-4 d-flex justify-content-end">
                    <?= Html::submitButton('Agregar tarea', ['class' => 'btn click-confirm', 'style' => 'background: #FF0351; color: #fff;']) ?>
                </div>
            </div>
        <?php ActiveForm::end(); ?>
<?php Modal::end(); ?>


<?php if($printGantt): Modal::begin(['id'=>'gant-modal','title'=>'GANTT','size'=>'modal-xl']); ?>
    <div class="row">
        <div class="col-12">
                <div id="gantt-container" class="gantt" style="width:100%;"></div>
        </div>
    </div>
<?php Modal::end(); endif;?>
<?php 
if (Yii::$app->session->hasFlash('success')):
    $this->registerJS('
        $(document).ready(function(){
            _Message("success","¡Exito!","'.Yii::$app->session->getFlash('success').'");
        });

        ');
endif;

if (Yii::$app->session->hasFlash('error')):

    $this->registerJS('
        $(document).ready(function(){
            _Message("error","¡Error!","'.Yii::$app->session->getFlash('error').'");
        });

        ');
endif;
if($printGantt){

    $this->registerJsFile("https://taitems.github.io/jQuery.Gantt/js/jquery.fn.gantt.js",[
        'depends' => [
            \yii\web\JqueryAsset::className()
        ]
    ]);

    
    $this->registerCssFile('https://taitems.github.io/jQuery.Gantt/css/style.css');
    

    $tasksGantt = [];
    foreach($project->tasksGantt as $it):
        $complete = 0;
        if($it->AccountID){
            $complete += 25;
        }
        if($it->Status == 1){
            $complete += 25;
        }
        if($it->Status == 2){
            $complete += 75;
        }
        $DateStart = new \DateTime($it->EstimatedStart);
        $Diff = $DateStart->diff((new \DateTime($it->EstimatedEnd))); 

        $message = "";
        if($Diff->y > 0){
            $message .= $Diff->y." ";
            $message .= ($Diff->y > 1)?'años':'año';

        }
        elseif($Diff->m > 0){
            $message .= $Diff->m." ";
            $message .= ($Diff->m > 1)?'meses':'mes';
        }
        elseif($Diff->d > 0){
            $WeekDay = '';
            $num = $Diff->d;
            if($Diff->d >= 7){
                $num = ceil(($Diff->d / 7));
                if($num > 1){
                    $WeekDay = 'semanas';
                }else{
                    $WeekDay = 'semana';
                }
            }else{
                if($num > 1){
                    $WeekDay = 'dias';
                }else{
                    $WeekDay = 'día';
                }
            }
            $message .= "{$num} {$WeekDay}";
        }
        elseif($Diff->h > 0){
            $message .= $Diff->h." ";
            $message .= ($Diff->h > 1)?'horas':'hora';

        }
        
        $cLabelClass = "ganttRed";
        switch(true){
            case ($complete < 25):
                $cLabelClass = "ganttRed";
                break;
            case ($complete < 50):
                $cLabelClass = "ganttOrange";
                break;
            case ($complete < 100):
                $cLabelClass = "ganttBlue";
                break;
            case ($complete == 100):
                $cLabelClass = "ganttGreen";
                break;
        }

        $title = "Sprint ".$it->Sprint;
        $vali = array_filter($tasksGantt, function($objF)use($it){ if($objF->name == "Sprint ".$it->Sprint){ return true; }else{ return false; }});

        if(count($vali) > 0 ){
            $title = "";
        }

        $tasksGantt[] = (Object)[
                        "name" => $title,
                        "desc" => $it->Title,
                        "id" => $it->ProjectTaskID,
                        "values" =>[(Object)[
                            'from' => date('Y-m-d',strtotime($it->EstimatedStart)).' 08:00',
                            'to' =>  date('Y-m-d',strtotime($it->EstimatedEnd)).' 18:00',
                            'label' => $complete."% completado",
                            'desc' => "<b>".$it->Title."</b><br> Duración estimada: ".$message."<br> Desde: ".date('d/m/Y',strtotime($it->EstimatedStart))."<br> Hasta: ".date('d/m/Y',strtotime($it->EstimatedEnd))."<br> Descripión: ".$it->Description."<br>Completado: ".$complete."%",
                            'customClass'=> $cLabelClass,
                            
                        ]]
                ];

    endforeach;
    $tasksGantt = json_encode($tasksGantt);
    $this->registerJS('
        var projectTasks = '.$tasksGantt.';

        var openGantt = 0;
        $(".openGantt").click(function(){
        
            $("#gant-modal").modal("show");

            if(openGantt == 0){
             openGantt++;
                $("#gantt-container").gantt({
                    source: projectTasks,
                    scale: "days",
                    maxScale: "months",
                    minScale: "hours",
                    itemsPerPage: 10,
                    scrollToToday: false,
                    useCookie: true,
                    navigate: "scroll",
                    cellWidth: 51, slideWidth: 900,
                    months : ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
                    dow : ["", "", "", "", "", "", ""],
                    onRender: function() {
                        console.log("chart rendered");
                    }
                });
                setTimeout(function(){
                            $(".nav-link.nav-zoomIn").trigger("click");
                            console.log("✅ Zoom automático simulado mediante clics");
                        }, 600);
               
            }

           
        
        });

    ', \yii\web\View::POS_END, 'my-options');
}

$this->registerJS('
    function show_hide_sprint(){
            $(".typetask-chg").each(function(){
                let contSprt = $(this).parent().parent().parent().find(".sprint-section");
                if($(this).val() == "gantt"){
                   contSprt.show();
                   contSprt.find("select").attr("disabled",false);
                }else{
                    contSprt.hide();
                   contSprt.find("select").attr("disabled",true);

                }
            });
        }

        show_hide_sprint();

        $(document).on("change",".typetask-chg",function(e){
            console.log("Change")
             show_hide_sprint();
        })
    $(document).on("click", ".press-edit-task, .press-view-task", function(e){
        if($(this).hasClass("press-edit-task")){
            $("#update-modal *").prop("disabled", false);
            $("#u-ProjectTaskID").css({display:"block"});
        }else{
            $("#update-modal *").prop("disabled", true);
            $("#u-ProjectTaskID").css({display:"none"});

        }
        $(".btn-close").prop("disabled", false);
        let idTask = $(this).data("id");

        $("#u-Title").val("");
        $("#u-Type").val("");
        $("#u-Description").val("");
        $("#u-AccountID").val("");
        $("#u-EstimatedStart").val("");
        $("#u-EstimatedEnd").val("");
        $("#u-ProjectTaskID").val(idTask);
        $("#u-upload").val("");
        $("#u-Status").val("");
        $("#u-File").attr("href","");
        $("#u-File").css({display:"none"});

        $.get("'.Url::to(['get-task']).'",{id:idTask}, function(r){
            if(r){
                $("#u-Title").val(r.Title);
                $("#u-Type").val(r.Type);
                $("#u-Description").val(r.Description);
                $("#u-AccountID").val(r.AccountID);
                $("#u-EstimatedStart").val(r.EstimatedStart);
                $("#u-EstimatedEnd").val(r.EstimatedEnd);
                $("#u-Status").val(r.Status);
            
                if(r.Type == "qa"){
                    $(".only-viewGantt").css("display", "none")
                    $("#list-gantt").prop("disabled", true)
                }

                if(r.File){
                    $("#u-File").attr("href","'.Yii::getAlias('@raizweb') . '/uploads/tasks/'.'"+r.File);
                    $("#u-File").css({display:"unset"});

                }
                $("#update-modal").modal("show");
            }

        });
    
    });

');