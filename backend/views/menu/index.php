<?php 
  use yii\helpers\Html;
//  use frontend\assets\AppAssetLayoutAll;
//  AppAssetLayoutAll::register($this);
  use common\components\datatables\DataTables;
  $this->title = 'Menú';
?>

<div class="container-fluid cpanel-menus-page">
  <div class="cpanel-page-heading">
    <h1>Menús</h1>
    <?= Html::a('<i class="fa-solid fa-plus"></i> Crear nuevo menú', ['/menu/createmenu'], ['class'=>'btn btn-primary cpanel-create-btn']) ?>
  </div>
  <div class="cpanel-menus-grid">
<?php 

echo DataTables::widget([
    'dataProvider' => $dataProvider,
    'tableOptions' => ['class' => 'table table-striped dt-responsive dataTable no-footer dtr-inline display responsive nowrap cpanel-menus-table', 'cellspacing' => '0', 'width' => '100%'],
    'columns' => [

        ['class' => 'yii\grid\SerialColumn'],
        // Simple columns defined by the data contained in $dataProvider.
        // Data from the model's column will be used.
    
        [
            'attribute' => 'MenuName',
            'format' => 'text',
            'contentOptions'=>['style'=>'vertical-align:middle;'],
        ],
        [
          'attribute' => 'Icon',
           'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
            'value' => function ($data) {
              $classIcon = trim((string) $data->ClassIcon);
              $iconClass = (strpos($classIcon, 'fa') === 0) ? $classIcon : 'fa-solid '.$classIcon;
              $htm = "<i class='".$iconClass." cpanel-menu-icon'></i>";
                return $htm; // $data['name'] for array data, e.g. using SqlDataProvider.
            },
            'format' => 'html',
            'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;'],
        ],
        [
            'attribute' => 'ControllerUse',
            'format' => 'text',
            'contentOptions'=>['style'=>'vertical-align:middle;'],
        ],
        [
          'attribute' => 'Type',
           'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
            'value' => function ($data) {
              $te = "";
              if($data->Type == 0){ $te = "Menú Con subs Menú"; }else{$te = "Menú Simple"; }

                return $te; // $data['name'] for array data, e.g. using SqlDataProvider.
            },
            'format' => 'text',
            'contentOptions'=>['style'=>'vertical-align:middle;'],
        ],
       [
        'attribute' => 'Path',
         'class' => 'yii\grid\DataColumn',
         'format' => 'text',
         'contentOptions'=>['style'=>'vertical-align:middle;'],
        ],
        
        [
           'attribute' => 'Pages',
           'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
           'value' => function ($data) {
              $te = "";
              foreach ($data->page as $r){
              	$te .= " ".$r->PageName.",";
              }
              $te = trim($te, ',');
              if(empty($te)){
              	$te = '----';
              }

                return $te; // $data['name'] for array data, e.g. using SqlDataProvider.
            },
            'format' => 'text',
            'contentOptions'=>['style'=>'vertical-align:middle;'],
        ],
        [
          'attribute' => 'Roles Use',
           'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
            'value' => function ($data) {
              $te = "";
              foreach ($data->menuByRole as $r){
              	$te .= " ".$r->role->RoleName.",";
              }
              $te = trim($te, ',');

                return $te; // $data['name'] for array data, e.g. using SqlDataProvider.
            },
            'format' => 'text',
            'contentOptions'=>['style'=>'vertical-align:middle;'],
        ],

        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '<div class="btn-group" > {update} {delete} </div>',
            'buttons' => [
                'delete' => function($url, $model){
                    return Html::a('<span class="fa-regular fa-trash-can" title="Eliminar"></span>', ['delete', 'id' => $model->MenuID], [
                        'class' => 'cpanel-table-action click-confirm',
                        'tittle-alert' => 'Eliminar información',
                        'text-alert'  => '¿Estás seguro?. Cuando elimines el menú['.$model->MenuName.'],no podrás recuperarlo más tarde.',
                    ]);
                },
                'update' => function($url, $model){
                    return Html::a('<span class="fa-regular fa-pen-to-square" title="Editar"></span>', ['update', 'id' => $model->MenuID,], [
                        'class' => 'cpanel-table-action',

                        
                    ]);
                }
               
            ],
            'contentOptions'=>['style'=>'min-width: 100px; text-align: center; vertical-align:middle;'],
        ],
        
    ],
    'clientOptions' => [
    "lengthMenu"=> [[10,20,-1], [10,20,Yii::t('app',"All")]],
    "info"=>true,
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
                    'searchPlaceholder' => Yii::t('app', 'Buscar menu...'),
                    'lengthMenu'    => Yii::t('app','Mostrar _MENU_ registros'),
                    'info'        => Yii::t('app','Mostrando _START_ a _END_ de _TOTAL_ registros'),
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
$this->registerJS("
$(function(){
    var filter = $('.cpanel-menus-grid .dataTables_filter');
    var input = filter.find('input[type=\"search\"], input').first();

    if (input.length && !input.parent().hasClass('cpanel-filter-input-wrap')) {
        input.wrap('<span class=\"cpanel-filter-input-wrap\"></span>');
        input.before('<i class=\"fa-solid fa-magnifying-glass\" aria-hidden=\"true\"></i>');
    }
});
");
 ?>
