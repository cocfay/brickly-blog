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
    <h2 style="color: var(--color-principal);"><?= Html::encode($this->title)?></h2>
    <div>
        <button type="button" class="btn btn-color-especial" onClick="$('#create-modal').modal('show');"><i class="fa fa-plus"></i> Añadir proyecto</button>
    </div>
    <br> 
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h3>Usuario: <?= $Client->UserName; ?><small> < <?= $Client->typeUsers->Name; ?> > </small></h3>
            </div>
        </div>
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
                                        return "<img src='{$url}{$data->Logo}' style='height:50px; width:auto;' onError='' />"; // $data['name'] for array data, e.g. using SqlDataProvider.
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
                                    'template' => '<div class="btn-group" > {update} {delete} </div>',
                                    'buttons' => [
                                        'delete' => function($url, $model){
                                            return Html::a('<span class="fa fa-trash"></span>', ['delete', 'id' => $model->ProjectClientID], [
                                                'class' => 'btn btn-danger click-confirm',
                                                'tittle-alert' => 'Eliminar información',
                                                'text-alert'  => '¿Estás seguro? Cuando elimines el rol, no podrás recuperarlo más tarde.',
                                            ]);
                                        },
                                        'update' => function($url, $model){
                                            return '<button type="button" class="btn btn-color-especial update" data-id="'.$model->ProjectClientID.'"><i class="fa fa-edit"></i></button>';
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
</div>

<!-- Modal  CREATE-->
<?php Modal::begin(['id'=>'create-modal','title'=>'Crear proyecto']); ?>
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'],'id' => 'create-project-modal', 'method' => 'post']); ?>
        <!-- Modal content-->
                <div class="row">
                    <div class="col-sm-8">   
                        <?= $form->field($model, 'Name')->textInput(['maxlength' => true]); ?>
                    </div>
                    <div class="col-sm-4">   
                        <?= $form->field($model, 'Type')->dropDownList(['Personalizado'=>'Personalizado',
                                                                        'SAAS' => 'SAAS',
                                                                        'Outsourcing' => 'Outsourcing',
                                                                        ],['maxlength' => true]); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">   
                        <?= $form->field($model, 'uploadedFile')->fileinput(['maxlength' => true])->label('Logo'); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">   
                        <?= $form->field($model, 'LinkDev')->textInput(['maxlength' => true]); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">   
                        <?= $form->field($model, 'LinkPro')->textInput(['maxlength' => true]); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">   
                        <?= $form->field($model, 'UsersFollowers')->widget(Chosen::classname(), [
                                                                        'items' => $ListUsers,
                                                                        'allowDeselect' => true,
                                                                        'disableSearch' => true, // Search input will be disabled
                                                                        'clientOptions' => [
                                                                            'search_contains' => true,
                                                                            'max_selected_options' => 10,
                                                                        ],
                                                                        'multiple' => true,


                                                                        ])->label('Seguidores del proyecto'); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">   
                        <?= $form->field($model, 'UseGantt')->checkbox(['maxlength' => true]); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-5">   
                        <?= $form->field($model, 'UrlGantt')->textInput(['maxlength' => true]); ?>
                    </div>
                    <div class="col-sm-2">   
                        -- o --
                    </div>
                    <div class="col-sm-5">   
                        <?= $form->field($model, 'FileGantt')->fileinput(['maxlength' => true]); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">   
                        <?= Html::submitButton('Crear', ['class' => 'btn btn-info click-confirm']) ?>
                    </div>
                </div>
        <?php ActiveForm::end(); ?>
<?php Modal::end(); ?>

<!-- Modal UPDATE-->
<?php Modal::begin(['id'=>'modal-update','title'=>'Actualizar proyecto']); ?>
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'], 'id' => 'update-project-modal', 'method' => 'post']); ?>
        <!-- Modal content-->
                <div class="row">
                    <div class="col-sm-8">   
                        <?= $form->field($model, 'Name')->textInput(['maxlength' => true,'id'=>'u-Name']); ?>
                        <?= $form->field($model, 'ProjectClientID')->hiddenInput(['maxlength' => true,'id'=>'u-ProjectClientID'])->label(false); ?>

                    </div>
                    <div class="col-sm-4">   
                        <?= $form->field($model, 'Type')->dropDownList(['Personalizado'=>'Personalizado',
                                                                        'SAAS' => 'SAAS',
                                                                        'Outsourcing' => 'Outsourcing',
                                                                        ],['maxlength' => true,'id'=>'u-Type']); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">   
                        <?= $form->field($model, 'uploadedFile')->fileinput(['maxlength' => true,'id'=>'u-uploadedFile'])->label('Logo'); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">   
                        <?= $form->field($model, 'LinkDev')->textInput(['maxlength' => true,'id'=>'u-LinkDev']); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">   
                        <?= $form->field($model, 'LinkPro')->textInput(['maxlength' => true,'id'=>'u-LinkPro']); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">   
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


                                                                        ])->label('Seguidores del proyecto'); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">   
                        <?= $form->field($model, 'UseGantt')->checkbox(['id'=>'u-UseGantt']); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-5">   
                        <?= $form->field($model, 'UrlGantt')->textInput(['maxlength' => true,'id'=>'u-UrlGantt']); ?>
                    </div>
                    <div class="col-sm-2">   
                        -- o --
                    </div>
                    <div class="col-sm-5">   
                        <?= $form->field($model, 'FileGantt')->fileinput(['maxlength' => true, 'id'=>'u-FileGantt']); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">   
                        <?= Html::submitButton('Actualizar', ['class' => 'btn btn-info click-confirm']) ?>
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

$JS = "
    $(document).on('click','.update', function(e){
        var id = $(this).data('id');
        $('#u-uploadedFile').val('');
        $('#u-ProjectClientID').val('');
        $('#u-UrlGantt').val('');
        $('#u-FileGantt').val('');
        $('#u-Followers').val('');
        $('#u-UseGantt').prop('checked',false);
        $.get('".Url::to(['get-data-project'])."',{ id: id },function(dt){
                console.log(dt,'Object Received');
                if(dt){
                     $('#u-ProjectClientID').val(dt.ProjectClientID);
                     $('#u-Name').val(dt.Name);
                     $('#u-Type').val(dt.Type);
                     $('#u-LinkDev').val(dt.LinkDev);
                     $('#u-LinkPro').val(dt.LinkPro);
                    $('#u-UrlGantt').val(dt.UrlGantt);

                     $('#u-Followers').val(dt.UsersFollowers).trigger('chosen:updated');

                     if(dt.UseGantt == 1){
                        $('#u-UseGantt').prop('checked',true);
                     }

                     $('#modal-update').modal('show');

                    //  $('#form_field').trigger('chosen:updated');
                }
        });
    });
";
$this->registerJS($JS);
?>