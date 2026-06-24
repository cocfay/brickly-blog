<?php
    use frontend\assets\AppAsset;
    use yii\helpers\Html;
    use yii\bootstrap5\Button;
    use yii\bootstrap5\ActiveForm;
    use yii\helpers\Url;
    use yii\data\ActiveDataProvider;
    use common\models\PostBlog;

    use common\components\datatables\DataTables;

	$dataProvider = $dataProvider ?? new ActiveDataProvider([
	    'query' => PostBlog::find()->where(['Verified' => 1, 'Featured' => 0])->orderBy(['PostBlogID' => SORT_DESC]),
	    'pagination' => [
	        'pageSize' => 10,
	    ],
	]);

    $this->title = 'Listado de entradas';
?>

<div class="HomeRole cpanel-table-page cpanel-posts-page">
    <div class="container-fluid px-0">
    <div class="row">
        <div class="col-md-12 d-flex justify-content-between align-items-start gap-4 cpanel-page-heading">
            <div>
                <h1><?= Html::encode($this->title)?></h1>
                <a href="<?= Url::to(['form-post']) ?>" class="btn btn-primary cpanel-create-btn cpanel-add-entry-btn"><i class="fa-solid fa-plus"></i> Agregar entrada</a>
            </div>
        </div>
    </div>
        <div class="row">
            <div class="col-12">
                <?php   
                    echo DataTables::widget([
                            'dataProvider' => $dataProvider,
                            'options' => ['class' => 'cpanel-posts-grid'],
                            'tableOptions' => [
                                'id' => 'posts-table',
                                'class' => 'table table-striped cpanel-posts-table display',
                                'cellspacing' => '0',
                                'width' => '100%',
                            ],
                            'columns' => [
                                [
                                    'class' => 'yii\grid\SerialColumn',
                                    'headerOptions' => ['class' => 'cpanel-col-number'],
                                    'contentOptions'=>['class' => 'cpanel-col-number'],
                                ],
                                // Simple columns defined by the data contained in $dataProvider.
                                // Data from the model's column will be used.
                                [
                                  'attribute' => 'Entrada',
                                   'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
                                    'value' => function ($data) {
                                        return $data->title; // $data['name'] for array data, e.g. using SqlDataProvider.
                                    },
                                    'format' => 'text',
                                    'contentOptions'=>['class' => 'cpanel-post-title-cell'],
                                ],
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'header' => 'Acciones',
                                    'headerOptions' => ['style' => 'text-align: center;'],
                                    'template' => '<div class="cpanel-table-actions"> {update} {view} {delete} </div>',
                                    'buttons' => [
                                        'delete' => function($url, $model){
                                            return Html::a('<span class="fa-regular fa-trash-can"></span>', ['deletepts', 'id' => $model->PostBlogID], [
                                                'class' => 'cpanel-table-action btn btn-link click-confirm',
                                                'tittle-alert' => 'Eliminar información',
                                                'text-alert'  => '¿Estás seguro? Cuando elimines la entrada, no podrás recuperarlo más tarde.',
                                            ]);
                                        },
                                        'update' => function($url, $model){
                                            return Html::a('<span class="fa-regular fa-pen-to-square"></span>', ['form-post', 'edit' => $model->PostBlogID], [
                                                'class' => 'cpanel-table-action btn btn-link',
                                            ]);
                                        },

                                        'view' => function($url, $model){

                                            return Html::a('<span class="fa-regular fa-eye" title="Ver"></span>', 'https://www.weclickdigital.com/blog/post/' . $model->PostBlogID, [
                                                'class' => 'cpanel-table-action btn btn-link', 'target' => '_blank'
                                            ]);
                                        
                                        },
                                       
                                    ],
                                    'contentOptions'=>['class'=>'cpanel-actions-cell'],
                                ],
                                
                            ],
                            'clientOptions' => [
                            "lengthMenu"=> [[10,20,-1], [10,20,Yii::t('app',"All")]],
                            "info"=>true,
                            "retrieve" => true,
                            "responsive"=> true,
                            "autoWidth"=> false,
                            "scrollX"=> false,
                            "dom"=> 'lfTrtip',
                            "tableTools"=>[
                                "aButtons"=> [  
                                ]
                            ],
                            'language'=>[
                                'processing'    => Yii::t('app', 'Procesando...'),
                                'search'        => Yii::t('app', 'Buscar:'),
                                'searchPlaceholder' => Yii::t('app', 'Buscar entrada...'),
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
    var filter = $('.cpanel-posts-grid .dataTables_filter');
    var input = filter.find('input[type=\"search\"], input').first();

    if (input.length && !input.parent().hasClass('cpanel-filter-input-wrap')) {
        input.wrap('<span class=\"cpanel-filter-input-wrap\"></span>');
        input.before('<i class=\"fa-solid fa-magnifying-glass\" aria-hidden=\"true\"></i>');
    }
});
");

?>
