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

<div class="row mt-4">
    <div class="col-md-8">
        <img src="<?= \Yii::getAlias('@raizweb') . '/uploads/projects/logos/'.$project->Logo; ?>" onError="/" style="height:70px; width:auto;"/> <?= $project->Name; ?>
        <br> 
        <h6>Tipo de proyecto < <?= $project->Type; ?> ></h6>
    </div>
    <div class="col-md-4 d-flex align-items-end justify-content-end">
        <img src="<?= \Yii::getAlias('@raizweb') . '/images/logo.png'; ?>" onError="/" style="height:70px; width:auto;"/> 
    </div>
    <div class="col-md-12">
        <hr>
    </div>
</div>
<?php if($printGantt): ?>
    <div class="row mt-4">
        <div class="col-md-8">
            <h2 class="text-success">GANTT</h2>
        </div>
    </div>
<div class="row">
    <div class="col-12">
            <div id="gantt-container" class="gantt" style="width:100%;"></div>
    </div>
    <div class="col-md-12">
        <hr>
    </div>
</div>
<?php endif;?>

<?php 

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

        $tasksGantt[] = (Object)[
                        "name" => $it->Title,
                        "desc" => "",
                        "id" => $it->ProjectTaskID,
                        "values" =>[(Object)[
                            'from' => date('Y-m-d H:i:s',strtotime($it->EstimatedStart)),
                            'to' =>  date('Y-m-d H:i:s',strtotime($it->EstimatedEnd)),
                            'label' => $complete."% completado",
                            'desc' => "<b>".$it->Title."</b><br> Duración estimada: ".$message."<br> Desde: ".date('d/m/Y',strtotime($it->EstimatedStart))."<br> Hasta: ".date('d/m/Y',strtotime($it->EstimatedEnd))."<br> Descripión: ".$it->Description."<br>Completado: ".$complete."%",
                            'customClass'=> $cLabelClass,
                            
                        ]]
                ];

    endforeach;
    $tasksGantt = json_encode($tasksGantt);
    $JS = <<<JS
     var projectTasks = $tasksGantt;


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
    JS;
    
    $this->registerJS($JS, \yii\web\View::POS_END, 'my-options');
}

