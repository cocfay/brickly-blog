<?php 
    use yii\helpers\Html;
    //use frontend\assets\AppAssetLayoutAll;
    //AppAssetLayoutAll::register($this);
    use common\components\datatables\DataTables;
    use yii\helpers\Url;
    use yii\bootstrap5\Button;
    use yii\bootstrap5\ActiveForm;
    $this->title = 'Solicitud de servicio';
?>

<div class="container-fluid">
  <h1 style="color: var(--color-principal);">Solicitud de servicio</h1>
    <hr>
    <br>
  <div class="row-fluid">
    <div class="fs-3 mb-4"><?= $NameService ?></div>
<?php 
echo DataTables::widget([
    'dataProvider' => $dataProvider,
    'columns' => [

        ['class' => 'yii\grid\SerialColumn'],
        // Simple columns defined by the data contained in $dataProvider.
        // Data from the model's column will be used.
    
        [
        'label' => 'Usuario',
            'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
            'value' => function ($data) {
                return $data->account->userAccount->UserName; // $data['name'] for array data, e.g. using SqlDataProvider.
            },
            'format' => 'text',
            'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;'],
        ],
        ['label' => 'Email',
            'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
            'value' => function ($data) {
                return $data->account->userAccount->Email; // $data['name'] for array data, e.g. using SqlDataProvider.
            },
            'format' => 'text',
            'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;'],
        ],
        ['label' => 'Teléfono',
            'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
            'value' => function ($data) {
                return $data->account->userAccount->NumberPhone; // $data['name'] for array data, e.g. using SqlDataProvider.
            },
            'format' => 'text',
            'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;'],
        ],
        /* ['label' => 'Descripción',
            'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
            'value' => function ($data) {
                return $data->Description; // $data['name'] for array data, e.g. using SqlDataProvider.
            },
            'format' => 'text',
            'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;'],
        ], */
        
        [
            'class' => 'yii\grid\ActionColumn',
            'header' => 'Acciones',
            'template' => '<div class="btn-group"> {view} </div>',
            'buttons' => [
                'view' => function($url, $model){
                    $color = ($model->Status == 1) ? 'btn-success' : 'btn-info';
                    return Html::a('<span class="fa fa-eye"></span>', [''], [
                        'class' => "btn btn-submit {$color}",
                        'title' => 'Ver',
                        'data-id' => $model->RequestServiceClientID
                    ]);
                },
                'status' => function($url, $model){
                    if($model->Status == 0){
                        return Html::a('<span class="fa fa-check"></span>', ['status', 'id' => $model->RequestServiceClientID], [
                            'class' => 'btn btn-info click-confirm',
                            'title-alert' => 'Cambiar estado',
                            'text-alert'  => '¿Estás seguro?',
                            'title' => 'Eliminar'
                        ]);

                    }else{
                        return Html::a('<span class="fa fa-times" title="Eliminar"></span>', ['status', 'id' => $model->RequestServiceClientID], [
                        'class' => 'btn btn-danger click-confirm',
                        'title-alert' => 'Cambiar estado',
                        'text-alert'  => '¿Estás seguro?',
                    ]);
                    }
                },
               
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
</div>
</div>

<div class="modal" id="modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <?php ActiveForm::begin(['action' => 'service-requests/status']) ?>
            <div class="modal-header">
                <h5 class="modal-title">Información adicional</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body formItems">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-validate btn-success">Leído</button>
            </div>
        <?php ActiveForm::end() ?>
    </div>
  </div>
</div>

<?php
    $url = Url::to(['info-service']);
    $js = <<<JS
        document.querySelectorAll('.btn-submit').forEach(i =>{
            i.addEventListener('click', (e) =>{
                e.preventDefault()
                $.post('$url', {id: i.dataset.id}, function(resp){
                    let text = ''
                    //console.log(resp);
                    let data = JSON.parse(resp)
                    text += '<div class="">'
                        if(data.options != ''){
                            text += '<div class="fw-bold mb-2">Checks selecionados</div>'
                            data.options.forEach(i => {
                                text += '<div class="mb-1">' + i + '</div>'
                            })
                            text += '<hr>'
                        }
                        
                    text += '<div><label class="form-label">Descripción</label> <textarea style="min-height: 130px; border-color: gray !important;" class="form-control" readonly>' + data.description + '</textarea></div>'
                    text += '</div>'
                    document.querySelector('.formItems').innerHTML = text
                    const button = document.querySelector('.btn-validate')
                    button.innerHTML = button.textContent + '<input type="hidden" name="id" value="' + i.dataset.id + '" />'
                    
                    button.style.display = data.status == 0 ? '' : 'none'

                    $('#modal').modal('show')
                })
            })
        })
    JS;

    $this->registerJs($js);
?>