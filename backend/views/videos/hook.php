<?php
 
use frontend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap5\Button;
use yii\bootstrap5\Modal;
use yii\bootstrap5\ActiveForm;
use common\components\datatables\DataTables;
use common\components\chosen\Chosen;
$this->title = 'Ganchos';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="HomeRole">
    <h2 class="mb-4" style="color: var(--color-principal);"><?= Html::encode($this->title)?></h2>
    <div>
        <button type="button" class="btn btn-primary" onClick="$('#create-modal').modal('show');"><i class="fa fa-plus"></i> Añadir gancho</button>
    </div>
    <hr>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <?php   
                    echo DataTables::widget([
                            'dataProvider' => $dataProvider,
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],
                                // Simple columns defined by the data contained in $dataProvider.
                                // Data from the model's column will be used.
                                
                                [
                                    'label' => 'Nombre',
                                    'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                                    'value' => function ($data) {
                                        return $data->Name; // $data['name'] for array data, e.g. using SqlDataProvider.
                                    },
                                    'format' => 'text',
                                    'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;'],
                                ],
                                [
                                    'header' => 'Acciones',
                                    'class' => 'yii\grid\ActionColumn',
                                    'template' => '<div class="btn-group" > {update} {delete} </div>',
                                    'buttons' => [
                                        'delete' => function($url, $model){
                                            return Html::a('<span class="fa fa-trash"></span>', ['delete-hook', 'id' => $model->HookID], [
                                                'class' => 'btn btn-danger click-confirm',
                                                'tittle-alert' => 'Eliminar información',
                                                'text-alert'  => '¿Estás seguro? Cuando elimines el gancho, no podrás recuperarlo más tarde.',
                                            ]);
                                        },
                                        'update' => function($url, $model){
                                            return '<button type="button" class="btn btn-success update" data-id="'.$model->HookID.'"><i class="fa fa-edit"></i></button>';
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
                                    'first'  => Yii::t('app','Primero'),
                                    'previous'  => Yii::t('app','<'),
                                    'next'    => Yii::t('app','>'),
                                    'last'    => Yii::t('app','Último'),
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

<!-- Create Modal -->
<div class="modal fade" id="create-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <?php $form = ActiveForm::begin() ?>
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Añadir nuevo gancho</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <?= $form->field($model, 'Name')->textInput(['style' => 'border-color: gray !important;']) ?>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <?= Html::submitButton('Guardar', ['class' => 'btn btn-primary']) ?>
        </div>
        </div>
    <?php ActiveForm::end() ?>
  </div>
</div>

<!-- Update Modal -->
<div class="modal fade" id="update-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <?php $form = ActiveForm::begin(['action' => 'update-hook']) ?>
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Editar gancho</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <?= $form->field($model, 'Name')->textInput(['class' => 'up-name form-control', 'style' => 'border-color: gray !important;']) ?>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <?= Html::submitButton('Actualizar', ['class' => 'btn btn-success btn-update']) ?>
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

    $url = Url::to(['get-data-hook']);
    $js = <<<JS
        const updateBtn = document.querySelectorAll('.update')
        updateBtn.forEach(i => {
            i.addEventListener('click', () =>{
                $.post("$url", {id: i.dataset.id}, (resp) =>{
                    let data = JSON.parse(resp)
                    document.querySelector('.up-name').value = data.name

                    const nameUpdate = document.querySelector('.btn-update').textContent
                    document.querySelector('.btn-update').innerHTML = nameUpdate + '<input type="hidden" name="Hook[HookID]" value="' + i.dataset.id + '">'
                    
                    $('#update-modal').modal('show')
                })
            })
        })
    JS;

    $this->registerJS($js);
?>