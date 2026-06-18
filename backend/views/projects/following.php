<?php
 
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap5\Modal;
use common\components\datatables\DataTables;
$this->title = 'Proyectos seguidos';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row mb-4">
    <div class="col-12">
        <h2><?= $this->title; ?></h2>
    </div>
</div>

<div class="row mt-2">
    <div class="col-12">
        <?php   
            echo DataTables::widget([
                    'dataProvider' => $ProjectsProvider,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        // Simple columns defined by the data contained in $dataProvider.
                        // Data from the model's column will be used.
                        [
                            'label' => 'Logo',
                            'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                            'value' => function ($data) {
                                $url = \Yii::getAlias('@raizweb') . '/uploads/projects/logos/';
                                return "<div style='width: 70px; height: 70px; background: var(--bs-table-bg); border-radius: 6%' class='py-1 px-2 d-flex align-items-center m-auto'><img src='{$url}{$data->projectsClient->Logo}' style='height: auto; width: 100%; object-fit: contains;' onError='this.src=\"https://dev.mydesk.digital/NewWeclickUp/images/logo.png\"' /></div>"; // $data['name'] for array data, e.g. using SqlDataProvider.
                            },
                            'format' => 'raw',
                            'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;'],
                        ],
                        [
                            'label' => 'Nombre del proyecto',
                                'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                                'value' => function ($data) {
                                    return $data->projectsClient->Name; // $data['name'] for array data, e.g. using SqlDataProvider.
                                },
                                'format' => 'text',
                                'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;'],
                            ],
                            [
                            'label' => 'Enlace a desarrollo',
                                'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                                'value' => function ($data) {
                                    return "<a href='{$data->projectsClient->LinkDev}' target='_blank'>{$data->projectsClient->LinkDev}</a>"; // 
                                },
                                'format' => 'raw',
                                'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;'],
                            ],
                            [
                            'label' => 'Enlace a producción',
                                'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                                'value' => function ($data) {
                                return "<a href='{$data->projectsClient->LinkPro}' target='_blank'>{$data->projectsClient->LinkPro}</a>";
                                },
                                'format' => 'raw',
                                'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;'],
                            ],

                        [
                            'class' => 'yii\grid\ActionColumn',
                            'header' => 'Acciones',
                            'template' => '<div class="btn-group" > {eye} </div>',
                            'buttons' => [
                                'eye' => function($url, $model){
                                    return Html::a('<span class="fa fa-eye"></span>', ['see', 'id' => $model->ProjectClientID], [
                                        'class' => 'btn btn-info',
                                    ]);
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