<?php

use frontend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap5\Button;
use yii\bootstrap5\ActiveForm;
use common\components\datatables\DataTables;

$this->title = 'Roles';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="HomeRole cpanel-table-page cpanel-roles-page">
    <div class="cpanel-page-heading">
        <div>
            <h1><?= Html::encode($this->title) ?></h1>
            <button type="button" class="btn btn-primary cpanel-create-btn createrole-open">
                <i class="fa-solid fa-plus"></i> A&ntilde;adir rol
            </button>
        </div>
    </div>

    <div class="container-fluid px-0">
        <div class="cpanel-roles-grid">
            <?php
                echo DataTables::widget([
                    'dataProvider' => $dataProvider,
                    'tableOptions' => ['class' => 'table table-striped dt-responsive dataTable no-footer dtr-inline display responsive nowrap cpanel-roles-table', 'cellspacing' => '0', 'width' => '100%'],
                    'columns' => [
                        [
                            'class' => 'yii\grid\SerialColumn',
                            'headerOptions' => ['class' => 'cpanel-col-number'],
                            'contentOptions' => ['class' => 'cpanel-col-number'],
                        ],
                        [
                            'attribute' => 'Nombre del Rol',
                            'class' => 'yii\grid\DataColumn',
                            'value' => function ($data) {
                                return $data->RoleName;
                            },
                            'format' => 'text',
                            'contentOptions' => ['style' => 'vertical-align:middle;'],
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'header' => 'Acciones',
                            'headerOptions' => ['style' => 'text-align: center;'],
                            'template' => '<div class="btn-group">{update} {delete}</div>',
                            'buttons' => [
                                'delete' => function($url, $model) {
                                    return Html::a('<span class="fa-regular fa-trash-can" title="Eliminar"></span>', ['deleterole', 'id' => $model->RoleID], [
                                        'class' => 'cpanel-table-action click-confirm',
                                        'tittle-alert' => 'Eliminar información',
                                        'text-alert' => '¿Estás seguro de eliminar esta rol? Cuando elimines el rol, no podras recuperarlo mas tarde.',
                                    ]);
                                },
                                'update' => function($url, $model) {
                                    return '<button type="button" class="cpanel-table-action update roleupdate" idrole="'.$model->RoleID.'"><i class="fa-regular fa-pen-to-square" title="Editar"></i></button>';
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
                            'searchPlaceholder' => Yii::t('app', 'Buscar rol...'),
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

<div id="modal-create" class="modal fade cpanel-modal" role="dialog">
    <div class="modal-dialog">
        <?php $form = ActiveForm::begin(['action' => ['createrole'], 'id' => 'create-role-modal', 'method' => 'post']); ?>
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Crear rol</h4>
                <button type="button" class="btn-close" data-dismiss="modal" data-bs-dismiss="modal" data-cpanel-dismiss-modal aria-label="Cerrar"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="modal-body">
                <div class="cpanel-modal-field">
                    <?= $form->field($model, 'RoleName')->textInput(['maxlength' => true, 'class' => 'form-control cpanel-modal-input', 'placeholder' => 'Ej. Administrador'])->label('Nombre'); ?>
                    <span class="cpanel-modal-field-icon"><i class="fa-regular fa-user"></i></span>
                </div>
            </div>
            <div class="modal-footer">
                <?= Html::submitButton('<i class="fa-solid fa-plus"></i> Crear', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>

<div id="modal-update" class="modal fade cpanel-modal" role="dialog">
    <div class="modal-dialog">
        <?php $form = ActiveForm::begin(['action' => ['updaterole'], 'id' => 'update-role-modal', 'method' => 'post']); ?>
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Actualizar rol</h4>
                <button type="button" class="btn-close" data-dismiss="modal" data-bs-dismiss="modal" data-cpanel-dismiss-modal aria-label="Cerrar"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="modal-body">
                <div class="cpanel-modal-field">
                    <?= $form->field($model, 'RoleName')->textInput(['maxlength' => true, 'id' => 'UpdateRole', 'class' => 'form-control cpanel-modal-input', 'placeholder' => 'Ej. Administrador'])->label('Nombre'); ?>
                    <span class="cpanel-modal-field-icon"><i class="fa-regular fa-user"></i></span>
                </div>
                <?= $form->field($model, 'RoleID')->hiddenInput(['id' => 'UpdateRoleID'])->label(false); ?>
            </div>
            <div class="modal-footer">
                <?= Html::submitButton('Actualizar', ['class' => 'btn btn-primary click-confirm']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>

<?php
if (Yii::$app->session->hasFlash('success')):
    $this->registerJS('
        $(document).ready(function(){
            showMassAlert("success","'.Yii::$app->session->getFlash('success').'");
        });
    ');
endif;

if (Yii::$app->session->hasFlash('error')):
    $this->registerJS('
        $(document).ready(function(){
            showMassAlert("danger","'.Yii::$app->session->getFlash('error').'");
        });
    ');
endif;

$JS = "
function cpanelRoleModal(selector, action) {
    var modal = document.querySelector(selector);
    if (!modal) {
        return;
    }

    if (window.bootstrap && bootstrap.Modal) {
        bootstrap.Modal.getOrCreateInstance(modal)[action]();
        return;
    }

    if (window.jQuery && typeof $(modal).modal === 'function') {
        $(modal).modal(action);
        return;
    }

    modal.classList[action === 'show' ? 'add' : 'remove']('show');
    modal.style.display = action === 'show' ? 'block' : 'none';
    modal.setAttribute('aria-hidden', action === 'show' ? 'false' : 'true');
}

$('.createrole-open').click(function(e){
    e.preventDefault();
    cpanelRoleModal('#modal-create', 'show');
});
$(document).on('click', '.roleupdate', function(e){
    e.preventDefault();
    var idrole = $(this).attr('idrole');
    $.post('ajaxrole', { id: idrole }, function(dt){
        obj = JSON.parse(dt);
        $('#UpdateRoleID').val(obj.RoleID);
        $('#UpdateRole').val(obj.RoleName);
        cpanelRoleModal('#modal-update', 'show');
    });
});
$(document).on('click', '[data-cpanel-dismiss-modal]', function(e){
    e.preventDefault();
    cpanelRoleModal('#' + $(this).closest('.modal').attr('id'), 'hide');
});

$(function(){
    var filter = $('.cpanel-roles-grid .dataTables_filter');
    var input = filter.find('input[type=\"search\"], input').first();

    if (input.length && !input.parent().hasClass('cpanel-filter-input-wrap')) {
        input.wrap('<span class=\"cpanel-filter-input-wrap\"></span>');
        input.before('<i class=\"fa-solid fa-magnifying-glass\" aria-hidden=\"true\"></i>');
    }
});
";
$this->registerJS($JS);
?>
