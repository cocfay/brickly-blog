
<?php
    use yii\helpers\Html;
    use yii\helpers\Url;
    use yii\bootstrap5\ActiveForm;
    use common\components\datatables\DataTables;
    $this->title = "Informe detallado de pago";
?>

<div class="d-flex align-items-start justify-content-between mb-5">
    <h3><?= $this->title ?></h3>
    <a href="<?= Url::to(['pay-serv-provider', 'id' => 1]) ?>" title="Atrás"><i class="fa-regular fa-circle-left fs-1" style="color: #FF0461"></i></a>
</div>

<?php
    /* $column[] = [
        'class' => 'yii\grid\SerialColumn', 'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;']
    ]; */

    
    $column[] = [
        'attribute' => 'issueDate',
        'value' => function ($data) {
            return Date('d-m-Y', strtotime($data->issueDate));
        },
        'format' => 'text',
        'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;'],
    ];

    $column[] = [
        'header' => 'Monto',
        'attribute' => 'monthlyAmount',
        'format' => 'text',
        'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;']
    ];

    $column[] = [
        'header' => 'Pagado',
        'attribute' => 'Amount',
        'format' => 'text',
        'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;']
    ];

    $column[] = [
        'attribute' => 'Date',
        'value' => function ($data) {
                return Date('d-m-Y H:i', strtotime($data->Date));
            },
        'format' => 'text',
        'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;'],
    ];

    $column[] = [
        'attribute' => 'Photo',
        'value' => function ($data, $url) {
                return "<a href='".Yii::getAlias('@web').'/../uploads/'.$data->Photo."' target='_blank' title='ver comprobante'><i class='fa-solid fa-file-image fs-3'></i></a>";
            },
        'format' => 'raw',
        'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;'],
    ];

    echo DataTables::widget([
        'dataProvider' => $dataProvider,
        'columns' => $column,
        'clientOptions' => [
            "lengthMenu"=> [[10,20,30,-1], [10,20,30,Yii::t('app',"All")]],
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
?>

<!-- <div class="fs-4">
    <?php 
        $sum = 0;
        foreach($query as $q){
            $sum+= $q->Amount;
        }
    ?>
    <b>Total:</b> Q <?= number_format($sum, 2, '.', ',') ?>
</div> -->