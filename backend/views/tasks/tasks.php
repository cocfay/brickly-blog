<?php
 
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap5\Modal;
use yii\bootstrap5\Button;
use yii\bootstrap5\ActiveForm;
use common\components\datatables\DataTables;
$this->title = "Mis Tareas";
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row mt-4">
    <?php if(in_array('20', $UserData->rolesId)): ?>
        <div class="col-12 mb-3">
            <?= Html::a('Proyectos seguidos', Url::to(['projects/following']), ['class' => 'btn btn-primary', 'style' => 'width: fit-content; background: #FF004D; color: #fff;']) ?>
        </div>
    <?php endif ?>
    <div class="col-12">
        <h2 class="text-success">Mis tareas asignadas</h2>
    </div>
    <div class="col-12">
        <hr>
    </div>
</div>
<div class="row mt-4">
    
    <div class="col-6">
        <h3 class="text-danger">Tareas Pendientes</h3>
        <?php   
            echo DataTables::widget([
                    'dataProvider' => $TasksPenddingProvider,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        // Simple columns defined by the data contained in $dataProvider.
                        // Data from the model's column will be used.
                            [
                            'label' => 'Titúlo',
                                'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                                'value' => function ($data) {
                                    return $data->Title; // $data['name'] for array data, e.g. using SqlDataProvider.
                                },
                                'format' => 'text',
                                'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;'],
                            ],

                            [
                                'class' => 'yii\grid\ActionColumn',
                                'template' => '<div class="btn-group" > {view} </div>',
                                'buttons' => [
                                    
                                    'view' => function($url,$model){
                                            return Html::a('<span class="fa fa-eye"></span>', ['see', 'id' => $model->ProjectTaskID], [
                                                'class' => 'btn btn-warning',
                                            ]);
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
    <div class="col-6">
        <h3 class="text-warning">Tareas iniciadas</h3>
        <?php   
            echo DataTables::widget([
                    'dataProvider' => $TasksInitProvider,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        // Simple columns defined by the data contained in $dataProvider.
                        // Data from the model's column will be used.
                            [
                            'label' => 'Titúlo',
                                'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                                'value' => function ($data) {
                                    return $data->Title; // $data['name'] for array data, e.g. using SqlDataProvider.
                                },
                                'format' => 'text',
                                'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;'],
                            ],

                            [
                                'class' => 'yii\grid\ActionColumn',
                                'template' => '<div class="btn-group" > {view} </div>',
                                'buttons' => [
                                    
                                    'view' => function($url,$model){
                                            return Html::a('<span class="fa fa-eye"></span>', ['see', 'id' => $model->ProjectTaskID], [
                                                'class' => 'btn btn-warning',
                                            ]);
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
<div class="row mt-2">
    <div class="col-md-12">
        <h3 class="text-success">Tareas completadas</h3>
        <?php   

            $columns[] = ['class' => 'yii\grid\SerialColumn'];
            $columns[] = [
            'label' => 'Titúlo',
                'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                'value' => function ($data) {
                    return $data->Title; // $data['name'] for array data, e.g. using SqlDataProvider.
                },
                'format' => 'text',
                'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;'],
            ];
            if(!empty($project->HoursCompleted)){
                $columns[] = [
                    'attribute' => 'HoursWorked',
                    'format' => 'text',
                    'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;'],
                ];
            }
            $columns[] = ['label' => 'Iniciada',
                'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                'value' => function ($data) {
                    return date('d/m/Y H:i',strtotime($data->StartTask)); // $data['name'] for array data, e.g. using SqlDataProvider.
                },
                'format' => 'text',
                'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;'],
            ];
            $columns[] = ['label' => 'Finalizada',
                'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                'value' => function ($data) {
                    return date('d/m/Y H:i',strtotime($data->EndTask)); // $data['name'] for array data, e.g. using SqlDataProvider.
                },
                'format' => 'text',
                'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;'],
            ];

            $columns[] = [
                'class' => 'yii\grid\ActionColumn',
                'template' => '<div class="btn-group" > {view} </div>',
                'buttons' => [
                    
                    'view' => function($url,$model){
                            return Html::a('<span class="fa fa-eye"></span>', ['see', 'id' => $model->ProjectTaskID], [
                                'class' => 'btn btn-warning',
                            ]);
                    }
                    
                ],
                'contentOptions'=>['style'=>'min-width: 100px; text-align: center; vertical-align:middle;'],
            ];
            
            echo DataTables::widget([
                    'dataProvider' => $TasksFinishProvider,
                    'columns' => $columns,
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