<?php
    use frontend\assets\AppAsset;
    use yii\helpers\Html;
    use yii\helpers\Url;
    use yii\data\ActiveDataProvider;
    use common\models\PostBlog;

    use common\components\datatables\DataTables;
?>
<style>
.btn-featured.active i,
.btn-featured.active .fa-thumbtack {
    opacity: 1;
    transform: scale(1.15);
}
.btn-featured:not(.active) i,
.btn-featured:not(.active) .fa-thumbtack {
    opacity: 0.45;
}

/* --- Checkbox redondo estilo agentes --- */
.round-checkbox {
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    width: 18px;
    height: 18px;
    border: 2px solid #6c757d;
    border-radius: 50%;
    outline: none;
    cursor: pointer;
    display: inline-block;
    vertical-align: middle;
    position: relative;
    transition: all 0.2s ease;
}
.round-checkbox:checked {
    background-color: #000000;
    border-color: #000000;
}
.round-checkbox:checked::after {
    content: '';
    position: absolute;
    top: 3px;
    left: 3px;
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background-color: white;
}
.round-checkbox:hover {
    border-color: #0d6efd;
}

/* --- Toolbar acciones masivas --- */
.mass-actions-toolbar {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 8px 12px;
    margin-bottom: 10px;
}
.btn-mass-delete {
    font-size: 16px;
    transition: opacity 0.2s ease;
}
.btn-mass-delete:disabled {
    opacity: 0.4;
    cursor: not-allowed;
}

/* --- Alert flotante --- */
.mass-delete-alert {
    position: fixed;
    bottom: 20px;
    right: 20px;
    z-index: 9999;
    min-width: 280px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}
</style>
<?php

	$dataProvider = $dataProvider ?? new ActiveDataProvider([
	    'query' => PostBlog::find()->where(['Verified' => 1])->orderBy(['Featured' => SORT_DESC, 'PostBlogID' => SORT_DESC]),
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

                <!-- Toolbar de eliminación masiva -->
                <div class="mass-actions-toolbar" id="massActionsToolbar">
                    <button type="button" class="btn btn-sm btn-outline-dark rounded-4 px-3 btn-mass-delete" id="btnMassDelete" disabled>
                        <i class="fa-regular fa-trash-can"></i> Eliminar
                    </button>
                </div>

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
                                [
                                    'attribute' => '',
                                    'class' => 'yii\grid\DataColumn',
                                    'headerOptions' => ['style' => 'text-align: center; width: 40px;'],
                                    'contentOptions' => ['class' => 'text-center'],
                                    'value' => function ($data) {
                                        $id = $data->PostBlogID;
                                        return "<input type=\"checkbox\" class=\"round-checkbox post-checkbox\" value=\"{$id}\">";
                                    },
                                    'format' => 'raw',
                                ],
                                [
                                  'attribute' => 'Entrada',
                                   'class' => 'yii\grid\DataColumn',
                                    'value' => function ($data) {
                                        return $data->title;
                                    },
                                    'format' => 'text',
                                    'contentOptions'=>['class' => 'cpanel-post-title-cell'],
                                ],
                                [
                                    'attribute' => 'Categoría',
                                    'class' => 'yii\grid\DataColumn',
                                    'value' => function ($data) {
                                        $categories = $data->blogBy;
                                        if (!$categories) return '-';
                                        $names = [];
                                        foreach ($categories as $cat) {
                                            $names[] = $cat->NameEs;
                                        }
                                        return implode(', ', $names);
                                    },
                                    'format' => 'raw',
                                    'contentOptions' => ['style' => 'white-space: normal;'],
                                ],
                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'header' => 'Acciones',
                                    'headerOptions' => ['style' => 'text-align: center;'],
                                    'template' => '<div class="cpanel-table-actions"> {featured} {update} {view} {delete} </div>',
                                    'buttons' => [
                                        'featured' => function($url, $model){
                                            $isFeatured = $model->Featured == 1;
                                            $isFeatured == 1 ? $title = 'Artículo destacado' : $title = 'Destacar artículo';
                                            $class = $isFeatured ? 'cpanel-table-action btn btn-link btn-featured active' : 'cpanel-table-action btn btn-link btn-featured';
                                            return Html::a('<i class="fa-regular fa-star"></i>', '#', [
                                                'class' => $class,
                                                'data-id' => $model->PostBlogID,
                                                'data-featured' => $model->Featured,
                                                'title' => $title,
                                            ]);
                                        },
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
                                            return Html::a('<span class="fa-regular fa-eye" title="Ver"></span>', Url::to('@raizweb') . '/blog/post/' . $model->PostBlogID, [
                                                'class' => 'cpanel-table-action btn btn-link', 'target' => '_blank'
                                            ]);
                                        },
                                    ],
                                    'contentOptions'=>['class'=>'cpanel-actions-cell text-center'],
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

<script>
document.addEventListener('DOMContentLoaded', function(){
    console.log('Blog index JS loaded');

    // Featured button handler (existing)
    document.querySelectorAll('.btn-featured').forEach(function(btn){
        btn.addEventListener('click', function(e){
            e.preventDefault();
            var id = this.getAttribute('data-id');
            console.log('Featured click, id:', id);
            
            if (!id) {
                alert('No ID found');
                return;
            }
            
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '<?= Url::to(['blog/featured']) ?>', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    console.log('Response:', response);
                    if (!response.error) {
                        _Message("success", "¡Exito!", "Artículo destacado");
                        setTimeout(function(){
                            location.reload();
                        }, 1200);
                    } else {
                        alert('Error: ' + response.message);
                    }
                } else {
                    alert('HTTP ' + xhr.status + ': ' + xhr.responseText);
                }
            };
            xhr.onerror = function() {
                alert('Network error');
            };
            xhr.send('id=' + encodeURIComponent(id));
        });
    });

    // --- Lógica de selección múltiple y eliminación masiva ---

    const table = document.getElementById('posts-table');
    if (!table) return;

    const btnMassDelete = document.getElementById('btnMassDelete');

    // Función para obtener los IDs seleccionados
    function getSelectedIds() {
        const checkboxes = table.querySelectorAll('.post-checkbox:checked');
        return Array.from(checkboxes).map(cb => cb.value);
    }

    // Habilitar/deshabilitar botón según checkboxes seleccionados
    function toggleMassDeleteButton() {
        const checked = table.querySelectorAll('.post-checkbox:checked');
        btnMassDelete.disabled = checked.length === 0;
    }

    // Evento: cambio en cualquier checkbox
    table.addEventListener('change', function(e) {
        if (e.target.classList.contains('post-checkbox')) {
            toggleMassDeleteButton();
        }
    });

    // Función para mostrar alerta flotante
    function showMassAlert(type, message) {
        // Remover alerta existente
        const existing = document.querySelector('.mass-delete-alert');
        if (existing) existing.remove();

        const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
        const bgClass = type === 'success' ? 'bg-success' : 'bg-danger';

        const alertDiv = document.createElement('div');
        alertDiv.className = 'mass-delete-alert alert alert-dismissible fade show ' + bgClass + ' text-white';
        alertDiv.innerHTML = `
            <div class="d-flex align-items-center gap-2">
                <i class="fa-solid ${icon}"></i>
                <span>${message}</span>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
            </div>
        `;
        document.body.appendChild(alertDiv);

        setTimeout(function() {
            if (alertDiv.parentNode) alertDiv.remove();
        }, 5000);
    }

    // Evento: Botón "Eliminar seleccionados"
    btnMassDelete.addEventListener('click', async function() {
        const ids = getSelectedIds();
        if (ids.length === 0) return;

        // Confirmación
        const confirmMsg = ids.length === 1
            ? '¿Estás seguro? Cuando elimines la entrada, no podrás recuperarlo más tarde.'
            : `¿Estás seguro? Cuando elimines las ${ids.length} entradas, no podrás recuperarlas más tarde.`;

        if (!confirm(confirmMsg)) return;

        // Deshabilitar botón y mostrar estado de carga
        btnMassDelete.disabled = true;
        btnMassDelete.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Eliminando...';

        try {
            const response = await fetch('<?= Url::to(['blog/massive-delete']) ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'ids[]=' + ids.join('&ids[]=')
            });

            const result = await response.json();

            if (result.success) {
                showMassAlert('success', result.message || 'Artículos eliminados correctamente.');
                setTimeout(function() {
                    location.reload();
                }, 1200);
            } else {
                showMassAlert('danger', result.error || 'Error al eliminar artículos.');
                btnMassDelete.disabled = false;
                btnMassDelete.innerHTML = '<i class="fa-regular fa-trash-can"></i> Eliminar';
            }
        } catch (error) {
            showMassAlert('danger', 'Error de red al intentar eliminar.');
            btnMassDelete.disabled = false;
            btnMassDelete.innerHTML = '<i class="fa-regular fa-trash-can"></i> Eliminar';
        }
    });
});
</script>
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
