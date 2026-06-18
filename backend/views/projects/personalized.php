<?php
 
use frontend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap5\Button;
use yii\bootstrap5\Modal;
use yii\bootstrap5\ActiveForm;
use common\components\datatables\DataTables;
use common\components\chosen\Chosen;
$this->title = 'Mis Proyectos';
$this->params['breadcrumbs'][] = $this->title;

$ids = [2, 4, 5, 7];
?>

<div class="row">
    <div class="col-md-12">
        <h2 style=""><?= Html::encode($this->title)?></h2>
    </div>
    <div class="col-md-12">
        <hr>
    </div>
</div>

<div class="row">
    <div class="col-12">
        
        <?php   
            if(!in_array($id, $ids)){
                $columns[] = [
                    'attribute' => 'Logo',
                    'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                    'value' => function ($data) {
                        $url = \Yii::getAlias('@raizweb') . '/uploads/projects/logos/';
                        return "<div style='width: 70px; height: 70px; background: var(--bs-table-bg); border-radius: 6%' class='py-1 px-2 d-flex align-items-center m-auto'><img src='{$url}{$data->Logo}' style='height: auto; width: 100%; object-fit: contains;' onError='this.src=\"https://dev.mydesk.digital/NewWeclickUp/images/logo.png\"' /></div>"; // $data['name'] for array data, e.g. using SqlDataProvider.
                    },
                    'format' => 'raw',
                    'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;'],
                ];
            }

            $columns[] = [
                'label' => 'Nombre del proyecto',
                'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                'value' => function ($data) {
                    return $data->Name; // $data['name'] for array data, e.g. using SqlDataProvider.
                },
                'format' => 'text',
                'contentOptions'=>['style'=>'vertical-align:middle;'],
            ];

            $columns[] = [
                'attribute' => 'Tipo',
                'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                'value' => function ($data) {
                    return $data->Type; // $data['name'] for array data, e.g. using SqlDataProvider.
                },
                'format' => 'text',
                'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;'],
            ];

            if($id != 4 && $id != 7){
                $columns[] = [
                    'label' => 'Enlace a desarrollo',
                    'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                    'value' => function ($data) {
                        return "<a href='{$data->LinkDev}' target='_blank'>{$data->LinkDev}</a>"; // 
                    },
                    'format' => 'raw',
                    'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;'],
                ];

                $columns[] = [
                    'label' => 'Enlace a producción',
                    'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                    'value' => function ($data) {
                        return "<a href='{$data->LinkPro}' target='_blank'>{$data->LinkPro}</a>";
                    },
                    'format' => 'raw',
                    'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;'],
                ];

                $columns[] = [
                    'label' => 'Estado de proyecto',
                    'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                    'value' => function ($data) {
                        return ($data->Completed == 0) ? 'Activo' : 'Finalizado';
                    },
                    'format' => 'text',
                    'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;'],
                ];
            }

            $columns[] = [
                'header' => 'Acciones',
                'class' => 'yii\grid\ActionColumn',
                'template' => '<div class="d-flex justify-content-center align-item-center gap-3"> {view} {details} {price} </div>',
                'buttons' => [
                    
                    'view' => function($url, $model){
                        $d = 0;

                        foreach($model->clientAnexos as $ca){
                            if(!is_null($ca->Link))
                                $d++;
                        }
                        if(!in_array($model->ServiceID, [1, 3, 6, 8])){
                            if($d > 0){
                                return Html::button('<i class="fa fa-file me-2"></i> Documentos', [
                                    'class' => 'btn btn-info enlace',
                                    'title' => 'Enlaces',
                                    'data-id' => $model->ProjectClientID,
                                    'data-type' => 1
                                ]);
                            }
                        }

                        return '';
                    },

                    'details' => function($url, $model){
                       /*  $c = 0;
                        
                        foreach($model->clientAnexos as $ca){
                            if(!is_null($ca->File))
                                $c++;
                        }

                        if($c > 0){ */
                            if(in_array($model->ServiceID, [1, 3, 6, 8])){
                                return Html::a('<i class="fa fa-eye me-2"></i> Detalles', ['detail', 'id' => $model->ProjectClientID], [
                                    'class' => 'btn btn-info',
                                ]);
                            }
                       /*  } */

                        return '';
                    },

                    'price' => function($url, $model){
                        $c = 0;
                        
                        foreach($model->clientAnexos as $ca){
                            if(!is_null($ca->File))
                                $c++;
                        }

                        if($c > 0){
                            return '<button class="btn btn-warning cotiza" title="Cotización" data-id="'.$model->ProjectClientID.'" data-type="0"><i class="fa-solid fa-dollar-sign me-2"></i> Cotizaciones</button>';
                        }

                        return '';
                    }
                    
                ],
                'headerOptions'=>['style'=>'width: 25%;'],
                'contentOptions'=>['style'=>'min-width: 100px; text-align: center; vertical-align:middle;'],
            ];


            echo DataTables::widget([
                'dataProvider' => $ProjectsProvider,
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
                ]  
            ]);
        ?>
    </div>    
</div>

<!-- Modal -->
<div class="modal fade" id="modal-cotiza" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width: 650px;">
        <div class="modal-content">
            <div class="modal-body" style="color: var(--bs-dark);">
                <div class="d-flex justify-content-end">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="fs-3 lh-sm mt-3 mb-4 m-Title"></div>
                <div class="dataCotiza" style="max-height: 500px; overflow-y: auto;">
                </div>
            </div>
            <!-- <button type="button" class="btn btn-secondary m-auto px-5 mb-3" data-bs-dismiss="modal">Cerrar</button> -->
        </div>
  </div>
</div>

<?php
    $url = Url::to(['per-cotiza']);
    $uri = Yii::getAlias('@web');
    $js = <<<JS
        const cotiza = document.querySelector('.cotiza')
        cotiza.addEventListener('click', (e) => {
            getData(e)
        })

        const enlace = document.querySelector('.enlace')
        enlace.addEventListener('click', (e) => {
            getData(e)
        })

        function getData(e){
            $.post('$url', {id: e.target.dataset.id, type: e.target.dataset.type}, function(resp){
                let data = JSON.parse(resp)
                console.log(data);
                
                let content = ''
                if(data.length > 0){
                    data.forEach(i => {
                        const fechaOriginal = i.Date;
                        const soloFecha = fechaOriginal.split(" ")[0]; // "2025-09-12"
                        const [año, mes, dia] = soloFecha.split("-");
                        const fechaFormateada = dia+'-'+mes+'-'+año;
                        //console.log(fechaFormateada)
                        content += '<div>'+i.Text+'</div>'
                        content += '<div class="mb-3"><b>Fecha:</b> '+ fechaFormateada +'</div>'
                        if(i.Type == 0){
                            document.querySelector('.m-Title').textContent = 'Cotización'
                            content += '<a href="$uri/../'+ i.File +'" class="text-decoration-none text-danger" download>Descargar PDF</a>'
                        }else{
                            document.querySelector('.m-Title').textContent = 'Enlaces a Drive'
                            content += '<a href="'+ i.Link +'" class="text-decoration-none" target="_blank">Ir al enlace</a>'
                        }
                        content += '<hr>'
                    })
                }else{
                    content = '<span class="fs-3">Aún, no posees información</span>'
                }
                document.querySelector('.dataCotiza').innerHTML = content
                $('#modal-cotiza').modal('show')
            })
        }
       
    JS;

    $this->registerJS($js);
?>

<!-- <a href="$uri/../'+ i.File +'" class="p-3" style="display: grid; place-items: center; background: #FF0351; border-radius: 50%; width: fit-content" download><i class="fa-solid fa-file-pdf fs-4" style="color: white;"></i></a> -->