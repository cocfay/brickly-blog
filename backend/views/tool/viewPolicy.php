<?php
    use yii\helpers\Html;
    use yii\helpers\Url;
    use yii\bootstrap5\ActiveForm;
    use common\components\datatables\DataTables;
    $this->title = 'Políticas de seguridad';

    $listCap = [
        'Apache' => 'Apache',
        'php.ini' => 'php.ini',
        'Virtual' => 'Virtual',
        '.htaccess' => '.htaccess',
        'WAF' => 'WAF',
        'Plugin' => 'Plugin',
    ];
    $listTip = [
        'General' => 'General',
        'Yii' => 'Yii',
        'Wordpress' => 'Wordpress'
    ];
?>

<div style="color: var(-bs-dark)">
    <h3><?= $this->title ?></h3>
    <div class="d-flex gap-3 align-items-center mt-3 mb-5">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addws"><i class="fa-solid fa-plus me-2"></i> Agregar política</button>
    </div>
    <?php
        $column[] = [
            'class' => 'yii\grid\SerialColumn', 'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;']
        ];

         $column[] = [
            'attribute' => 'Nombre',
            'format' => 'text',
            'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;'],
        ];

        $column[] = [
            'attribute' => 'Capa',
            'format' => 'text',
            'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;'],
        ];

        $column[] = [
            'attribute' => 'Tipo',
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
                        'data-id' => $model->PolicySecureID
                    ]);
                },
                'delete' => function($url, $model){
                return Html::a('<span class="fa fa-trash"></span>', ['delete-pliz', 'id' => $model->PolicySecureID, 'type' => true], [
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
                "dom"=> 'lfTrtip',
                "tableTools"=>[
                    "aButtons"=> [  
                        // [
                        // "sExtends"=> "copy",
                        // "sButtonText"=> Yii::t('app',"Copy to clipboard")
                        // ],
                        // [
                        // "sExtends"=> "csv",
                        // "sButtonText"=> Yii::t('app',"Save to CSV")
                        // ],
                        // [
                        // "sExtends"=> "xls",
                        // "oSelectorOpts"=> ["page"=> 'current'],
                        // ],[
                        // "sExtends"=> "pdf",
                        // "sButtonText"=> Yii::t('app',"Save to PDF")
                        // ],[
                        // "sExtends"=> "print",
                        // "sButtonText"=> Yii::t('app',"Print")
                        // ],
                    ]
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
                    <?= $form->field($model, 'Nombre')->textInput() ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'Capa')->dropDownList($listCap) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'Tipo')->dropDownList($listTip) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'Descripcion')->textarea(['style' => 'min-height: 120px;']) ?>
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
                    <?= $form->field($model, 'Nombre')->textInput(['id' => 'e-nombre']) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'Capa')->dropDownList($listCap, ['id' => 'e-capa']) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'Tipo')->dropDownList($listTip, ['id' => 'e-tipo']) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'Descripcion')->textarea(['id' => 'e-descripcion', 'style' => 'min-height: 120px;']) ?>
                </div>
            </div>
            <div class="modal-footer">
            <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
            <?= $form->field($model, 'PolicySecureID')->hiddenInput(['id' => 'e-id'])->label(false) ?>
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
            $.post('$url', {id: id, type: 'policy'}, function(resp){
                
                resp = JSON.parse(resp);
                $('#e-nombre').val(resp.Nombre);
                $('#e-capa').val(resp.Capa);
                $('#e-tipo').val(resp.Tipo);
                $('#e-descripcion').val(resp.Descripcion);
                $('#e-id').val(resp.PolicySecureID);
                $('#edit-modal').modal('show');
            });
        });
    JS;
    
    $this->registerJS($JS);
?>