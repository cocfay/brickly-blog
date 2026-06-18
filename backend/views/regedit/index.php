<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;

$this->title = 'Canales de notificaciones';
?>

<div class="topics-notifications-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::button('Crear nuevo', ['value' => Url::to(['/regedit/create']), 'class' => 'btn btn-success', 'id' => 'modalButton']) ?>
    </p>

    <?php Pjax::begin(['id' => 'pjax-container']); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'ChannelKey',
            'Channel',
            'Description:ntext',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
                'buttons' => [
                    'update' => function ($url, $model) {
                        return Html::button('Editar', [
                            'value' => Url::to(['/regedit/update','id'=>$model->primaryKey]),
                            'class' => 'btn btn-primary btn-sm modalButton'
                        ]);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('Eliminar', ['delete', 'id' => $model->primaryKey], [
                            'data' => [
                                'confirm' => '¿Estás seguro de eliminar este elemento?',
                                'method' => 'post',
                            ],
                            'class' => 'btn btn-danger btn-sm'
                        ]);
                    }
                ],
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>
</div>

<?php
yii\bootstrap5\Modal::begin([
    'title' => '<h4 id="modal-title"></h4>',
    'id' => 'modal',
    'size' => 'modal-lg',
]);

echo "<div id='modalContent'></div>";

yii\bootstrap5\Modal::end();
?>

<?php
$this->registerJs("
    $(document).on('click', '#modalButton, .modalButton', function(){
        $('#modal').modal('show')
            .find('#modalContent')
            .load($(this).attr('value'));
        $('#modal-title').text($(this).text());
    });

    $(document).on('beforeSubmit', 'form#topics-form', function () {
        var form = $(this);
        $.post(
            form.attr('action'),
            form.serialize()
        ).done(function(result) {
            if(result === 'success') {
                $('#modal').modal('hide');
                $.pjax.reload({container: '#pjax-container'});
            } else {
                $('#modalContent').html(result);
            }
        });
        return false;
    });
");
?>