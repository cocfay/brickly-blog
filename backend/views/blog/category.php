<?php
    use frontend\assets\AppAsset;
    use yii\helpers\Html;
    use yii\bootstrap5\Button;
    use yii\bootstrap5\ActiveForm;
    use yii\helpers\Url;
    use yii\data\ActiveDataProvider;
    use common\models\Collections;
    use common\components\datatables\DataTables;

    $model = $model ?? new Collections();
    $dataProvider = $dataProvider ?? new ActiveDataProvider([
        'query' => Collections::find()->select(['*', 'NameEs AS Name']),
        'pagination' => [
            'pageSize' => 10,
        ],
    ]);

    $this->title = 'Listado de categorias';
?>

<div class="HomeRole cpanel-table-page">
    <div class="cpanel-page-heading">
        <div>
            <h1><?= Html::encode($this->title) ?></h1>
            <button type="button" class="btn btn-primary cpanel-create-btn createrole-open" data-bs-toggle="modal" data-bs-target="#addrol">
                <i class="fa fa-plus"></i> Agregar categor&iacute;a
            </button>
        </div>
    </div>

    <div class="container-fluid px-0">
        <div class="cpanel-table-grid">
            <?php
                echo DataTables::widget([
                    'dataProvider' => $dataProvider,
                    'tableOptions' => ['class' => 'table table-striped dt-responsive dataTable no-footer dtr-inline display responsive nowrap cpanel-modern-table', 'cellspacing' => '0', 'width' => '100%'],
                    'columns' => [
                        [
                            'class' => 'yii\grid\SerialColumn',
                            'headerOptions' => ['class' => 'cpanel-col-number'],
                            'contentOptions' => ['class' => 'cpanel-col-number'],
                        ],
                        [
                            'attribute' => 'Nombre',
                            'class' => 'yii\grid\DataColumn',
                            'value' => function ($data) {
                                return $data->Name;
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
                                    return Html::a('<i class="fa-regular fa-trash-can" title="Eliminar"></i>', ['dcategory', 'id' => $model->CollectionID], [
                                        'class' => 'cpanel-table-action click-confirm',
                                        'tittle-alert' => 'Eliminar informacion',
                                        'text-alert' => 'Estas seguro? Cuando elimines la categoria, no podras recuperarlo mas tarde.',
                                    ]);
                                },
                                'update' => function($url, $model) {
                                    return '<button type="button" class="cpanel-table-action update" id="'.$model->CollectionID.'" data-bs-toggle="modal" data-bs-target="#editrol"><i class="fa-regular fa-pen-to-square" title="Editar"></i></button>';
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

<div class="modal fade cpanel-modal" id="addrol" tabindex="-1" aria-labelledby="addCategoryLabel" aria-hidden="true">
    <div class="modal-dialog">
        <?php $form = ActiveForm::begin(['action' => ['accioncategory'], 'method' => 'post']); ?>
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title" id="addCategoryLabel">A&ntilde;adir categor&iacute;a</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="modal-body">
                <div class="cpanel-modal-field">
                    <?= $form->field($model, 'Name')->textInput(['maxlength' => true, 'class' => 'form-control cpanel-modal-input', 'placeholder' => 'Ej. Tecnologia'])->label('Nombre'); ?>
                    <span class="cpanel-modal-field-icon"><i class="fa-regular fa-folder"></i></span>
                </div>
            </div>
            <div class="modal-footer">
                <?= Html::submitButton('<i class="fa-solid fa-plus"></i> A&ntilde;adir', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>

<div class="modal fade cpanel-modal" id="editrol" tabindex="-1" aria-labelledby="editCategoryLabel" aria-hidden="true">
    <div class="modal-dialog">
        <?php $form = ActiveForm::begin(['action' => ['accioncategory'], 'method' => 'post']); ?>
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title" id="editCategoryLabel">Actualizar categor&iacute;a</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="modal-body">
                <div class="cpanel-modal-field">
                    <?= $form->field($model, 'Name')->textInput(['id' => 'UpdateName', 'maxlength' => true, 'class' => 'form-control cpanel-modal-input', 'placeholder' => 'Ej. Tecnologia'])->label('Nombre'); ?>
                    <span class="cpanel-modal-field-icon"><i class="fa-regular fa-folder"></i></span>
                </div>
                <?= $form->field($model, 'CollectionID')->hiddenInput(['id' => 'UpdateID'])->label(false); ?>
            </div>
            <div class="modal-footer">
                <?= Html::submitButton('Actualizar', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
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

$JS = "
const edit = document.querySelectorAll('.update');
edit.forEach(i => {
    i.addEventListener('click', (e) => {
        var id = e.currentTarget.id;
        $.post('ecategory', { id: id }, function(dt){
            obj = JSON.parse(dt);
            $('#UpdateID').val(obj.CollectionID);
            $('#UpdateName').val(obj.Name);
        });
    });
});
";
$this->registerJS($JS);
?>
