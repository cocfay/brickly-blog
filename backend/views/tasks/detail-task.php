<?php
 
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap5\Modal;
use yii\bootstrap5\Button;
use yii\bootstrap5\ActiveForm;
use common\components\datatables\DataTables;
$this->title = $Task->project->Name." | ".$Task->Title;
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row mt-4">
    <div class="col-md-8">
        <div class="d-flex align-items-center gap-3 mb-4">
            <div style="background: var(--bg-catalog); border-radius: 5px;" class="p-2">
                <img src="<?= \Yii::getAlias('@raizweb') . '/uploads/projects/logos/'.$Task->project->Logo; ?>" onError="this.src='https://dev.mydesk.digital/NewWeclickUp/images/logo.png'" class="d-block" style="height:70px; width: 70px; object-fit: contains; border-radius: 6%"/> 
            </div>
            <span style="color: var(--bs-dark);"><?= $Task->project->Name; ?></span>
        </div>
        <h6>Tipo de proyecto < <?= $Task->project->Type; ?> ></h6>
    </div>
    <div class="col-md-12">
        <hr>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-4" style="color: var(--bs-dark);">
        Usuario asignado: <b><?= $Task->account->userAccount->UserName; ?></b>
    </div>
    <div class="col-md-4" style="color: var(--bs-dark);">
        Fecha estimada de inicio: <b><?= date('d/m/Y h:i a',strtotime($Task->EstimatedStart)); ?></b>
    </div>
    <div class="col-md-4" style="color: var(--bs-dark);">
        Fecha estimada de entrega: <b class="<?= $textStatusClass; ?>"><?= date('d/m/Y h:i a',strtotime($Task->EstimatedEnd)); ?></b>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-4" style="color: var(--bs-dark);">
        <div class="mb-2">Titulo:</div>
        <span class="form-control"><?= $Task->Title; ?></span>
    </div>
    <div class="col-md-4" style="color: var(--bs-dark);">
        <div class="mb-2">Descripción: </div><span class="form-control"><?= $Task->Description; ?></span>
    </div>
    <div class="col-md-4" style="color: var(--bs-dark);">
        <div class="mb-2">Adjunto:</div>
        <?php if($Task->File): ?> <b><a href="<?= Yii::getAlias('@raizweb') . '/uploads/tasks/'.$Task->File; ?>" download="<?= $Task->Title." - ".$Task->File?>">Descargar adjunto</a> </b><?php endif; ?>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <hr>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        <?php if($Task->Status != 2): ?>
            <h6>Acciones</h6>
            <?php $form = ActiveForm::begin() ?>
                <!-- <div class="btn-group"> -->
                    <?php 
                    $status = 2;
                    foreach($Task->activity as $log){
                        $status = $log->Status;
                    } ?>
                    <?php if($status == 2): ?>
                        <button type="submit" name="actBtn" value="1" class="btn me-3 btn-success" title="iniciar"><i class="fa fa-play"></i></button>
                    <?php elseif ($status == 1): ?>
                        <button type="submit" name="actBtn" value="2" class="btn btn-info me-3" title="pausar" ><i class="fa fa-pause"></i></button>
                    <?php endif ?>
                    <button type="submit" name="actBtn" value="3" class="btn btn-danger me-3" title="finalizar"><i class="fa fa-stop"></i></button>
                    <?php if(!empty($Task->project->HoursCompleted)): ?>
                        <div class="modal" tabindex="-1" id="addHours" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Información adicional</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <?php 
                                            $result = 0;
                                            foreach($Task->project->tasks as $hours){
                                                $result += $hours->HoursWorked;
                                            } 
                                            $result = $Task->project->HoursCompleted - $result;
                                        ?>
                                        <div class="mt-0 mb-2 fs-5">Horas restantes: <?= $result ?></div>
                                        <hr>
                                        <?= $form->field($Task, 'HoursWorked')->textInput() ?>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Guardar</button>
                                        <input type="hidden" name="actBtn" value="3">
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif ?>
                    <a class="btn btn-warning" title="transferir" onClick="$('#transfer-modal').modal('show');"><i class="fa fa-arrow-right-arrow-left"></i></a>
                <!-- </div> -->
            <?php ActiveForm::end() ?>
        <?php endif ?>
    </div>
    <div class="col-md-4 d-flex align-items-center">
       <h4> Estado de la tarea: <span class="<?= $textStatusClass; ?>"><?= $textStatus; ?></span></h4>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <hr>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <h3>Comentarios <small><button class="btn btn-info btn-sm" onClick="$('#comment-modal').modal('show');"><i class="fa fa-plus"></i></button></small></h3>
        <hr>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col" style="width:20%">Usuario</th>
                    <th scope="col" style="width:50%">Comentario</th>
                    <th scope="col" style="width:20%">Fecha</th>
                    <th scope="col" style="width:10%"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($Task->comments as $comment): ?>
                    <tr>
                        <td><?= $comment->account->userAccount->UserName; ?></td>
                        <td>
                                <?= $comment->Comment; ?>
                                <?php if($comment->File): ?>
                                    <br>
                                    <a href="<?= $comment->File; ?>" download >Descargar Adjunto</a>
                                <?php endif; ?>
                        </td>
                        <td><?= date('d/m/Y h:i a',strtotime($comment->DateCreate)); ?></td>
                        <td><?php if($UserData->AccountID == $comment->AccountID): ?><a href="<?= Url::to(['delete-comment','id'=>$comment->TaskCommentID]); ?>"><i class="fa fa-trash text-danger"></i></a><?php endif; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="col-md-6">
        <h3>Actividad en la tarea</h3>
        <hr>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col" style="width:25%">Iniciado</th>
                    <th scope="col" style="width:25%">Finalizado</th>
                    <th scope="col" style="width:20%">Usuario</th>
                    <th scope="col" style="width:30%"></th>
                </tr>
            </thead>
            <tbody>
                    <?php foreach($Task->activity as $act): ?>
                    <?php date('d/m/Y h:i a',strtotime($act->StartDate)); ?>
                    <tr>
                        <td> <?= ($act->StartDate)? date('d/m/Y h:i a',strtotime($act->StartDate)) : ''; ?> </td>
                        <td> <?= ($act->EndDate)? date('d/m/Y h:i a',strtotime($act->EndDate)) : ''; ?> </td>
                        <td> <?= $act->account->userAccount->UserName; ?> </td>
                        <td> <?= $act->TextAction; ?> </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php Modal::begin(['id'=>'transfer-modal','title'=>'Transferir tarea','size'=>'modal-lg']); ?>
        <?php $form = ActiveForm::begin(['id' => 'transfer-task-modal', 'method' => 'post']); ?>
        <!-- Modal content-->
                <div class="row">
                    <div class="col-12">
                        <!-- <label for="" class="form-label">Transferir a</label>
                        <select name="" id="" class="form-control">
                            <option value="">Usuario</option>
                            <option value="">Usuario</option>
                            <option value="">Usuario</option>
                        </select> -->
                        <?= $form->field($Task, 'AccountID')->dropDownList($listUsers)->label('Transferir a') ?>
                    </div>
                    <div class="col-12 mt-4">
                        <button type="submit" class="btn btn-primary" name="actBtn" value="4">Asignar</button>
                    </div>
                </div>
        <?php ActiveForm::end(); ?>
<?php Modal::end(); ?>

<?php Modal::begin(['id'=>'comment-modal','title'=>'Dejar comentario','size'=>'modal-md']); ?>
        <?php $form = ActiveForm::begin(['id' => 'transfer-task-modal', 'method' => 'post']); ?>
        <!-- Modal content-->
                <div class="row">
                    <div class="col-12">
                        <?= $form->field($modalComments, 'Comment')->textarea() ?>
                    </div>
                    <div class="col-sm-12">   
                        <?= $form->field($modalComments, 'uploadedFile')->fileinput(['maxlength' => true])->label('Adjunto'); ?>
                    </div>
                    <div class="col-12 mt-4">
                        <button type="submit" class="btn btn-primary">Enviar</button>
                    </div>
                </div>
        <?php ActiveForm::end(); ?>
<?php Modal::end(); ?>

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


    if(!empty($Task->project->HoursCompleted)){
        $JS = <<<JS
            const btn = document.querySelector(".btn-danger")
            btn.addEventListener("click", function(e){
                e.preventDefault()
                $('#addHours').modal('show')
            })
        JS;

        $this->registerJS($JS);
    }

?>