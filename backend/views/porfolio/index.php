<?php 
  use yii\helpers\Html;
//  use frontend\assets\AppAssetLayoutAll;
//  AppAssetLayoutAll::register($this);
  use common\components\datatables\DataTables;
  use yii\helpers\Url;
  use yii\bootstrap5\Button;
  use yii\bootstrap5\ActiveForm;
  $this->title = 'Portafolio';
?>

<div class="container-fluid">
  <h1 style="color: var(--color-principal);">Portafolio</h1>
    <hr>
    <div class="row">
      <div class="col-6">
        <a href="<?= Url::to(['add']) ?>" class="btn btn-primary"><i class="fa fa-plus"></i> Nuevo Portafolio</a>
      </div>
      <div class="col-6" align="right">
        <a class="btn btn-primary" href="<?= Url::to(['position']) ?>">Ordenar</a>
      </div>
    </div>
    <br><br><br>
  <div class="row-fluid">
<?php 
echo DataTables::widget([
    'dataProvider' => $dataProvider,
    'columns' => [

        ['class' => 'yii\grid\SerialColumn'],
        // Simple columns defined by the data contained in $dataProvider.
        // Data from the model's column will be used.
    
        [
            'attribute' => 'Title',
            'header' => 'Proyectos',
            'format' => 'text',
            'contentOptions'=>['style'=>'vertical-align:middle;'],
        ],
        
        [
            'class' => 'yii\grid\ActionColumn',
            'header' => 'Acciones',
            'template' => '<div class="btn-group"> {update} {view} {delete} </div>',
            'buttons' => [
                'delete' => function($url, $model){
                    return Html::a('<span class="fa fa-trash" title="Eliminar"></span>', ['delete', 'id' => $model->PorfolioID], [
                        'class' => 'btn btn-danger click-confirm',
                        'title-alert' => 'Eliminar información',
                        'text-alert'  => '¿Estás seguro?. Cuando elimines el proyecto ['.$model->Title.'], no podrás recuperarla más tarde.',
                    ]);
                },
                'update' => function($url, $model){
                    return "<a href='".Url::to(['update', 'id' => $model->PorfolioID])."' class='btn btn-primary' title='Editar'><i class='fa fa-edit'></i></a>";
                },

                'view' => function($url, $model){

                    return Html::a('<span class="fa fa-eye" title="Ver"></span>', 'https://www.weclickdigital.com/porfolio/anexos/' . $model->PorfolioID, [
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