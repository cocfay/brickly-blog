<?php
    use frontend\assets\AppAsset;
    use yii\helpers\Html;
    use yii\helpers\Url;
    use yii\bootstrap5\Button;
    use yii\bootstrap5\Modal;
    use yii\bootstrap5\ActiveForm;
    use common\components\datatables\DataTables;
    use common\components\chosen\Chosen;
    $this->title = '';
    $this->params['breadcrumbs'][] = $this->title;
?>
<div class="d-flex justify-content-between">
    <div class="fs-3 mb-4" style="color: var(--bs-dark)"> <?= $type == 0 ? 'Cotización' : 'Información extra' ?> </div>
    <a href="<?= Url::to('list-escaneo') ?>"><i class="fa-regular fa-circle-left fs-2" style="color: #FF0351;"></i></a>
</div>
<button type="button" class="btn btn-primary mb-2" style="background: #FF0351; color: #fff;" data-bs-toggle="modal" data-bs-target="#modal-create">
  Nuevo registro
</button>
<hr>
 <div class="d-flex align-items-center gap-4" style="color: var(--bs-dark)">
    <div>
        <span class="fw-bold">Nombre del proyecto:</span> <?= $info->Name ?>
    </div>
    <div>
        <span class="fw-bold">Servicio:</span> <?= $info->service->Name ?>
    </div> 
</div>
<hr class="mb-5">
<?php
    $column[] = [
        'class' => 'yii\grid\SerialColumn'
    ];

    $column[] = [
        'label' => 'Título',
        'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
        'value' => function ($data) {
            return $data->Text; 
        },
        'format' => 'text',
        'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;'],
    ];

    if($type != 0){
        $column[] = [
            'label' => 'Enlace',
            'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
            'value' => function ($data) {
                return Html::a($data->Link, $data->Link, ['class' => 'text-decoration-none', 'target' => '_blank']); 
            },
            'format' => 'raw',
            'headerOptions' => [
                'style' => 'width: 440px !important; max-width: 440px;',
                'class' => 'fixed-width-column'
            ],
            'contentOptions' => [
                'style' => 'width: 440px !important; max-width: 440px; vertical-align:middle; word-break: break-word;',
                'class' => 'fixed-width-column'
            ],
        ];
    }
    $column[] = [
        'label' => 'Fecha',
        'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
        'value' => function ($data) {
            return date('d-m-Y', strtotime($data->Date)); 
        },
        'format' => 'text',
        'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;'],
    ];

    $column[] = [
        'class' => 'yii\grid\ActionColumn',
        'header' => 'Acciones',
        'template' => '<div class="btn-group" > {update} {view} {delete} </div>',
        'buttons' => [
            'delete' => function($url, $model){
                $uri = $model->Type == 1 ? ['delete-anexos', 'id' => $model->ProjectClientAnexoID] : ['delete-anexos', 'id' => $model->ProjectClientAnexoID, 'type' => 0];
                return Html::a('<span class="fa fa-trash"></span>', $uri, [
                    'class' => 'btn btn-danger click-confirm',
                    'tittle-alert' => 'Eliminar información',
                    'text-alert'  => '¿Estás seguro? Cuando elimines, no podrás recuperarlo más tarde.',
                ]);
            },
            'update' => function($url, $model){
                return '<button type="button" class="btn btn-success update" data-id="'.$model->ProjectClientAnexoID.'" data-type="'.$model->Type.'"><i class="fa fa-edit"></i></button>';
            },
            'view' => function($url, $model) {
                if (!is_null($model->File)) {
                    return Html::a('<i class="fa fa-download"></i>', ['../'.$model->File], ['class' => 'btn btn-info', 'data-pjax' => '0', 'download' => true]);
                }
                return ''; 
            }
        ],
        'contentOptions'=>['style'=>'min-width: 100px; text-align: center; vertical-align:middle;'],
    ];

    echo DataTables::widget([
        'dataProvider' => $ProjectsProvider,
        'columns' => $column,
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
    ])
?>

<!-- Modal -->
<div class="modal fade" id="modal-create" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <?php $form = ActiveForm::begin() ?>
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Formulario</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?= $form->field($model, 'Text')->textInput(); ?>
                <?php if($type == 0): ?>
                    <?= $form->field($model, 'FilePrice')->fileInput(['accept' => '.pdf, .docx, .csv, .doc']); ?>
                <?php else: ?>
                    <?= $form->field($model, 'Link')->textInput(['class' => 'form-control', 'placeholder' => 'https://www.drive.com']) ?>
                <?php endif ?>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
                <button type="submit" class="btn btn-primary" style="background: #FF0351; color: #fff;">Agregar</button>
            </div>
        </div>
    <?php ActiveForm::end() ?>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal-edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <?php $form = ActiveForm::begin() ?>
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Formulario</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?= $form->field($model, 'Text')->textInput(['id' => 'd-text']); ?>
                <?php if($type == 0): ?>
                    <!-- <?= $form->field($model, 'FilePrice')->fileInput(['accept' => '.pdf, .docx, .csv, .doc', 'disabled' => true]); ?> -->
                <?php else: ?>
                    <?= $form->field($model, 'Link')->textInput(['class' => 'form-control input-1', 'placeholder' => 'https://www.drive.com', 'id' => 'd-link']) ?>
                <?php endif ?>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
                <?= $form->field($model, 'ProjectClientAnexoID')->hiddenInput(['id' => 'd-id'])->label(false) ?>
                <button type="submit" class="btn btn-success" style="background: #FF0351; color: #fff;">Modificar</button>
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

    if (Yii::$app->session->hasFlash('error')):

        $this->registerJS('
            $(document).ready(function(){
                _Message("error","¡Error!","'.Yii::$app->session->getFlash('error').'");
            });

            ');
    endif;

    $url = Url::to('get-data-ajax');
    $js = <<<JS
        /*const select = document.querySelector('#id_opcion')
        select.addEventListener('change', (e) =>{
            const input1 = document.querySelector('.input-1')
            const input2 = document.querySelector('.input-2')
            if(e.target.value == 1){
                input1.style.display = 'block'
                input1.disabled = false
                input2.style.display = 'none'
                input2.disabled = true
            }else{
                input1.style.display = 'none'
                input1.disabled = true
                input2.style.display = 'block'
                input2.disabled = false
            }
        }) */

       const update = document.querySelector('.update')
       update.addEventListener('click', (e) =>{
            $.post('$url', {id: e.target.dataset.id}, function(resp){
                let data = JSON.parse(resp)
                
                document.querySelector('#d-text').value = data.Text
                document.querySelector('#d-id').value = data.ProjectClientAnexoID
                if(data.Type != 0)
                    document.querySelector('#d-link').value = data.Link
                
                //console.log(data);
                
                $('#modal-edit').modal('show')
            })
       })
    JS;

    $this->registerJs($js);

?>



