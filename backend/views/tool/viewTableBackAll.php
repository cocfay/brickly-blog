<?php
    use yii\helpers\Html;
    use yii\helpers\Url;
    use yii\bootstrap5\ActiveForm;
    use common\components\datatables\DataTables;
    $this->title = 'Listado de backups programados';

    $visible = false;

    $Environment = [
        'Producción' => 'Producción',
        'Desarrollo' => 'Desarrollo',
        'Demo' => 'Demo',
        'Base de datos' => 'Base de datos',
    ];
?>

<div style="color: var(-bs-dark)">
    <div class="d-flex justify-content-between align-items-center">
        <h3><?= $this->title ?></h3>
        <a href="<?= Url::to(['backup-list']) ?>" title="Atrás"><i class="fa-regular fa-circle-left fs-1" style="color: #FF0461"></i></a>
    </div>
    <div class="d-flex gap-3 align-items-center mt-3 mb-5">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addws"><i class="fa-solid fa-file me-2"></i> Agregar registro</button>
    </div>

    <div class="accordion mb-5" id="accordionExample" style="width: min(600px, 100%)">
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                Código de producción
            </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <p>Servidor: 64.23.190.223</p>
                    <p>
                        <strong>Rotativo Diario, Semanal y Mensual:</strong> <br>
                        /mnt/awsS3pro/rotativos/daily/ <br>
                        /mnt/awsS3pro/rotativos/monthly/ <br>
                        /mnt/awsS3pro/rotativos/ weekly/ <br>
                    </p>
                    <p>
                        <strong>Semana:</strong> <br>
                        /mnt/awsS3pro/semana/lunes/ <br>
                        /mnt/awsS3pro/semana/martes/ <br>
                        ... <br>
                        /mnt/awsS3pro/semana/sabado/ <br>
                        /mnt/awsS3pro/semana/domingo/ <br>
                    </p>
                    <p>
                        <strong>Quincena:</strong> <br>
                        /mnt/awsS3pro/quincena/enero/ <br>
                        /mnt/awsS3pro/quincena/febrero/ <br>
                        /mnt/awsS3pro/quincena/etc../ <br>
                    </p>
                    <p>
                        <strong>Mensual:</strong> <br>
                        /mnt/awsS3pro/mes/enero/ <br>
                        /mnt/awsS3pro/mes/febrero/ <br>
                        /mnt/awsS3pro/mes/etc../ <br>
                    </p>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingTwo">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                Código de desarrollo
            </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <p>Servidor: 64.23.230.34</p>
                    <p>
                        <strong>Rotativo Diario, Semanal y Mensual:</strong> <br>
                        /mnt/awsS3dev/desarrollo/rotativos/daily/ <br>
                        /mnt/awsS3dev/desarrollo/rotativos/monthly/ <br>
                        /mnt/awsS3dev/desarrollo/rotativos/ weekly/ <br>
                    </p>
                    <p>
                        <strong>Semana:</strong> <br>
                        /mnt/awsS3dev/desarrollo/semana/lunes/ <br>
                        /mnt/awsS3dev/desarrollo/semana/martes/ <br>
                        ... <br>
                        /mnt/awsS3dev/desarrollo/semana/sabado/ <br>
                        /mnt/awsS3dev/desarrollo/semana/domingo/ <br>
                    </p>
                    <p>
                        <strong>Quincena:</strong> <br>
                        /mnt/awsS3dev/desarrollo/quincena/enero/ <br>
                        /mnt/awsS3dev/desarrollo/quincena/febrero/ <br>
                        /mnt/awsS3dev/desarrollo/quincena/etc../ <br>
                    </p>
                    <p>
                        <strong>Mensual:</strong> <br>
                        /mnt/awsS3dev/desarrollo/mes/enero/ <br>
                        /mnt/awsS3dev/desarrollo/mes/febrero/ <br>
                        /mnt/awsS3dev/desarrollo/mes/etc../ <br>
                    </p>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingThree">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                Código de demo
            </button>
            </h2>
            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <p>Servidor: 64.23.230.34</p>
                    <p>
                        <strong>Rotativo Diario, Semanal y Mensual:</strong> <br>
                        /mnt/awsS3dev/desarrollo/rotativos/daily/ <br>
                        /mnt/awsS3dev/desarrollo/rotativos/monthly/ <br>
                        /mnt/awsS3dev/desarrollo/rotativos/ weekly/ <br>
                    </p>
                    <p>
                        <strong>Mensual:</strong> <br>
                        /mnt/awsS3dev/demo/mes/enero/ <br>
                        /mnt/awsS3dev/demo/mes/febrero/ <br>
                        /mnt/awsS3dev/demo/mes/etc../ <br>
                    </p>
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingFour">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                Código de base de datos 
            </button>
            </h2>
            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <p>Servidor: 64.23.230.34</p>
                    <p>
                        <strong>Rotativo Diario, Semanal y Mensual:</strong> <br>
                        /mnt/awsS3db/rotativos/daily/ <br>
                        /mnt/awsS3db/rotativos/monthly/ <br>
                        /mnt/awsS3db/rotativos/ weekly/ <br>
                    </p>
                    <p>
                        <strong>Semana:</strong> <br>
                        /mnt/awsS3db/semana/lunes/ <br>
                        /mnt/awsS3db/semana/martes/ <br>
                        ... <br>
                        /mnt/awsS3db/semana/sabado/ <br>
                        /mnt/awsS3db/semana/domingo/ <br>
                    </p>
                    <p>
                        <strong>Quincena:</strong> <br>
                        /mnt/awsS3db/quincena/enero/ <br>
                        /mnt/awsS3db/quincena/febrero/ <br>
                        /mnt/awsS3db/quincena/etc../ <br>
                    </p>
                    <p>
                        <strong>Mensual:</strong> <br>
                        /mnt/awsS3db/mes/enero/ <br>
                        /mnt/awsS3db/mes/febrero/ <br>
                        /mnt/awsS3db/mes/etc../ <br>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <?php
        $column[] = [
            'class' => 'yii\grid\SerialColumn', 'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;']
        ];

         $column[] = [
            'attribute' => 'Descripcion',
            'format' => 'text',
            'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;'],
        ];

        $column[] = [
            'attribute' => 'Environment',
            'format' => 'text',
            'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;']
        ];

        $column[] = [
            'class' => 'yii\grid\ActionColumn',
            'header' => 'Acciones',
            'template' => '<div class="btn-group"> {edit} {delete} </div>',
            'buttons' => [
                'edit' => function($url, $model){
                    return Html::button('<span class="fa fa-edit"></span>', [
                        'class' => "btn btn-edit btn-success",
                        'title' => 'Editar',
                        'data-id' => $model->ProjectWeclickID
                    ]);
                },
                'delete' => function($url, $model){
                return Html::a('<span class="fa fa-trash"></span>', ['delete-pliz', 'id' => $model->ProjectWeclickID], [
                    'class' => 'btn btn-danger click-confirm',
                    'title-alert' => 'Eliminar registro',
                    'text-alert'  => '¿Estás seguro?',
                    'title' => 'Eliminar'
                ]);
                },
            
            ],
            'contentOptions'=>['style'=>'min-width: 100px; text-align: center; vertical-align:middle;'],
        ];

        echo DataTables::widget([
            'dataProvider' => $dataProvider,
            'columns' => $column,
            'clientOptions' => [
                "lengthMenu"=> [[10,20,30,-1], [10,20,30,Yii::t('app',"All")]],
                "info"=>false,
                "retrieve" => true,
                "responsive"=>'true', 
                "dom"=> 'lfTrBtip',
                "ButtonExportData"=>[
                    // "aButtons"=> ['excel'=>['text'=>'Descargar excel'],'pdf'=>['text'=>'Descargar PDF'],'csv']
                    "aButtons"=> ['excel']  
                ],'language'=>[
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

    <!-- Add Modal -->
    <div class="modal fade" id="addws" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
        <?php $form = ActiveForm::begin() ?>
        <div class="modal-content p-4">
            <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Formulario</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body row">
                <div class="col-md-6">
                    <?= $form->field($model, 'Descripcion')->textInput() ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'Environment')->dropDownList($Environment) ?>
                </div>
            </div>
            <div class="modal-footer">
            <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
            <button type="submit" class="btn btn-primary">Agregar</button>
            </div>
        </div>
        <?php ActiveForm::end() ?>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="edit-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
        <?php $form = ActiveForm::begin() ?>
        <div class="modal-content p-4">
            <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Formulario</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body row">
                <div class="col-md-6">
                    <?= $form->field($model, 'Descripcion')->textInput(['id' => 'e-descripcion']) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'Environment')->dropDownList($Environment, ['id' => 'e-environment']) ?>
                </div>
            </div>
            <div class="modal-footer">
            <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
            <?= $form->field($model, 'ProjectWeclickID')->hiddenInput(['id' => 'e-id'])->label(false) ?>
            <button type="submit" class="btn btn-primary">Editar</button>
            </div>
        </div>
        <?php ActiveForm::end() ?>
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

    if(Yii::$app->session->hasFlash('error')):
        $this->registerJS('
            $(document).ready(function(){
                _Message("error","¡Error!","'.Yii::$app->session->getFlash('error').'");
            });
        ');
    endif;

    $url = Url::to(['get-data-ajax']);
    $JS = <<<JS
        // Usar delegación de eventos en un elemento padre estático
        $(document).on('click', '.btn-edit', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            $.post('$url', {id: id}, function(resp){
                resp = JSON.parse(resp);
                $('#e-descripcion').val(resp.Descripcion);
                $('#e-environment').val(resp.Environment);
                $('#e-id').val(resp.ProjectWeclickID);
                $('#edit-modal').modal('show');
            });
        });
    JS;
    
    $this->registerJS($JS);
?>