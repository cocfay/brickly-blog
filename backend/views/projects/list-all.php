<?php
 
use frontend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap5\Button;
use yii\bootstrap5\Modal;
use yii\bootstrap5\ActiveForm;
use common\components\datatables\DataTables;
use common\components\chosen\Chosen;
$this->title = 'Proyectos';
$this->params['breadcrumbs'][] = $this->title;
?>
 
 
<div class="HomeRole">

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
                            [
                                'attribute' => 'Logo',
                                'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                                'value' => function ($data) {
                                    $url = \Yii::getAlias('@raizweb') . '/uploads/projects/logos/';
                                    return '
                                    <div class="py-1 px-2 d-flex align-items-center m-auto" style="width: 70px; height: 70px; background: var(--bs-table-bg); border-radius: 6%">
                                        <img src="'.$url.$data->Logo.'" alt="" onerror="this.src=\'https://www.weclickdigital.com/images/logo.png\'" style="height: auto; width: 100%; object-fit: contains;">
                                    </div>'; // $data['name'] for array data, e.g. using SqlDataProvider.
                                },
                                'format' => 'raw',
                                'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;'],
                            ],
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
                                        if ($data->account && $data->account->userAccount) {
                                            return $data->account->userAccount->Name;
                                        }
                                        return 'No Client'; // Or return an empty string ''
                                    },
                                    'format' => 'text',
                                    'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;'],
                                ],

                                [
                                'attribute' => 'Tipo',
                                    'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                                    'value' => function ($data) {
                                        return $data->Type; // $data['name'] for array data, e.g. using SqlDataProvider.
                                    },
                                    'format' => 'text',
                                    'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;'],
                                ],
                                [
                                'label' => 'Enlace a desarrollo',
                                    'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                                    'value' => function ($data) {
                                        return "<a href='{$data->LinkDev}' target='_blank'>{$data->LinkDev}</a>"; // 
                                    },
                                    'format' => 'raw',
                                    'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;'],
                                ],
                                [
                                'label' => 'Enlace a producción',
                                    'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                                    'value' => function ($data) {
                                    return "<a href='{$data->LinkPro}' target='_blank'>{$data->LinkPro}</a>";
                                    },
                                    'format' => 'raw',
                                    'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;'],
                                ],

                            [
                                'class' => 'yii\grid\ActionColumn',
                                'header' => 'Acciones',
                                'headerOptions' => ['style' => 'text-align: center;'],
                                'template' => '<div class="btn-group" >{update} {view} {price} {delete} </div>',
                                'buttons' => [
                                    'view' => function($url, $model){
                                        return Html::a('<span class="fa fa-file"></span>', ['project-client-anexos', 'id' => $model->ProjectClientID, 'sid' => $model->ServiceID], ['class' => 'btn btn-info', 'title' => 'Documentos']);
                                    },
                                    'delete' => function($url, $model){
                                        return Html::a('<span class="fa fa-trash"></span>', ['delete', 'id' => $model->ProjectClientID], [
                                            'class' => 'btn btn-danger click-confirm',
                                            'tittle-alert' => 'Eliminar información',
                                            'text-alert'  => '¿Estás seguro? Cuando elimines, no podrás recuperarlo más tarde.',
                                        ]);
                                    },
                                    'price' => function($url, $model){
                                        return Html::a('<span class="fa-solid fa-dollar-sign"></span>', ['/saas/project-client-anexos', 'id' => $model->ProjectClientID, 'sid' => $model->ServiceID, 'type' => 0], ['class' => 'btn btn-warning', 'title' => 'Cotizaciones']);
                                    },
                                    'update' => function($url, $model){
                                        return '<button type="button" class="btn btn-success update" data-id="'.$model->ProjectClientID.'"><i class="fa fa-edit" style="color: white;"></i></button>';
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
                            <?= $form->field($model, 'Type')->dropDownList([
                                'Software a la medida' => 'Software a la medida',
                                'Servicio outsourcing' => 'Servicio outsourcing',
                                'Soporte wordpress' => 'Soporte wordpress',
                                'Aplicaciones móviles' => 'Aplicación móvil',
                                ],['maxlength' => true]); ?>
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
                            <?= $form->field($model, 'uploadedFile')->fileinput(['maxlength' => true, 'class' => 'logo'])->label('Logo'); ?>
                        </div>
                        <div class="previewImg"></div>
                        <div class="col-md-6">   
                            <?= $form->field($model, 'LinkDev')->textInput(['maxlength' => true])->label('Enlace desarrollo');; ?>
                        </div>
                        <div class="col-md-6">   
                            <?= $form->field($model, 'LinkPro')->textInput(['maxlength' => true])->label('Enlace producción');; ?>
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
                        <div class="col-md-6">
                            <?= $form->field($model, 'HoursCompleted')->textInput(); ?>
                        </div>
                        <div class="col-md-6">   
                            <div class="d-flex justify-content-between align-items-center">
                                <?= $form->field($model, 'UseGantt')->checkbox(); ?>
                                <?= $form->field($model, 'ShowDates')->checkbox(); ?>
                            </div>
                        </div>
                        <div class="create-up-gantt row" style="display:none;">
                            <div class="col-md-12">
                                <hr>
                            </div>
                            <div class="col-sm-5">   
                                <?= $form->field($model, 'UrlGantt')->textInput(['maxlength' => true]); ?>
                            </div>
                            <div class="col-sm-2 d-flex justify-content-center align-items-center">   
                                -- o --
                            </div>
                            <div class="col-sm-5">   
                                <?= $form->field($model, 'FileGantt')->fileinput(['maxlength' => true]); ?>
                            </div>
                        </div>
                        <div class="col-12 mt-4 d-flex justify-content-end">   
                            <?= Html::submitButton('Crear proyecto', ['class' => 'btn click-confirm', 'style' => 'background: #FF0351; color: #fff;']) ?>
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
                            <?= $form->field($model, 'Type')->dropDownList([
                                'Software a la medida' => 'Software a la medida',
                                'Servicio outsourcing' => 'Servicio outsourcing',
                                'Soporte wordpress' => 'Soporte wordpress',
                                'Aplicaciones móviles' => 'Aplicación móvil',
                                ],['maxlength' => true,'id'=>'u-Type']); 
                            ?>
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
                            <?= $form->field($model, 'uploadedFile')->fileinput(['maxlength' => true,'id'=>'u-uploadedFile', 'class' => 'logo'])->label('Logo'); ?>
                        </div>
                        <div class="previewImg"></div>
                        <div class="col-md-6">   
                            <?= $form->field($model, 'LinkDev')->textInput(['maxlength' => true,'id'=>'u-LinkDev'])->label('Enlace desarrollo'); ?>
                        </div>
                        <div class="col-md-6">   
                            <?= $form->field($model, 'LinkPro')->textInput(['maxlength' => true,'id'=>'u-LinkPro'])->label('Enlace producción') ?>
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
                        <div class="col-md-6">
                            <?= $form->field($model, 'HoursCompleted')->textInput(['id' => 'u-HoursCompleted']); ?>
                        </div>
                        <div class="col-md-6">   
                            <div class="d-flex justify-content-between align-items-center">
                                <?= $form->field($model, 'UseGantt')->checkbox(['id'=>'u-UseGantt']); ?>
                                <?= $form->field($model, 'ShowDates')->checkbox(['id'=>'u-ShowDate']); ?>
                            </div>
                        </div>
                        <div class="update-up-gantt row" style="display:none;">
                            <div class="col-md-12">
                                <hr>
                            </div>
                            <div class="col-sm-5">   
                                <?= $form->field($model, 'UrlGantt')->textInput(['maxlength' => true,'id'=>'u-UrlGantt']); ?>
                            </div>
                            <div class="col-sm-2 d-flex justify-content-center align-items-center">   
                                -- o --
                            </div>
                            <div class="col-sm-5">   
                                <?= $form->field($model, 'FileGantt')->fileinput(['maxlength' => true, 'id'=>'u-FileGantt']); ?>
                            </div>
                        </div>
                        <div class="col-12 mt-4 d-flex justify-content-between align-items-center">   
                            <?= Html::a('Completar proyecto', ['complete-project', 'id' => ''], ['class' => 'btn btn-secondary click-confirm btn-completed']) ?>
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

    $('#projectsclients-usegantt').change(function(e){
        if($(this).is(':checked')){
            $('.create-up-gantt').show();
        }else{
            $('.create-up-gantt').hide();
        }
    
    })
    $('#u-UseGantt').change(function(e){
        if($(this).is(':checked')){
            $('.update-up-gantt').show();
        }else{
            $('.update-up-gantt').hide();
        }
    
    })
    $(document).on('click','.update', function(e){
        var id = $(this).data('id');
        $('#u-uploadedFile').val('');
        $('#u-ProjectClientID').val('');
        $('#u-Followers').val('');
        $('#u-AccountID').val('');
        $('#u-UseGantt').prop('checked',false);
        $('#u-UrlGantt').val('');
        // CORREGIR ESTAS LÍNEAS:
        $('#u-ShowDate').prop('checked',false);  // Solo esto, eliminar el .val('')
        $('#u-FileGantt').val('');
        $('#u-HoursComplete').val('')
        $('.update-up-gantt').hide();

        $.get('".Url::to(['get-data-project'])."',{ id: id },function(dt){
            if(dt){
            
                $('#u-ProjectClientID').val(dt.ProjectClientID);
                $('#u-Name').val(dt.Name);
                $('#u-Type').val(dt.Type);
                $('#u-LinkDev').val(dt.LinkDev);
                $('#u-LinkPro').val(dt.LinkPro);
                $('#u-UrlGantt').val(dt.UrlGantt);
                $('#u-AccountID').val(dt.AccountID).trigger('chosen:updated');
                $('#u-Followers').val(dt.UsersFollowers).trigger('chosen:updated');
                $('#u-HoursCompleted').val(dt.HoursCompleted)

                if(dt.Completed == 0){
                        $('.btn-completed').text('Completar proyecto')
                    }
                else{
                    $('.btn-completed').text('Reanudar proyecto')
                }

                $('.btn-completed').each(function(){
                    let href = $(this).attr('href');
                    href = href.replace(/id=[^&]*/, 'id=');
                    href = href + dt.ProjectClientID;
                    $(this).attr('href', href);
                })
                    

                // CORREGIR ESTAS LÍNEAS:
                if(dt.UseGantt == 1){
                    $('#u-UseGantt').prop('checked',true);
                    $('.update-up-gantt').show();
                }
                if(dt.ShowDates == 1){  // Usar ShowDate, no ShowDates
                    $('#u-ShowDate').prop('checked',true);  // Solo establecer checked
                }
                
                $('#modal-update').modal('show');
            }
        });
    });

    const imgP = document.querySelectorAll('.logo')
    imgP.forEach((f, i) => {
        const visuImg = document.querySelectorAll('.previewImg')[i]
        f.addEventListener('change', (e) => {
            let img = e.target.files[0]
            if(img){
                visuImg.innerHTML = '';
                visuImg.classList.add('row', 'mx-0', 'px-0', 'justify-content-end', 'mb-4')
                let text = '<div class=\"col-md-6\"><img src=\'' + URL.createObjectURL(img) + '\' style=\'width: 150px; display:block; margin:auto; object-fit: cover\' alt=\'imagen preview\' /></div>'
                visuImg.insertAdjacentHTML('afterbegin', text)
            }
        })
    })
";
$this->registerJS($JS);
?>
