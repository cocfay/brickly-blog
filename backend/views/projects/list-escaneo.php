<?php
 
use frontend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap5\Button;
use yii\bootstrap5\Modal;
use yii\bootstrap5\ActiveForm;
use common\components\datatables\DataTables;
use common\components\chosen\Chosen;
$this->title = 'Proyectos de escaneo y seguridad';
$this->params['breadcrumbs'][] = $this->title;
?>
 
 
<div class="HomeRole">
    <div class="btn-group d-flex flex-column flex-lg-row m-auto mb-4 msaas" style="width: fit-content;">
        <a href="<?= Url::to(['/saas/list-enlatado']) ?>" class="btn btn-secondary">Software enlatado</a>
        <a href="<?= Url::to(['/saas/list-monitoreo']) ?>" class="btn btn-secondary">Servicio de monitoreo</a>
        <a href="<?= Url::to(['/saas/list-escaneo']) ?>" class="btn btn-secondary">Escaneo y seguridad</a>
        <a href="<?= Url::to(['/saas/list-diseweb']) ?>" class="btn btn-secondary">Diseño web</a>
    </div>
    <div class="fs-3 fw-bold mb-4" style="color: var(--bs-dark)"><?= Html::encode($this->title)?></div>
    <button type="button" class="btn mb-5" style="background: #FF0351; color: #fff;" onClick="$('#create-modal').modal('show');"><i class="fa fa-plus"></i> Añadir proyecto</button>

    <div class="row">
        <div class="col-12">
            <?php   
                echo DataTables::widget([
                        'dataProvider' => $ProjectsProvider,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            // Simple columns defined by the data contained in $dataProvider.
                            // Data from the model's column will be used.
                            /* [
                                'attribute' => 'Logo',
                                'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                                'value' => function ($data) {
                                    $url = \Yii::getAlias('@raizweb') . '/uploads/projects/logos/';
                                    return "<img src='{$url}{$data->Logo}' style='height:50px; width:auto;' onError='' />"; // $data['name'] for array data, e.g. using SqlDataProvider.
                                },
                                'format' => 'raw',
                                'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;'],
                            ], */
                            [
                                'label' => 'Nombre del proyecto',
                                    'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                                    'value' => function ($data) {
                                        return $data->Name; // $data['name'] for array data, e.g. using SqlDataProvider.
                                    },
                                    'format' => 'text',
                                    'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;'],
                                ],
                                [
                                'label' => 'Cliente',
                                    'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                                    'value' => function ($data) {
                                        return $data->account->userAccount->Name; // $data['name'] for array data, e.g. using SqlDataProvider.
                                    },
                                    'format' => 'text',
                                    'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;'],
                                ],

                                /* [
                                'attribute' => 'Tipo',
                                    'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                                    'value' => function ($data) {
                                        return $data->Type; // $data['name'] for array data, e.g. using SqlDataProvider.
                                    },
                                    'format' => 'text',
                                    'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;'],
                                ], */
                                /* [
                                'label' => 'Enlace a desarrollo',
                                    'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                                    'value' => function ($data) {
                                        return "<a href='{$data->LinkDev}' target='_blank'>{$data->LinkDev}</a>"; // 
                                    },
                                    'format' => 'raw',
                                    'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;'],
                                ], */
                                /* [
                                'label' => 'Enlace a producción',
                                    'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                                    'value' => function ($data) {
                                    return "<a href='{$data->LinkPro}' target='_blank'>{$data->LinkPro}</a>";
                                    },
                                    'format' => 'raw',
                                    'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;'],
                                ], */

                            [
                                'class' => 'yii\grid\ActionColumn',
                                'header' => 'Acciones',
                                'template' => '<div class="btn-group" > {update} {view} {price} {delete} </div>',
                                'buttons' => [
                                    'view' => function($url, $model){
                                        return Html::a('<span class="fa fa-file"></span>', ['project-client-anexos', 'id' => $model->ProjectClientID, 'sid' => $model->ServiceID], ['class' => 'btn btn-info']);
                                    },
                                    'delete' => function($url, $model){
                                        return Html::a('<span class="fa fa-trash"></span>', ['delete', 'id' => $model->ProjectClientID], [
                                            'class' => 'btn btn-danger click-confirm',
                                            'tittle-alert' => 'Eliminar información',
                                            'text-alert'  => '¿Estás seguro? Cuando elimines, no podrás recuperarlo más tarde.',
                                        ]);
                                    },
                                    'price' => function($url, $model){
                                        return Html::a('<span class="fa-solid fa-dollar-sign"></span>', ['project-client-anexos', 'id' => $model->ProjectClientID, 'sid' => $model->ServiceID, 'type' => 0], ['class' => 'btn btn-warning']);
                                    },
                                    'update' => function($url, $model){
                                        return '<button type="button" class="btn btn-success update" data-id="'.$model->ProjectClientID.'"><i class="fa fa-edit"></i></button>';
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
</div>

<!-- Modal  CREATE-->
<div class="modal" id="create-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content p-4">
            <div class="modal-header">
                <h5 class="modal-title">Crear proyecto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php $form = ActiveForm::begin(['id' => 'create-project-modal', 'method' => 'post']); ?>
                    <div class="row">
                        <div class="col-md-6">   
                            <?= $form->field($model, 'Name')->textInput(['maxlength' => true]); ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'AccountID')->widget(Chosen::classname(), [
                            'items' => $ListClients,
                            'allowDeselect' => true,
                            'disableSearch' => true, // Search input will be disabled
                            'clientOptions' => [
                                'search_contains' => true,
                                'max_selected_options' => 1,
                            ],
                            'multiple' => false,
                            ])->label('Cliente del proyecto'); ?>
                        </div>
                        <div class="col-md-6">   
                            <?= $form->field($model, 'UsersFollowers')->widget(Chosen::classname(), [
                                'items' => $ListUsers,
                                'allowDeselect' => true,
                                'disableSearch' => true, // Search input will be disabled
                                'clientOptions' => [
                                    'search_contains' => true,
                                    'max_selected_options' => 10,
                                ],
                                'multiple' => true,
                            ])->label('Projects Managers'); ?>
                        </div>
                        <div class="col-12 mt-4 d-flex justify-content-end">   
                            <?= Html::submitButton('Crear proyecto', ['class' => 'btn click-confirm', 'style' => 'background: #FF0351; color: #fff;']); ?>
                            <?= $form->field($model, 'Type')->hiddenInput(['value' => 'Escaneo y seguridad'])->label(false) ?>
                        </div>
                    </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal UPDATE-->
<div class="modal" id="modal-update" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content p-4">
            <div class="modal-header">
                <h5 class="modal-title">Actualizar proyecto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php $form = ActiveForm::begin(['id' => 'update-project-modal', 'method' => 'post']); ?>
                    <div class="row">
                        <div class="col-md-6">   
                            <?= $form->field($model, 'Name')->textInput(['maxlength' => true,'id'=>'u-Name']); ?>
                            <?= $form->field($model, 'ProjectClientID')->hiddenInput(['maxlength' => true,'id'=>'u-ProjectClientID'])->label(false); ?>
                        </div>
                        
                        <div class="col-md-6">
                            <?= $form->field($model, 'AccountID')->widget(Chosen::classname(), [
                                'items' => $ListClients,
                                'options' => ['placeholder' => 'seleccione','id'=>'u-AccountID'],
                                'allowDeselect' => true,
                                'disableSearch' => true, // Search input will be disabled
                                'clientOptions' => [
                                    'search_contains' => true,
                                    'max_selected_options' => 1,
                                ],
                                'multiple' => false,
                                ])->label('Cliente del proyecto'); 
                            ?>
                        </div>
                        <div class="col-md-6">   
                            <?= $form->field($model, 'UsersFollowers')->widget(Chosen::classname(), [
                                'items' => $ListUsers,
                                
                                'options' => ['placeholder' => 'seleccione','id'=>'u-Followers'],
                                'allowDeselect' => true,
                                'disableSearch' => true, // Search input will be disabled
                                'clientOptions' => [
                                    'search_contains' => true,
                                    'max_selected_options' => 10,
                                    
                                ],
                                'multiple' => true,


                                ])->label('Projects Managers'); 
                            ?>
                        </div>
                        <div class="col-12 mt-4 d-flex justify-content-end">   
                            <?= Html::submitButton('Actualizar proyecto', ['class' => 'btn click-confirm', 'style' => 'background: #FF0351; color: #fff;']) ?>
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

$JS = "

    
    $(document).on('click','.update', function(e){
        var id = $(this).data('id');
        
        $('#u-ProjectClientID').val('');
        $('#u-Followers').val('');
        $('#u-AccountID').val('');

        $.get('".Url::to(['get-data-project'])."',{ id: id },function(dt){
                //console.log(dt,'Object Received');
                if(dt){
                     $('#u-ProjectClientID').val(dt.ProjectClientID);
                     $('#u-Name').val(dt.Name);
                     $('#u-Type').val(dt.Type);
                     
                     $('#u-AccountID').val(dt.AccountID).trigger('chosen:updated');
                     $('#u-Followers').val(dt.UsersFollowers).trigger('chosen:updated');
                     
                    console.log(dt,'Object Received');
                    $('#modal-update').modal('show');
                    //$('#form_field').trigger('chosen:updated');
                }
        });
    });
";
$this->registerJS($JS);
?>