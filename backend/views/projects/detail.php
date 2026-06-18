<?php
 
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap5\Modal;
use yii\bootstrap5\Button;
use yii\bootstrap5\ActiveForm;
use common\components\datatables\DataTables;
$this->title = $project->Name;
$this->params['breadcrumbs'][] = $this->title;

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
        $color = "#F9C4E1";
        switch(true){
            case ($complete < 25):
                $cLabelClass = "ganttRed";
                $color = "#F9C4E1;";
                break;
            case ($complete < 50):
                $cLabelClass = "ganttOrange";
                $color = "#FCD29A";
                break;
            case ($complete < 100):
                $cLabelClass = "ganttBlue";
                $color = "#D0E4FD";
                break;
            case ($complete == 100):
                $cLabelClass = "ganttGreen";
                $color = "#D8EDA3;";
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
            "color" => $color,
            "values" =>[(Object)[
                'from' => date('Y-m-d H:i:s',strtotime($it->EstimatedStart)),
                'to' =>  date('Y-m-d H:i:s',strtotime($it->EstimatedEnd)),
                'label' => $complete."% completado",
                'desc' => "<b>".mb_strtoupper($it->Title)."</b><br> Duración estimada: ".$message."<br> Desde: ".date('d/m/Y',strtotime($it->EstimatedStart))."<br> Hasta: ".date('d/m/Y',strtotime($it->EstimatedEnd))."<br> Descripión: ".$it->Description."<br>Completado: ".$complete."%",
                'customClass'=> $cLabelClass,
            ]]
        ];

    endforeach;

    $listGantt = $tasksGantt; 
    $tasksGantt = json_encode($tasksGantt);
    
    $this->registerJS('

        var projectTasks = '.$tasksGantt.';


        $(document).ready(function(e){
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
        })

        var openGantt = 0;

    ', \yii\web\View::POS_END, 'my-options');
}

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

<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="d-flex gap-3 align-items-center">
        <?php foreach($changeProject as $cp): ?>
            <?php if(!is_null($cp['value'])): ?>
                <?= Html::a('<i class="fa-regular fa-circle-'.$cp['icon'].' fs-1" style="color: #7219cbff"></i>', Url::to(['detail', 'id' => $cp['value']]), ['title' => $cp['title']]); ?>
            <?php endif ?>
        <?php endforeach ?>
    </div>
    <?= Html::a('<i class="fa-regular fa-circle-left fs-1" style="color: #FF0351"></i>', Url::to(['personalized', 'id' => $project->ServiceID]), ['title' => 'Atrás']); ?>
</div>

<div class="row mt-2">
    <div class="col-12">

        <?php if(!is_null($project->Logo)): ?>
            <img src="<?= \Yii::getAlias('@raizweb') . '/uploads/projects/logos/'.$project->Logo; ?>" onError="this.src='https://dev.mydesk.digital/NewWeclickUp/images/logo.png'" style="height:70px; object-fit: contains; border-radius: 6%" class="d-block mb-3" />
        <?php endif ?>
        <div class="mb-1" style="color: var(--bs-dark)"><b>Nombre del proyecto:</b> <?= $project->Name; ?></div>
         
        <div style="color: var(--bs-dark)"><b>Tipo de proyecto:</b> <?= $project->Type; ?> </div>
    </div>
    <div class="col-12">
        <hr>
    </div>
</div>
<?php if($printGantt): ?>
    <div class="row mt-4">
        <div class="col-md-8">
            <h2 class="text-success">GANTT <?php if($project->UrlGantt): ?><small><a class="btn btn-sm btn-info" href="<?= $project->UrlGantt ?>" target="_blank"><i class="fa fa-download"></i> Descargar</a></small><?php endif; ?></h2>
        </div>
        <div class="col-md-4 d-flex align-items-end justify-content-end">
            <div class="btn-group">
                <a href="<?= Url::to(['gantt','id'=>$project->ProjectClientID])?>" class="btn btn-info" title="Gantt"><i class="fa fa-chart-gantt"></i></a>
                <a href="<?= Url::to(['burndown','id'=>$project->ProjectClientID])?>" class="btn btn-warning" title="Burndown Chart"><i class="fa fa-chart-line"></i></a>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div id="gantt-container" class="gantt" style="width:100%;"></div>
            <div class="d-flex align-items-center gap-3 mb-4">
                <span style="color: #D8EDA3;">Verde: Completado / Finalizado</span>
                <span style="color: #D0E4FD">Azul: En proceso / Iniciado</span>
                <span style="color: #FCD29A">Naranja: Asignado</span>
                <span style="color: #F9C4E1;">Rojo: Sin asignar</span>
            </div>
        </div>
    </div>
    <div class="row mb-5 mt-3">
        <?php foreach($listGantt as $lg): ?>
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="p-3 h-100 w-100" style="border-radius: 6px; background-color: var(--bg-catalog); color: var(--bs-dark); border: 2px solid <?= $lg->color ?>">
                    <?php foreach($lg->values as $lgv): ?>
                        <?= $lgv->desc ?>
                    <?php endforeach ?>
                </div>
            </div>
        <?php endforeach ?>
    </div>
    <hr>
<?php endif;?>
<div class="row mt-2">
    <div class="col-md-8">
        <h2 class="text-success">Quality Assurance Testing, (QA)</h2>
    </div>
    <?php if($project->Completed == 0): ?>
        <div class="col-md-4 d-flex align-items-end justify-content-end">
            <div class="btn-group">
                <button class="btn btn-info" onClick="$('#create-modal').modal('show');"><i class="fa fa-plus me-2"></i>Agregar Tarea</button>
            </div>
        </div>
    <?php endif ?>
</div>
<hr>

<?php 
    $result = 0;
    if(empty($project->tasks))
        $result;
    else{
        foreach($project->tasks as $hours){
            $result += $hours->HoursWorked;
        }
    }
?>
<div class="row mt-4">
    <?php if(!empty($project->HoursCompleted)): ?>
        <div class="mt-1 mb-3 fs-5">
            Horas realizadas <?= $result ?> / <?=  $project->HoursCompleted ?>
        </div>
    <?php endif ?>
    <div class="col-12">
        <h3>Tareas del proyecto</h3>
        <?php   
            $columns[] = ['class' => 'yii\grid\SerialColumn'];
            $columns[] = [
                'label' => 'Titúlo',
                'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                'value' => function ($data) {
                    return $data->Title; // $data['name'] for array data, e.g. using SqlDataProvider.
                },
                'format' => 'text',
                'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;'],
            ];
            if($project->ShowDates == 1){
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
            }
            if(!empty($project->HoursCompleted)){
                $columns[] = [
                    'attribute' => 'HoursWorked',
                    'format' => 'text',
                    'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;'],
                ];
            }
            $columns[] = [
                'label' => 'Estado de la tarea',
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
                'template' => '<div class="btn-group" > {edit}{view}{delete} </div>',
                'buttons' => [
                    'edit' => function($url, $model) use ($UserData){
                        if($model->Status == 0 && $UserData->AccountID == $model->OwnerTaskID){
                            return "<button class='btn btn-info press-edit-task' data-id='".$model->ProjectTaskID."' title='editar'><i class='fa fa-edit'></i></button>";
                        }
                        
                    },
                    'view' => function($url,$model){
                        return "<button class='btn btn-warning press-view-task' data-id='".$model->ProjectTaskID."' title='ver'> <i class='fa fa-eye'></i></button>";
                    },
                    'delete' => function($url,$model) use ($UserData){
                        if($UserData->AccountID == $model->OwnerTaskID && $model->Status == 0){
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
                    'dataProvider' => $TaskProvider,
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


<!-- Modal  UPDATE-->
<?php Modal::begin(['id'=>'update-modal','title'=>'Información de la tarea','size'=>'modal-lg']); ?>
        <?php $form = ActiveForm::begin(['id' => 'update-task-modal', 'method' => 'post']); ?>
        <!-- Modal content-->
                <div class="row">
                    <div class="col-sm-8">   
                        <?= $form->field($model, 'Title')->textInput(['maxlength' => true,'id'=>'u-Title']); ?>
                    </div>
                    <div class="col-sm-4" style="display:none;">   
                        <?= $form->field($model, 'Type')->dropDownList($typetasks,['maxlength' => true,'id'=>'u-Type']); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">   
                        <?= $form->field($model, 'Description')->textarea(['maxlength' => true,'id'=>'u-Description']); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">   
                        <?= $form->field($model, 'uploadedFile')->fileinput(['maxlength' => true,'id'=>'u-upload'])->label('Adjunto <a id="u-File" target="_blank" href="#">Ver</a>'); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">   
                        <?= $form->field($model, 'EstimatedStart')->textInput(['type' => 'datetime-local','id'=>'u-EstimatedStart']); ?>
                    </div>
                    <div class="col-sm-6">   
                        <?= $form->field($model, 'EstimatedEnd')->textInput(['type' => 'datetime-local','id'=>'u-EstimatedEnd']); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-3">
                        <?= $form->field($model, 'Status')->hiddeninput(['value'=>0])->label(false); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <?= Html::submitButton('Actualizar', ['class' => 'btn btn-info click-confirm','id'=>'u-ProjectTaskID', 'name'=>'ProjectTaskID']) ?>
                    </div>
                </div>
        <?php ActiveForm::end(); ?>
<?php Modal::end(); ?>

<!-- Modal  Create-->
<?php Modal::begin(['id'=>'create-modal','title'=>'Crear tarea para el proyecto','size'=>'modal-lg']); ?>
        <?php $form = ActiveForm::begin(['id' => 'create-task-modal', 'method' => 'post']); ?>
        <!-- Modal content-->
                <div class="row">
                    <div class="col-sm-8">   
                        <?= $form->field($model, 'Title')->textInput(['maxlength' => true]); ?>
                    </div>
                    <div class="col-sm-4" style="display:none;">   
                        <?= $form->field($model, 'Type')->dropDownList($typetasks,['maxlength' => true]); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">   
                        <?= $form->field($model, 'Description')->textarea(['maxlength' => true]); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">   
                        <?= $form->field($model, 'uploadedFile')->fileinput(['maxlength' => true])->label('Adjunto'); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">   
                        <?= $form->field($model, 'EstimatedStart')->textInput(['type' => 'datetime-local']); ?>
                    </div>
                    <div class="col-sm-6">   
                        <?= $form->field($model, 'EstimatedEnd')->textInput(['type' => 'datetime-local']); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-3">
                        <?= $form->field($model, 'Status')->hiddeninput(['value'=>0])->label(false); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">   
                        <?= Html::submitButton('Crear', ['class' => 'btn btn-info click-confirm']) ?>
                    </div>
                </div>
        <?php ActiveForm::end(); ?>
<?php Modal::end(); ?>


<?php if($printGantt): Modal::begin(['id'=>'gant-modal','title'=>'GANTT','size'=>'modal-xl']); ?>
    <!-- <div class="row">
        <div class="col-12">
                <div id="gantt-container" class="gantt" style="width:100%;"></div>
        </div>
    </div> -->
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

$this->registerJS('
    $(document).on("click", ".press-edit-task, .press-view-task", function(e){
        if($(this).hasClass("press-edit-task")){
            $("#update-modal *").prop("disabled", false);
            $("#u-ProjectTaskID").css({display:"block"});
            $("#u-upload").css({display:"block"});
        }else{
            $("#update-modal *").prop("disabled", true);
            $("#u-ProjectTaskID").css({display:"none"});
            $("#u-upload").css({display:"none"});

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

                if(r.File){
                    $("#u-File").attr("href","'.Yii::getAlias('@raizweb') . '/uploads/tasks/'.'"+r.File);
                    $("#u-File").css({display:"unset"});

                }
                $("#update-modal").modal("show");
            }

        });
    
    });

');