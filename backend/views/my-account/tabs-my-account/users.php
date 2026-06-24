<?php
use yii\helpers\Html;
use yii\bootstrap4\Button;
use yii\bootstrap4\ActiveForm;
use common\components\datatables\DataTables;
$this->title = 'Usuarios';
$this->params['breadcrumbs'][] = $this->title;

$this->registerCss('
    th{
        font-weight: normal !important;
    }
')
?>
 
 
<div class="usuario">

    <?= Html::a('<i class="fa fa-plus"></i> Añadir nuevo usuario', ['/usuario/createuser'], ['class'=>'btn px-4 my-4', 'style' => 'font-size: 14px; background: #FF0461; border-radius: 4px; color: #fff;']) ?>

    <br><br>

    <div class="container-fluid">
    <?php 
        echo DataTables::widget([
            'dataProvider' => $AgencysDat,

            'columns' => [
                ['class' => 'yii\grid\SerialColumn',],

                [
                    'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                    'attribute' => 'UserName',
                    'format' => 'text',
                    'contentOptions'=>['style'=>' vertical-align:middle;'],
                ],
                [
                    'attribute' => 'Name',
                    'format' => 'text',
                    'contentOptions'=>['style'=>'vertical-align:middle; min-width: 30%;'],
                ],
                [
                    'attribute' => 'Email',
                    'format' => 'text',
                    'contentOptions'=>['style'=>'vertical-align:middle;'],
                ],
                [
                    'header' => 'Rol',
                    'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                    'value' => function ($data) {
                        return $data->typeUsers->Name; // $data['name'] for array data, e.g. using SqlDataProvider.
                    },
                    'format' => 'text',
                    'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;'],
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'header' => 'Acciones',
                    'headerOptions' => ['style' => 'text-align: center;'],
                    'template' => '<div class="btn-group" > {update} {project} {delete} </div>',
                    'buttons' => [
                        'delete' => function($url, $model){
                            return Html::a('<span class="fa fa-trash"></span>', ["usuario/delete","id" => $model->AccountID], [
                                'class' => 'btn btn-danger click-confirm',
                                'tittle-alert'  => 'Eliminar información',
                                'text-alert'  => '¿Estás seguro? Cuando elimines el usuario ['.$model->UserName.'],no podrás recuperarlo más tarde.',
                            ]);
                        },
                        'update' => function($url, $model){
                            return Html::a('<span class="fa fa-edit"></span>',[ "usuario/update","id"=>$model->AccountID], [
                                'class' => 'btn btn-primary',   
                            ]);
                        },
                        'project' => function($url, $model){
                            if($model->TypeUser == 2){
                                return Html::a('<span class="fa fa-diagram-project"></span>',[ "/projects/list","id"=>$model->AccountID], [
                                    'class' => 'btn btn-warning',   
                                ]);
                            }else{
                                return "";
                            }
                        }
                       
                    ],

                    'contentOptions'=>['style'=>'min-width: 100px; text-align: center; vertical-align:middle;'],
                ],
            ],

            'clientOptions' => [
                "lengthMenu"=> [[10,20,-1], [10,20,Yii::t('app',"All")]],
                "info"=>false,
                "lengthChange" => false,
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

    $js = <<<JS

        // Escuchar cuando se muestra la pestaña de Usuarios
        if($('#datatables_w0').length > 0){
            document.getElementById('nav-users-tab').addEventListener('shown.bs.tab', function(e) {
                // Verificar si la tabla ya está inicializada
                var table = $('#datatables_w0').DataTable();
                
                // Recalcular el responsive
                setTimeout(function() {
                    table.columns.adjust().responsive.recalc();
                }, 100);
            });
        }
    JS;

    $this->registerJS($js);
?>
