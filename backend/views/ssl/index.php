<?php
 
use frontend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap5\Button;
use yii\bootstrap5\Modal;
use yii\bootstrap5\ActiveForm;
use common\components\datatables\DataTables;
use common\components\chosen\Chosen;
$this->title = 'Lista de correos';
$this->params['breadcrumbs'][] = $this->title;
?>
 
 
<div class="HomeRole">

    <div class="d-flex justify-content-between mb-2">
        <div class="fs-3 fw-bold mb-2" style="color: var(--bs-dark)"><?= Html::encode($this->title)?> <?= !empty($t) ? 'dominios' : 'sitios webs'; ?></div>
        <a href="<?= Yii::$app->request->referrer ?>"><i class="fa-regular fa-circle-left fs-2" style="color: #FF0351;"></i></a>
    </div>
   
    <button type="button" class="btn mb-5" style="background: #FF0351; color: #fff;" onClick="$('#create-modal').modal('show');"><i class="fa fa-plus me-2"></i> Añadir correo</button>
        

    <div class="row">
        <div class="col-12">
            <?php   
                echo DataTables::widget([
                        'dataProvider' => $ProjectsProvider,
                        'columns' => [
                            [
                                'class' => 'yii\grid\SerialColumn', 
                                'headerOptions' => ['style' => 'width: 10.33%;'],
                                'contentOptions' => ['style' => 'width: 10.33%; text-align: center; vertical-align: middle;']
                            ],
                            [
                                'label' => 'Correo Electrónico',
                                'class' => 'yii\grid\DataColumn',
                                'value' => function ($data) {
                                    return $data->Mail;
                                },
                                'format' => 'text',
                                'headerOptions' => ['style' => 'width: 43.33%;'],
                                'contentOptions' => ['style' => 'width: 43.33%; text-align: center; vertical-align: middle;']
                            ],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'header' => 'Acciones',
                                'headerOptions' => ['style' => 'width: 43.33%;'],
                                'contentOptions' => ['style' => 'width: 43.33%; text-align: center; vertical-align: middle;'],
                                'template' => '<div class="btn-group">{update} {delete}</div>',
                                'buttons' => [
                                    'delete' => function($url, $model){
                                        return Html::a('<span class="fa fa-trash"></span>', ['delete', 'id' => $model->EmailID], [
                                            'class' => 'btn btn-danger click-confirm',
                                            'tittle-alert' => 'Eliminar información',
                                            'text-alert'  => '¿Estás seguro? Cuando elimines, no podrás recuperarlo más tarde.',
                                        ]);
                                    },
                                    'update' => function($url, $model){
                                        return '<button type="button" class="btn btn-success update" data-id="'.$model->EmailID.'"><i class="fa fa-edit"></i></button>';
                                    }
                                ],
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
</div>

<!-- Modal  CREATE-->
<div class="modal" id="create-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content p-4">
            <div class="modal-header">
                <h5 class="modal-title">Formulario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php $form = ActiveForm::begin(['id' => 'create-project-modal', 'method' => 'post']); ?>
                    <div class="row">
                        <div class="col-md-12">   
                            <?= $form->field($model, 'Mail')->textInput(['maxlength' => true]); ?>
                        </div>
                        <div class="col-12 mt-4 d-flex justify-content-end">   
                            <?= Html::submitButton('Guardar', ['class' => 'btn', 'style' => 'background: #FF0351; color: #fff;']); ?>
                        </div>
                    </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal UPDATE-->
<div class="modal" id="modal-update" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content p-4">
            <div class="modal-header">
                <h5 class="modal-title">Formulario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php $form = ActiveForm::begin(['id' => 'update-project-modal', 'method' => 'post']); ?>
                    <div class="row">
                        <div class="col-md-12">   
                            <?= $form->field($model, 'Mail')->textInput(['maxlength' => true,'id'=>'u-Mail']); ?>
                            <?= $form->field($model, 'EmailID')->hiddenInput(['maxlength' => true,'id'=>'u-EmailID'])->label(false); ?>
                        </div>
                        <div class="col-12 mt-4 d-flex justify-content-end">   
                            <?= Html::submitButton('Modificar', ['class' => 'btn click-confirm', 'style' => 'background: #FF0351; color: #fff;']) ?>
                        </div>
                    </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>


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

$url = Url::to(['get-data-ajax']);
$JS = <<<JS
    $(document).on('click','.update', function(e){
        var id = $(this).data('id');
        
        $.post("$url",{id: id},function(dt){
            if(dt){
                dt = JSON.parse(dt)
            
                    $('#u-EmailID').val(dt.EmailID);
                    $('#u-Mail').val(dt.Mail);

                //console.log(dt,'Object Received');
                $('#modal-update').modal('show');
                //$('#form_field').trigger('chosen:updated');
            }
        });
    });
JS;
$this->registerJS($JS);
?>