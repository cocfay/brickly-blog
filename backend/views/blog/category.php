<?php
    use frontend\assets\AppAsset;
    use yii\helpers\Html;
    use yii\bootstrap5\Button;
    use yii\bootstrap5\ActiveForm;
    use yii\helpers\Url;

    use common\components\datatables\DataTables;

    $this->title = 'Listado de categoría';
?>

<div class="HomeRole">
    <div class="container-fluid">
    <div class="row">
        <div class="col-md-12 d-flex justify-content-start align-items-center gap-4">
            <h2 style="white-space: pre;"><?= Html::encode($this->title)?></h2>
           <!--  <hr class="w-100" style="color: #86c455; border:solid 1.5px;">
            <i class="fa fa-arrow-left" onClick="history.back(-1)" style="
                border: solid;
                padding: 10px;
                border-radius: 50%;
                margin-left: 10px;
                cursor:pointer;
                color: #00A7C2;
                width: 40px;
            "></i> -->
        </div>
    </div>
        <div class="d-flex justify-content-between align-items-center">
            <!-- <h2 style="color: var(--color-principal);"><?= Html::encode($this->title)?></h2> -->
            <button type="button" class="btn btn-primary createrole-open" data-bs-toggle="modal" data-bs-target="#addrol"><i class="fa fa-plus"></i> Agregar categoría</button>
        </div>
        <hr>
        <div class="row">
            <div class="col-12">
                <?php   
                    echo DataTables::widget([
                            'dataProvider' => $dataProvider,
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn','contentOptions'=>['style'=>'background-color:var(--bs-table-bg);'],],
                                // Simple columns defined by the data contained in $dataProvider.
                                // Data from the model's column will be used.
                                [
                                  'attribute' => 'Nombre',
                                   'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                                    'value' => function ($data) {
                                        return $data->Name; // $data['name'] for array data, e.g. using SqlDataProvider.
                                    },
                                    'format' => 'text',
                                    'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;'],
                                ],
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'header' => 'Acciones',
                                    'template' => '<div class="btn-group" > {update} {delete} </div>',
                                    'buttons' => [
                                        'delete' => function($url, $model){
                                            return Html::a('<span class="fa fa-trash"></span>', ['dcategory', 'id' => $model->CollectionID], [
                                                'class' => 'btn btn-danger click-confirm',
                                                'tittle-alert' => 'Eliminar información',
                                                'text-alert'  => '¿Estás seguro? Cuando elimines la categoría, no podrás recuperarlo más tarde.',
                                            ]);
                                        },
                                        'update' => function($url, $model){
                                            return '<button type="button" class="btn btn-primary update" id="'.$model->CollectionID.'" data-bs-toggle="modal" data-bs-target="#editrol"><i class="fa fa-edit"></i></button>';
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
<div class="modal fade" id="addrol" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <?php $form = ActiveForm::begin(['action' =>['accioncategory'], 'method' => 'post']); ?>
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Añadir Categoría</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-md-6">   
                <?= $form->field($model, 'Name')->textInput(['maxlength' => true])->label('Nombre'); ?>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button> -->
        <?= Html::submitButton('Añadir', ['class' => 'btn btn-violet']) ?>
      </div>
    </div>
    <?php ActiveForm::end(); ?>
  </div>
</div>

<!-- Modal UPDATE-->
<div class="modal fade" id="editrol" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <?php $form = ActiveForm::begin(['action' =>['accioncategory'], 'method' => 'post']); ?>
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Actualizar Categoría</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-md-6">   
                <?= $form->field($model, 'Name')->textInput(['id' => 'UpdateName', 'maxlength' => true])->label('Nombre'); ?>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button> -->
        <?= $form->field($model, 'CollectionID')->hiddenInput(['id' => 'UpdateID'])->label(false); ?>
        <?= Html::submitButton('Actualizar', ['class' => 'btn btn-violet']) ?>
      </div>
    </div>
    <?php ActiveForm::end(); ?>
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
    const edit = document.querySelectorAll('.update')
    edit.forEach(i => {
        i.addEventListener('click', (e) => {
            var id = e.currentTarget.id
            $.post('ecategory',{ id: id },function(dt){
                obj = JSON.parse(dt);
                $('#UpdateID').val(obj.CollectionID);
                $('#UpdateName').val(obj.Name);
                //$('#modal-update').modal('show');
            });
        })
    })
";
$this->registerJS($JS);
?>