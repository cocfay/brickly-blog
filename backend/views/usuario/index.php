<?php

use frontend\assets\AppAsset;
AppAsset::register($this);

use yii\helpers\Html;
use yii\bootstrap4\Button;
use yii\bootstrap4\ActiveForm;
use common\components\datatables\DataTables;

$this->title = 'Lista de usuarios';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="usuario cpanel-table-page cpanel-users-page">
    <div class="cpanel-page-heading">
        <div>
            <h1><?= Html::encode($this->title) ?></h1>
            <?= Html::a('<i class="fa fa-plus"></i> Crear usuario', ['/usuario/createuser'], ['class' => 'btn btn-primary cpanel-create-btn']) ?>
        </div>
    </div>

    <div class="container-fluid px-0">
        <div class="cpanel-table-grid">
            <?php
                echo DataTables::widget([
                    'dataProvider' => $AgencysDat,
                    'tableOptions' => ['class' => 'table table-striped dt-responsive dataTable no-footer dtr-inline display responsive nowrap cpanel-modern-table', 'cellspacing' => '0', 'width' => '100%'],
                    'columns' => [
                        [
                            'class' => 'yii\grid\SerialColumn',
                            'headerOptions' => ['class' => 'cpanel-col-number'],
                            'contentOptions' => ['class' => 'cpanel-col-number'],
                        ],
                        [
                            'attribute' => 'Nombre de Usuario',
                            'class' => 'yii\grid\DataColumn',
                            'value' => function ($data) {
                                return $data->UserName;
                            },
                            'format' => 'text',
                            'contentOptions' => ['style' => 'vertical-align:middle;'],
                        ],
                        [
                            'attribute' => 'Name',
                            'header' => 'Nombre',
                            'format' => 'text',
                            'contentOptions' => ['style' => 'vertical-align:middle; min-width: 30%;'],
                        ],
                        [
                            'attribute' => 'Email',
                            'format' => 'text',
                            'contentOptions' => ['style' => 'vertical-align:middle;'],
                        ],
                        [
                            'attribute' => 'Tipo de Usuario',
                            'class' => 'yii\grid\DataColumn',
                            'value' => function ($data) {
                                return $data->typeUsers->Name;
                            },
                            'format' => 'text',
                            'contentOptions' => ['style' => 'text-align: center; vertical-align:middle;'],
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'header' => 'Acciones',
                            'headerOptions' => ['style' => 'text-align: center;'],
                            'template' => '<div class="btn-group">{update} {delete}</div>',
                            'buttons' => [
                                'delete' => function($url, $model) use ($redirect) {
                                    $uri = !empty($redirect) ? ['delete', 'id' => $model->AccountID, 'url' => $redirect] : ['delete', 'id' => $model->AccountID];
                                    return Html::a('<span class="fa-regular fa-trash-can" title="Eliminar"></span>', $uri, [
                                        'class' => 'cpanel-table-action click-confirm',
                                        'title-alert' => 'Eliminar informacion',
                                        'text-alert' => 'Estas seguro? Cuando elimines el usuario ['.$model->UserName.'], no podras recuperarlo mas tarde.',
                                    ]);
                                },
                                'update' => function($url, $model) {
                                    return Html::a('<span class="fa-regular fa-pen-to-square" title="Editar"></span>', ['update', 'id' => $model->AccountID], [
                                        'class' => 'cpanel-table-action',
                                    ]);
                                },
                                'project' => function($url, $model) {
                                    if ($model->TypeUser == 2) {
                                        return Html::a('<span class="fa fa-diagram-project" title="Proyectos"></span>', ['/projects/list', 'id' => $model->AccountID], [
                                            'class' => 'cpanel-table-action',
                                        ]);
                                    }

                                    return '';
                                },
                            ],
                            'contentOptions' => ['style' => 'min-width: 100px; text-align: center; vertical-align:middle;'],
                        ],
                    ],
                    'clientOptions' => [
                        'lengthMenu' => [[10, 20, -1], [10, 20, Yii::t('app', 'All')]],
                        'info' => true,
                        'retrieve' => true,
                        'responsive' => 'true',
                        'dom' => 'lfTrtip',
                        'tableTools' => [
                            'aButtons' => [],
                        ],
                        'language' => [
                            'processing' => Yii::t('app', 'Procesando...'),
                            'search' => Yii::t('app', 'Buscar:'),
                            'searchPlaceholder' => Yii::t('app', 'Buscar usuario...'),
                            'lengthMenu' => Yii::t('app', 'Mostrar _MENU_ registros'),
                            'info' => Yii::t('app', 'Mostrando _START_ a _END_ de _TOTAL_ registros'),
                            'infoEmpty' => Yii::t('app', 'Mostrando del 0 al 0 de 0 entradas'),
                            'infoFiltered' => Yii::t('app', '(Filtrado de _MAX_ entradas totales)'),
                            'infoPostFix' => '',
                            'loadingRecords' => Yii::t('app', 'Cargando...'),
                            'zeroRecords' => Yii::t('app', 'No se encontraron registros coincidentes'),
                            'emptyTable' => Yii::t('app', 'No hay datos disponibles en la tabla'),
                            'paginate' => [
                                'first' => Yii::t('app', '<<'),
                                'previous' => Yii::t('app', '<i class="fa-solid fa-chevron-left"></i>'),
                                'next' => Yii::t('app', '<i class="fa-solid fa-chevron-right"></i>'),
                                'last' => Yii::t('app', '>>'),
                            ],
                            'aria' => [
                                'sortAscending' => Yii::t('app', ': activate to sort column ascending'),
                                'sortDescending' => Yii::t('app', ': activate to sort column descending'),
                            ],
                        ],
                    ],
                ]);
            ?>
        </div>
    </div>
</div>

<?php
if (Yii::$app->session->hasFlash('success')):
    $this->registerJS('
        $(document).ready(function(){
            _Message("success","Exito","'.Yii::$app->session->getFlash('success').'");
        });
    ');
endif;

if (Yii::$app->session->hasFlash('error')):
    $this->registerJS('
        $(document).ready(function(){
            _Message("error","Error","'.Yii::$app->session->getFlash('error').'");
        });
    ');
endif;

$this->registerJS("
$(function(){
    var filter = $('.cpanel-table-grid .dataTables_filter');
    var input = filter.find('input[type=\"search\"], input').first();

    if (input.length && !input.parent().hasClass('cpanel-filter-input-wrap')) {
        input.wrap('<span class=\"cpanel-filter-input-wrap\"></span>');
        input.before('<i class=\"fa-solid fa-magnifying-glass\" aria-hidden=\"true\"></i>');
    }
});
");
?>
