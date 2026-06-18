<?php
    use yii\helpers\Html;
    use yii\helpers\Url;
    use yii\bootstrap5\ActiveForm;
    use common\components\datatables\DataTables;
    $this->title = $model->TypePay == 1 ? 'Historial de pago - Servicio contable' : 'Historial de pago - ' . $model->Name;
?>

<div style="color: var(-bs-dark)">
    <div class="d-flex align-items-start justify-content-between">
        <h3><?= $this->title ?></h3>
        <?php if($DataUser->TypeUser != 6):  ?>
            <a href="<?= Url::to(['provider-weclick']) ?>" title="Atrás"><i class="fa-regular fa-circle-left fs-1" style="color: #FF0461"></i></a>
        <?php endif ?>
    </div>
    <?php if($DataUser->TypeUser != 6):  ?>
        <div class="d-flex gap-3 align-items-center mt-3 mb-4">
            <?php if($model->TypePay == 2 || ($model->TypePay == 1 && ($model->Debt > 0 || !empty($model->Debt)))): ?>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addws"><i class="fa-solid fa-plus me-2"></i> Agregar</button>
            <?php endif ?>
            <?php if($model->TypePay == 1): ?>
                <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#config"><i class="fa-solid fa-gear me-2"></i> Configuración</button>
            <?php endif ?>
        </div>
    <?php endif ?>
</div>

<?php if(!empty($model->Debt)): ?>
    <div class="mb-4 fs-4">Monto adeudado a proveedor Q<?= number_format($model->Debt, 2, '.', ','); ?> </div>
<?php endif ?>

<!-- <?php if($model->TypePay == 1): ?>
    <?= Html::a('<i class="fa-solid fa-table-list me-2"></i> Detalle de pagos', ['summary-pay', 'id' => $model->ProviderID], ['class' => 'btn btn-info mb-4']) ?>
<?php endif ?> -->

<?php
    $column[] = [
        'class' => 'yii\grid\SerialColumn', 'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;']
    ];

    if($model->TypePay == 1){
        $column[] = [
            'label' => 'Fecha',
            'attribute' => 'Date',
            'value' => function ($data) {
                return Date('d/m/Y', strtotime($data->Date));
            },
            'format' => 'text',
            'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;'],
        ];
    }

    if($model->TypePay == 2){
        $column[] = [
            'attribute' => 'Name',
            'format' => 'text',
            'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;'],
        ];
    }

    if($model->TypePay == 2){
        $column[] = [
            'attribute' => 'TypeCurrency',
            'format' => 'text',
            'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;'],
        ];
    }

    if($model->TypePay == 1){
        $column[] = [
            'attribute' => 'Mensualidad',
            'value' => function ($data) use ($model) {
                return ($model->TypePay == 1 && $data->Type == 1) ? 'Q' . number_format($data->Amount, 2, '.', ',') : '0';
            },
            'format' => 'text',
            'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;']
        ];
    }

    $column[] = [
        'attribute' => $model->TypePay == 2 ? 'Amount' : 'Pago',
        'value' => function ($data) use ($model) {
            if($model->TypePay == 1){
                return $data->Type == 0 ? 'Q' . number_format($data->Amount, 2, '.', ',') : '0';
            }elseif($model->TypePay == 2){
                if($data->TypeCurrency != "Quetzales")
                    return $data->Amount;
                else
                    return number_format($data->Amount, 2, '.', ',');
            }
        },
        'format' => 'text',
        'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;']
    ];

    if($model->TypePay == 1){
        $column[] = [
            'label' => 'Saldo',
            'value' => function ($data) use ($model) {
                return 'Q' . number_format($data->Balance, 2, '.', ',');
            },
            'format' => 'text',
            'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;']
        ];
    }

    if($model->TypePay == 2){
        $column[] = [
            'attribute' => 'Conversion',
            'value' => function ($data) {
                return number_format($data->Conversion, 2, '.', ',');
            },
            'format' => 'text',
            'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;'],
        ];
    }

    if($model->TypePay == 2){
        $column[] = [
            'attribute' => 'Date',
            'value' => function ($data) {
                return Date('d/m/Y', strtotime($data->Date));
            },
            'format' => 'text',
            'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;'],
        ];
    }

    $column[] = [
        'attribute' => 'Photo',
        'value' => function ($data, $url) {
                if(empty($data->Photo)){
                    return "<i class='fa-solid fa-file-image fs-3 text-danger' title='No hay comprobante'></i>";
                }else{
                    return "<a href='".Yii::getAlias('@web').'/../uploads/'.$data->Photo."' target='_blank' title='ver comprobante'><i class='fa-solid fa-file-image fs-3'></i></a>";
                }
            },
        'format' => 'raw',
        'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;'],
    ];

    if($DataUser->TypeUser != 6){
        $column[] = [
            'class' => 'yii\grid\ActionColumn',
            'header' => 'Acciones',
            'template' => '<div class="btn-group"> {edit} {delete} </div>',
            'buttons' => [
                'edit' => function($url, $model){
                    /* return Html::button('<span class="fa fa-edit"></span>', [
                        'class' => "btn btn-edit btn-success",
                        'title' => 'Editar',
                        'data-id' => $model->PayConServID,
                        'disabled' => true
                    ]); */

                    return '';
                },
                'delete' => function($url, $model){
                    return Html::a('<span class="fa fa-trash"></span>', ['delete-pay', 'id' => $model->PayConServID], [
                        'class' => 'btn btn-danger click-confirm',
                        'title-alert' => 'Eliminar registro',
                        'text-alert'  => '¿Estás seguro?',
                        'title' => 'Eliminar'
                    ]);
                },
            
            ],
            'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;'],
        ];
    }

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

<!-- Modal Add -->
<div class="modal fade" id="addws" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
    <?php $form = ActiveForm::begin() ?>
    <div class="modal-content p-4">
        <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Formulario de pago</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body row">
            <?php if($model->TypePay == 2): ?>
                <div class="col-md-6">
                    <?= $form->field($modelPay, 'Name')->textInput() ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($modelPay, 'TypeCurrency')->dropDownList(['Dolares' => 'Dolares', 'Euros' => 'Euros', 'Quetzales' => 'Quetzales']) ?>
                </div>
            <?php endif ?>
            <div class="col-md-6">
                <?= $form->field($modelPay, 'Amount')->textInput() ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($modelPay, 'Date')->input('datetime-local') ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($modelPay, 'Photo')->fileInput(['accept' => 'image/*']) ?>
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


<!-- Modal Config -->
<div class="modal fade" id="config" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
    <?php $form = ActiveForm::begin() ?>
    <div class="modal-content p-4">
        <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Configuración</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body row">
            <div class="col-md-6">
                <?= $form->field($model, 'Amount')->textInput() ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'Debt')->textInput() ?>
            </div>
        </div>
        <div class="modal-footer">
        <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
        <?= $form->field($model, 'Name')->hiddenInput(['value' => $model->Name])->label(false) ?>
        <?= $form->field($model, 'TypePay')->hiddenInput(['value' => $model->TypePay])->label(false) ?>
        <button type="submit" class="btn btn-primary">Agregar</button>
        </div>
    </div>
    <?php ActiveForm::end() ?>
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

?>