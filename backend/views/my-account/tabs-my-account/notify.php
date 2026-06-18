<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\widgets\Pjax;
use yii\grid\GridView;
use yii\bootstrap5\Modal;
use common\components\datatables\DataTables; // Componente específico
date_default_timezone_set('America/Guatemala');
$ActualDate = new \DateTime();
?>
<div class="row mt-4">
    <div class="col-md-12">
        <div class="fs-3" style="color: var(--bs-dark)">Notificaciones y avisos</div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 d-flex justify-content-end gap-2 my-4">
        <?= Html::a('<img src="' . Yii::getAlias('@web') . '/images/site/notificacionleida.png" alt="image" style="width: 42px;">','#nav-notify',['title' => 'Marcar todas las notificaciones como leidas', 'data'=>['method'=>'post','confirm'=>'¿Esta seguro?', 'params'=>['NotifyMarkAllRead' => 1]]]); ?>
        <?= Html::a('<img src="' . Yii::getAlias('@web') . '/images/site/eliminarnotificaciones.png" alt="image" style="width: 42px;">','#nav-notify',['title' => 'Eliminar todas las notificaciones leidas', 'data'=>['method'=>'post','confirm'=>'¿Esta seguro?','params'=>['NotifyAllReadDelete' => 1]]]); ?>
    </div>
    <div class="col-md-12">
        <?php
        // Usar el componente específico de DataTables
        echo DataTables::widget([
            'dataProvider' => new \yii\data\ArrayDataProvider([
                'allModels' => \Yii::$app->SystemNotifications->getNotificationsForAccount($UserData->AccountID, 100),
                'pagination' => [
                    'pageSize' => 10,
                ],
            ]),
            'columns' => [
                [
                    'attribute' => 'UrlIcon',
                    'label' => 'Logotipo',
                    'format' => 'raw',
                    'contentOptions' => ['class' => 'text-center', 'style' => 'vertical-align: middle'],
                    'headerOptions' => ['style' => 'width: 16%'],
                    'value' => function($model) use ($UserData) {
                        $img = is_null($model['UrlIcon']) ?  Yii::getAlias('@web').'/images/'.$UserData->ImgCompany : $model['UrlIcon'];
                        $LogoImg = Html::img($img, [
                            'onerror' => "this.src='".Url::to('@raizweb')."/images/logo.png'",
                            'style' => 'height: auto; width: 100%; object-fit: contains;'
                        ]);

                        return Html::tag('div', $LogoImg, ['style' => 'width: 70px; height: 70px; background: var(--bs-table-bg); border-radius: 6%', 'class' => 'py-1 px-2 d-flex align-items-center m-auto']);
                    }
                ],
                [
                    'attribute' => 'Title',
                    'label' => 'Título',
                    'headerOptions' => ['style' => 'width: 16%'],
                    'contentOptions' => ['style' => 'vertical-align: middle;'],
                ],
                [
                    'attribute' => 'Body',
                    'label' => 'Notificación',
                    'headerOptions' => ['style' => 'width: 16%'],
                    'contentOptions' => ['style' => 'vertical-align: middle;'],
                    'value' => function($model) {
                        //return substr($model['Body'], 0, 60) . (strlen($model['Body']) > 60 ? '...' : '');
                        return $model['Body'];
                    }
                ],
                [
                    'label' => 'Hace',
                    'headerOptions' => ['style' => 'width: 16%'],
                    'contentOptions' => ['style' => 'vertical-align: middle;'],
                    'value' => function($model) use ($ActualDate) {
                        $createdAt = new \DateTime($model['CreatedAt']);
                        $Diff = $ActualDate->diff($createdAt); 
                        $message = "";
                        
                        if($Diff->y > 0){
                            $message .= $Diff->y." ";
                            $message .= ($Diff->y > 1)?'años':'año';
                        }
                        elseif($Diff->m > 0){
                            $message .= $Diff->m." ";
                            $message .= ($Diff->m > 1)?'meses':'mes';
                        }
                        elseif($Diff->d > 0){
                            $WeekDay = '';
                            $num = $Diff->d;
                            if($Diff->d >= 7){
                                $num = ceil(($Diff->d / 7));
                                if($num > 1){
                                    $WeekDay = 'semanas';
                                }else{
                                    $WeekDay = 'semana';
                                }
                            }else{
                                if($num > 1){
                                    $WeekDay = 'dias';
                                }else{
                                    $WeekDay = 'día';
                                }
                            }
                            $message .= "{$num} {$WeekDay}";
                        }
                        elseif($Diff->h > 0){
                            $message .= $Diff->h." ";
                            $message .= ($Diff->h > 1)?'horas':'hora';
                        }
                        elseif($Diff->i > 0){
                            $message .= $Diff->i." ";
                            $message .= ($Diff->i > 1)?"minutos":"minuto";
                        }else{
                            $message .= " menos de 1 minuto";
                        }
                        
                        return $message;
                    }
                ],
                [
                    'attribute' => 'Status',
                    'label' => 'Estado',
                    'headerOptions' => ['style' => 'width: 16%'],
                    'contentOptions' => ['style' => 'vertical-align: middle;'],
                    'value' => function($model) {
                        return $model['Status'] == 'unread' ? 'Sin leer' : 'Vista';
                    }
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'header' => 'Acciones',
                    //'format' => 'raw',
                    'headerOptions' => ['style' => 'width: 16%'],
                    'contentOptions' => ['style' => 'text-align: center; vertical-align: middle;'],
                    'template' => '<div class="btn-group" > {view} {delete} </div>',
                    'buttons' => [
                        'view' => function($url, $model){
                            return  Html::button('<i class="fa fa-eye"></i>', [
                            'class' => 'btn btn-sm btn-info btn-view-notify',
                            'data-id' => $model['NotificationID']]);
                        },
                        'delete' => function($url, $model){
                            return $deleteBtn = Html::a('<i class="fa fa-trash"></i>', '#nav-notify', [
                                'class' => 'btn btn-sm btn-danger',
                                'data' => [
                                    'method' => 'post',
                                    'confirm' => '¿Esta seguro?',
                                    'params' => ['NotifyIdDelete' => $model['NotificationID']]
                                ]
                            ]);
                        }
                    ],
                ]
            ],
            'clientOptions' => [
                'responsive' => true,
                'info' => false,
                'lengthChange' => false,
                'autoWidth' => false,
                'retrieve' => true, // Permite obtener la instancia existente :cite[10]
                'language' => [
                    /* 'url' => "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json", */
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
                ]
            ],
            'tableOptions' => [
                'class' => 'table table-striped table-bordered',
                'id' => 'notifications-table',
                'style' => 'width:100%'
            ],
        ]);
        ?>
    </div>
</div>

<?php 
Modal::begin([
    'title' => "Notificacion/Aviso",
    'id' => "notify-alert-modal",
    'size' => 'modal-md'
]);
?>

<div class="row">
    <div class="col-md-12 d-flex justify-content-center align-items-center">
        <img id="image-for-notify" src="" onerror="this.src='<?= Url::to('@raizweb'); ?>/images/logo.png'" alt="" style="height:70px; width:auto;">
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <h4 id="title-for-notify"></h4>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div id="body-for-notify"></div>
    </div>
</div>

<?php 
Modal::end(); 
?>

<?php
$JS = <<<JS
// Variable global para almacenar la instancia de DataTable
var dataTableInstance = null;

// Función para inicializar DataTable
function initDataTable() {
    // Verificar si ya existe una instancia de DataTable :cite[10]
    if ($.fn.DataTable.isDataTable('#notifications-table')) {
        dataTableInstance = $('#notifications-table').DataTable();
        return dataTableInstance;
    }
    
    // Si no existe, inicializar con las opciones del componente
    dataTableInstance = $('#notifications-table').DataTable({
        responsive: true,
        info: false,
        lengthChange: false,
        autoWidth: false,
        retrieve: true, // Permite obtener la instancia existente :cite[10]
        language: {
            url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        }
    });
    
    return dataTableInstance;
}

// Inicializar DataTable cuando el documento esté listo
$(document).ready(function() {
    // Solo inicializar si la pestaña está activa
    if ($('#nav-notify-tab').hasClass('active')) {
        setTimeout(function() {
            initDataTable();
        }, 100);
    }
});

// Escuchar cuando se muestra la pestaña de Notificaciones
if($('#nav-users-tab').length > 0){
    document.getElementById('nav-notify-tab').addEventListener('shown.bs.tab', function(e) {
        // Pequeño retraso para permitir que la pestaña se renderice completamente
        setTimeout(function() {
            initDataTable();
            
            // Recalcular dimensiones después de inicializar
            if (dataTableInstance) {
                setTimeout(function() {
                    dataTableInstance.columns.adjust().responsive.recalc();
                }, 150);
            }
        }, 50);
    });
}

// Delegación de eventos para los botones de visualización
$(document).on('click', '.btn-view-notify', function(e){
    let id = $(this).data('id');
    $.get("my-account/read-notify", {id: id}, function(r){
        $('#image-for-notify').attr('src','');
        $('#title-for-notify').html('');
        $('#body-for-notify').html('');
        if(r){
            $('#image-for-notify').attr('src',r.UrlIcon);
            $('#title-for-notify').html(r.Title);
            $('#body-for-notify').html(r.Body);
            $('#notify-alert-modal').modal('show');
        }
    });
});

// Manejar redimensionamiento de ventana
$(window).on('resize', function() {
    if (dataTableInstance) {
        setTimeout(function() {
            dataTableInstance.columns.adjust().responsive.recalc();
        }, 100);
    }
});
JS;

$this->registerJS($JS);