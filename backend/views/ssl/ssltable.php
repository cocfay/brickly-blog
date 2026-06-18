<?php
    use yii\helpers\Html;
    use yii\helpers\Url;
    use yii\bootstrap5\ActiveForm;
    use common\components\datatables\DataTables;
    $this->title = 'Sitios web proximo a vencer';

    if(isset($dominio)){
        $active1 = ''; 
        $active2 = 'active';
    }else{
        $active1 = 'active'; 
        $active2 = '';
    } 
?>

<div style="color: var(-bs-dark)">
    <div class="btn-group mb-3 d-flex justify-content-center m-auto" style="width: fit-content;">
        <a href="<?= Url::to(['ssl-reminder']) ?>" class="btn btn-secondary <?= $active1 ?>">Certificados</a>
        <a href="<?= Url::to(['dominio-reminder']) ?>" class="btn btn-secondary <?= $active2 ?>">Dominios</a>
    </div>
    <h3><?= isset($dominio) ? 'Dominios' : 'Sitios webs certificado SSL' ?></h3>
    <div class="d-flex gap-3 align-items-center mt-3 mb-5">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addws"><i class="fa-solid fa-earth-americas me-2"></i> Agregar dirección web</button>
        <?php $c = isset($dominio) ? ['ssl/', 't' => 1] : ['ssl/'] ?>
        <a href="<?= Url::to($c) ?>" class="btn btn-info"><i class="fa-solid fa-envelope me-2"></i> Correos</a>
    </div>
    <?php
        $column[] = [
            'class' => 'yii\grid\SerialColumn', 'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;']
        ];

        $column[] = [
            'label' => 'Url',
            'class' => 'yii\grid\DataColumn',
            'value' => function ($data) {
                return $data->Text;
            },
            'format' => 'text',
            'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;'],
        ];

        if(!isset($dominio)){
            $column[] = [
                'label' => 'IP',
                'class' => 'yii\grid\DataColumn',
                'value' => function ($data) {
                    return $data->IpHosting;
                },
                'format' => 'text',
                'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;']
            ];
        }

        $column[] = [
            'label' => 'Fecha de vencimiento',
            'class' => 'yii\grid\DataColumn',
            'value' => function ($data) {
                return date("d-m-Y", strtotime($data->Date)); 
            },
            'format' => 'text',
            'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;']
        ];

        $column[] = [
            'label' => 'Días restantes',
            'class' => 'yii\grid\DataColumn',
            'value' => function ($data) {
                return $data->ReminderDays;
            },
            'format' => 'text',
            'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;']
        ];

        if(isset($dominio)){
            $column[] = [
                'label' => 'Proveedor',
                'class' => 'yii\grid\DataColumn',
                'value' => function ($data) {
                    return $data->Provider;
                },
                'format' => 'text',
                'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;']
            ];
        }

        $column[] = [
            'class' => 'yii\grid\ActionColumn',
            'header' => 'Acciones',
            'template' => '<div class="btn-group"> {edit} {delete} </div>',
            'buttons' => [
                'edit' => function($url, $model){
                    if(is_null($model->IpHosting)){
                        return Html::button('<span class="fa fa-edit"></span>', [
                            'class' => "btn btn-edit btn-success",
                            'title' => 'Editar',
                            'data-id' => $model->RSSLID
                        ]);
                    }
                },
                'delete' => function($url, $model){
                return Html::a('<span class="fa fa-trash"></span>', ['delete-url', 'id' => $model->RSSLID], [
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
        <div class="modal-dialog">
        <?php $form = ActiveForm::begin() ?>
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Formulario</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <?php 
                if(!isset($dominio)){
                    $label = 'Dominio o subdominio';
                    $placeholder = 'www.weclickdigital.com';
                }else{
                    $label = 'Dominio';
                    $placeholder = 'weclickdigital.com';
                }
            ?>
            <?= $form->field($model, 'Text')->textInput(['placeholder' => $placeholder])->label($label) ?>
            <?php if(isset($dominio)): ?>
                <?= $form->field($model, 'Date')->input('date', ['required' => true])->label('Fecha de vencimiento') ?>
                <?= $form->field($model, 'Provider')->textInput()->label('Proveedor') ?>
            <?php endif ?>
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
        <div class="modal-dialog">
        <?php $form = ActiveForm::begin() ?>
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Formulario</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <?php if(isset($dominio)): ?>
                <?= $form->field($model, 'Date')->input('date', ['id' => 'u-date', 'required' => true])->label('Fecha de vencimiento') ?>
                <?= $form->field($model, 'Provider')->textInput(['id' => 'u-provider'])->label('Proveedor') ?>
            <?php endif ?>
            </div>
            <div class="modal-footer">
            <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
            <?= $form->field($model, 'RSSLID')->hiddenInput(['id' => 'u-id'])->label(false) ?>
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

    $url = Url::to(['get-data-ajax2']);
    $JS = <<<JS
        $(document).on('click', '.btn-edit', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            $.post('$url', {id: id}, function(resp){
                resp = JSON.parse(resp)
                console.log(resp);
                
                $('#u-date').val(resp.Date)
                $('#u-provider').val(resp.Provider)
                $('#u-id').val(resp.RSSLID)
                $('#edit-modal').modal('show')
            })
        })
    JS;
    
    $this->registerJS($JS);
?>