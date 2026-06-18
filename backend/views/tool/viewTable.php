<?php
    use yii\helpers\Html;
    use yii\helpers\Url;
    use yii\bootstrap5\ActiveForm;
    use common\components\datatables\DataTables;
    $this->title = 'Proyectos en desarrollo';

    $mi_clave = "MiContraseñaSuperSecreta2025";
    function desencriptarPersonalizado($informacion_encriptada, $clave_secreta) {
        $key = hash('sha256', $clave_secreta, true);
        $datos_binarios = base64_decode($informacion_encriptada);
        $iv_length = openssl_cipher_iv_length(METODO_ENCRIPTACION);
        $iv = substr($datos_binarios, 0, $iv_length);
        $texto_cifrado = substr($datos_binarios, $iv_length);
        return openssl_decrypt($texto_cifrado, METODO_ENCRIPTACION, $key, 0, $iv);
    }

?>

<div style="color: var(-bs-dark)">
    <h3>Proyectos en desarrollo</h3>
    <div class="d-flex gap-3 align-items-center mt-3 mb-5">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addws"><i class="fa-solid fa-file me-2"></i> Agregar proyecto</button>
    </div>
    <?php
        $column[] = [
            'class' => 'yii\grid\SerialColumn', 'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;']
        ];

         $column[] = [
            'attribute' => 'UrlDev',
            'format' => 'text',
            'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;'],
        ];

        $column[] = [
            'attribute' => 'UrlProd',
            'format' => 'text',
            'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;'],
        ];

        /* $column[] = [
            'attribute' => 'Dominio',
            'value' => function ($data) {
                return $data->Text;
            },
            'format' => 'text',
            'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;'],
        ]; */

        
        /* $column[] = [
            'attribute' => 'Carpeta',
            'class' => 'yii\grid\DataColumn',
            'value' => function ($data) {
                return $data->IpHosting;
            },
            'format' => 'text',
            'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;']
        ]; */
        

        $column[] = [
            'attribute' => 'DB',
            /* 'class' => 'yii\grid\DataColumn',
            'value' => function ($data) {
                return date("d-m-Y", strtotime($data->Date)); 
            }, */
            'format' => 'text',
            'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;']
        ];

        /* $column[] = [
            'label' => 'Usuario',
            'class' => 'yii\grid\DataColumn',
            'value' => function ($data) use ($mi_clave) {
                return desencriptarPersonalizado($data->Usuario, $mi_clave);
            },
            'format' => 'text',
            'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;']
        ]; */

        /* $column[] = [
            'attribute' => 'Password',
            //'class' => 'yii\grid\DataColumn',
            //'value' => function ($data) {
                //return $data->IpHosting;
            //},
            'format' => 'text',
            'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;']
        ]; */

       /*  $column[] = [
            'attribute' => 'Descripcion',
            //'class' => 'yii\grid\DataColumn',
            //'value' => function ($data) {
                //return $data->IpHosting;
            //},
            'format' => 'text',
            'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;']
        ]; */

        $column[] = [
            'attribute' => 'Fecha',
            'class' => 'yii\grid\DataColumn',
            'value' => function ($data) {
                return date("d-m-Y", strtotime($data->Fecha));
            },
            'format' => 'text',
            'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;']
        ];

        $column[] = [
            'attribute' => 'Cliente',
            /* 'class' => 'yii\grid\DataColumn',
            'value' => function ($data) {
                return $data->IpHosting;
            }, */
            'format' => 'text',
            'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;']
        ];

       /*  $column[] = [
            'attribute' => 'ScriptClear',
            //'class' => 'yii\grid\DataColumn',
            //'value' => function ($data) {
                //return $data->IpHosting;
            //},
            'format' => 'text',
            'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;']
        ]; */

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
                    <?= $form->field($model, 'UrlDev')->textInput() ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'UrlProd')->textInput() ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'Dominio')->textInput() ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'Carpeta')->textInput() ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'DB')->textInput() ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'Usuario')->textInput() ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'Password')->textInput() ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'Fecha')->input('date') ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'Cliente')->textInput() ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'Descripcion')->textarea(['style' => 'min-height: 120px']) ?>
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
                    <?= $form->field($model, 'UrlDev')->textInput(['id' => 'e-urldev']) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'UrlProd')->textInput(['id' => 'e-urlprod']) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'Dominio')->textInput(['id' => 'e-dominio']) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'Carpeta')->textInput(['id' => 'e-carpeta']) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'DB')->textInput(['id' => 'e-db']) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'Usuario')->textInput(['id' => 'e-usuario']) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'Password')->textInput(['id' => 'e-password']) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'Fecha')->input('date', ['id' => 'e-fecha']) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'Cliente')->textInput(['id' => 'e-cliente']) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'Descripcion')->textarea(['id' => 'e-descripcion', 'style' => 'min-height: 120px']) ?>
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
                
                $('#e-urldev').val(resp.UrlDev);
                $('#e-urlprod').val(resp.UrlProd);
                $('#e-dominio').val(resp.Dominio);
                $('#e-carpeta').val(resp.Carpeta);
                $('#e-db').val(resp.DB);
                $('#e-usuario').val(resp.Usuario);
                $('#e-password').val(resp.Password);
                $('#e-descripcion').val(resp.Descripcion);
                $('#e-fecha').val(resp.Fecha);
                $('#e-cliente').val(resp.Cliente);
                $('#e-scriptclear').val(resp.ScriptClear);
                $('#e-id').val(resp.ProjectWeclickID);
                $('#edit-modal').modal('show');
            });
        });
    JS;
    
    $this->registerJS($JS);
?>