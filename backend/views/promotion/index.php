<?php 
    use yii\helpers\Html;
    use yii\helpers\Url;
    //  use frontend\assets\AppAssetLayoutAll;
    //  AppAssetLayoutAll::register($this);
    use yii\bootstrap5\ActiveForm;
    use common\components\datatables\DataTables;
    $this->title = 'Promociones';
?>

<style>
    .ck.ck-content.ck-editor__editable.ck-rounded-corners.ck-editor__editable_inline{
        min-height: 120px;
    }
    p{
        margin-bottom: 0;
    }
</style>


<div class="container-fluid">
  <h1 style="color: var(--color-principal);">Promociones</h1>
    <hr>
    <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#create-modal"><i class="fa fa-plus"></i> Crear nueva promoción</a>
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
            'attribute' => 'Text',
            'format' => 'html',
            'contentOptions'=>['style'=>'vertical-align:middle;'],
        ],
        [
            'attribute' => 'Visible',
            'format' => 'text',
            'value' => function ($data) {
                return $data->Visible ? 'Visible' : 'Oculto';
            },
            'contentOptions'=>['style'=>'vertical-align:middle;'],
        ],
        /* [
          'attribute' => 'Icon',
           'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
            'value' => function ($data) {
              $htm = "<i class='fa ".$data->ClassIcon."''></i>";
                return $htm; // $data['name'] for array data, e.g. using SqlDataProvider.
            },
            'format' => 'html',
            'contentOptions'=>['style'=>'text-align: center; vertical-align:middle;'],
        ], */
        /* [
            'attribute' => 'ControllerUse',
            'format' => 'text',
            'contentOptions'=>['style'=>'vertical-align:middle;'],
        ], */
        /* [
          'attribute' => 'Type',
           'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
            'value' => function ($data) {
              $te = "";
              if($data->Type == 0){ $te = "Menu Con subs Menu"; }else{$te = "Menu Simple"; }

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
        ], */
        
        /* [
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
 */
        [
            'class' => 'yii\grid\ActionColumn',
            'header' => 'Acciones',
            'template' => '<div class="btn-group" > {update} {send} {delete} </div>',
            'buttons' => [
                'delete' => function($url, $model){
                    return Html::a('<span class="fa fa-trash"></span>', ['deletepromo', 'id' => $model->PromotionsID], [
                        'class' => 'btn btn-danger click-confirm',
                        'tittle-alert' => 'Eliminar información',
                        'text-alert'  => '¿Estás seguro?. Cuando elimines esta promoción,no podrás recuperarlo más tarde.',
                    ]);
                },
                'update' => function($url, $model){
                    return Html::button('<span class="fa fa-edit"></span>', ['idpromo' => $model->PromotionsID, 'class' => 'btn btn-primary update']
                     );
                },
                'send' => function($url, $model){
                    if($model->isShipped == 1){
                        if($model->StatusShipped == 0){
                            return Html::a('<span class="fa fa-envelope"></span>', ['run-newsletter', 'id' => $model->PromotionsID], [
                                'class' => 'btn btn-success click-confirm',
                                'tittle-alert' => 'Enviar Newsletter',
                                'text-alert'  => '¿Estás seguro?. se enviara email a toda la base de datos de clientes.',
                            ]);
                        }else if($model->StatusShipped == 1){
                            return Html::a('<span class="fa fa-envelope-open"></span>', ['run-newsletter', 'id' => $model->PromotionsID], [
                                'class' => 'btn btn-warning click-confirm',
                                'tittle-alert' => 'Reenviar Newsletter',
                                'text-alert'  => '¿Estás seguro?. se enviara el newsletter NUEVAMENTE a toda la base de datos de clientes.',
                            ]);

                        }else{
                            return Html::button('<span class="fa fa-refresh"></span>', ['class' => 'btn btn-info']);
                        }
                    }else{
                        return '';
                    }
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
 ?>
</div>
</div>

<!-- Modal -->
<div class="modal fade" id="create-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <?php $form = ActiveForm::begin(['action' =>['promoaction'], 'method' => 'post',  'options' => ['enctype' => 'multipart/form-data']]); ?>
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Formulario promoción</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <?= $form->field($model, 'Text')->textarea(['maxlength' => true, 'id' => 'editor', 'style' => 'min-height: 140px;'])->label('Descripción'); ?>
                    </div>
                    <div class="col-12">
                            <?= $form->field($model, 'Visible')->dropDownList([
                                '0' => 'Oculto',
                                '1' => 'Visible'
                                ]) ?>
                    </div>                
                </div>
                <div class="row">
                    <div class="col-md-8">
                       ¿Configurar Newsletter?
                    </div>
                    <div class="col-md-4">
                            <?= $form->field($model, 'isShipped')->dropDownList([
                            '0' => 'No',
                            '1' => 'Si'
                        ],['id' => 'upConfigNewsletterCreate'])->label(false) ?>
                    </div>
                </div>  
                <div class="row newsletter-form-create" style="display:none;">
                    <div class="col-md-8">
                        <?= $form->field($model, 'SubjectNewsLetter')->textInput(['maxlength' => true]); ?>
                    </div>

                    <div class="col-md-12">
                        <?= $form->field($model, 'DescriptionNewsletter')->textarea(['maxlength' => true,'style' => 'min-height: 140px;','id' =>'editorNewsletter']); ?>
                    </div>
                    <div class="col-md-12">
                        <div class="w-100 d-flex justify-content-center align-items-center">
                            <img src="" onerror="this.src = 'https://w7.pngwing.com/pngs/819/548/png-transparent-photo-image-landscape-icon-images-thumbnail.png';" style="height:100px; width:auto;" id="prevImageCreate">
                        </div>
                        <?= $form->field($model, 'FileNewsletter')->fileInput(['id' => 'fileImgCreate']); ?>
                    </div>
                </div> 
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        <?php $form = ActiveForm::end(); ?>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="update-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <?php $form = ActiveForm::begin(['action' =>['promoaction'], 'method' => 'post',  'options' => ['enctype' => 'multipart/form-data']]); ?>
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Formulario promoción</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <?= $form->field($model, 'Text')->textarea(['maxlength' => true, 'style' => 'min-height: 140px;', 'id' => 'editoru'])->label('Descripción'); ?>
                    </div>
                    <div class="col-12">
                        <?= $form->field($model, 'Visible')->dropDownList([
                            '0' => 'Oculto',
                            '1' => 'Visible'
                        ],['id' => 'UpdateVisible']) ?>
                    </div>    
                </div>       
                <div class="row">
                    <div class="col-md-8">
                       ¿Configurar Newsletter?
                    </div>
                    <div class="col-md-4">
                            <?= $form->field($model, 'isShipped')->dropDownList([
                            '0' => 'No',
                            '1' => 'Si'
                        ],['id' => 'upConfigNewsletter'])->label(false) ?>
                    </div>
                </div>  
                <div class="row newsletter-form-edit" style="display:none;">
                    <div class="col-md-8">
                        <?= $form->field($model, 'SubjectNewsLetter')->textInput(['maxlength' => true, 'id' => 'subjectEdit']); ?>
                    </div>

                    <div class="col-md-12">
                        <?= $form->field($model, 'DescriptionNewsletter')->textarea(['maxlength' => true, 'rows' => '10', 'id' => 'descriptionEdit']); ?>
                    </div>
                    <div class="col-md-12">
                        <div class="w-100 d-flex justify-content-center align-items-center">
                            <img src="" style="height:100px; width:auto;" id="prevImageEdit">
                        </div>
                        <?= $form->field($model, 'FileNewsletter')->fileInput(['id' => 'fileImgEdit']); ?>
                    </div>
                </div>   
            </div>
            <div class="modal-footer">
                <?= $form->field($model, 'PromotionsID')->hiddenInput(['id' => 'UpdatePromotionsID'])->label(false) ?>
                <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        <?php $form = ActiveForm::end(); ?>
    </div>
  </div>
</div>

<?php 

    if(Yii::$app->session->hasFlash('success')):
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

    $this->registerJsFile(
        '@web/js/ckeditor5/build/ckeditor.js',
        ['depends' => [\yii\web\JqueryAsset::class]]
    );

    $JS = "
        function readURL(input,prev) {

		    if (input.files && input.files[0]) {
		        var reader = new FileReader();

		        reader.onload = function (e) {
		            $(prev).attr('src', e.target.result);
		        }

		        reader.readAsDataURL(input.files[0]);
		    }
		}


        $('#fileImgEdit').change(function(){

            readURL(this,'#prevImageEdit');

        });

        $('#fileImgCreate').change(function(){

            readURL(this,'#prevImageCreate');

        });

        $('#upConfigNewsletter').change(function(e){
           let value = $(this).val();
           if(value == 1){
                $('.newsletter-form-edit').show();
                $('.newsletter-form-edit').find('input, textarea').attr('disabled',false);
           }else{
                $('.newsletter-form-edit').find('input, textarea').attr('disabled',true);
                $('.newsletter-form-edit').hide();
           }
        });

        $('#upConfigNewsletterCreate').change(function(e){
           let value = $(this).val();
           if(value == 1){
                $('.newsletter-form-create').show();
                $('.newsletter-form-create').find('input, textarea').attr('disabled',false);
           }else{
                $('.newsletter-form-create').find('input, textarea').attr('disabled',true);
                $('.newsletter-form-create').hide();
           }
        });


        $(document).on('click','.update', function(e){
            var idpromo = $(this).attr('idpromo');
            $.post('".Url::to(['ajaxpromoval'])."',{ id: idpromo, _csrf: '" . Yii::$app->request->csrfToken . "'},function(dt){
                obj = JSON.parse(dt);
                //console.log(obj)
                $('#UpdatePromotionsID').val(obj.PromotionID);
                //$('#UpdateText').val(obj.Text);
                $('#UpdateVisible').val(obj.Visible);
                $('#fileImgEdit').val('');

                $('#subjectEdit').val(obj.SubjectNewsLetter);
                $('#prevImageEdit').attr('src',obj.ImageNewsLetter);
                $('#upConfigNewsletter').val(obj.isShipped);
                if(obj.isShipped == 1){
                    $('.newsletter-form-edit').show();
                    $('.newsletter-form-edit').find('input, textarea').attr('disabled',false);
                }else{
                    $('.newsletter-form-edit').find('input, textarea').attr('disabled',true);
                    $('.newsletter-form-edit').hide();
                }


                $('#update-modal').modal('show');


                ClassicEditor.create(document.querySelector('#editoru'), {
                        language: 'es'
                }).then(function(editor) {
                    textEditor = editor;
                    // ESTABLECER EL CONTENIDO DESPUÉS DE CREAR EL EDITOR
                    editor.setData(obj.Text);
                    //console.log('Editor inicializado con contenido');
                }).catch(function(error) {
                    //console.error('Error al inicializar CKEditor:', error);
                });

                ClassicEditor.create(document.querySelector('#descriptionEdit'), {
                        language: 'es'
                }).then(function(editorN) {
                    textEditorNe = editorN;
                    editorN.setData(obj.DescriptionNewsletter);
                }).catch(function(error) {
                });


                
            });
        });

        // Limpieza al cerrar el modal
        $('#update-modal').on('hidden.bs.modal', function() {
            if (textEditor) {
                textEditor.destroy().then(function() {
                    textEditor = null;
                    //console.log('Editor destruido al cerrar modal');
                });
            }

            if (textEditorNe) {
                textEditorNe.destroy().then(function() {
                    textEditorNe = null;
                    //console.log('Editor destruido al cerrar modal');
                });
            }
        });

        ClassicEditor.create(document.querySelector('#editor'), {
            language: 'es',
            }).then( editor => {
                editor.model.document.on( 'change:data', () => {
                let contentck = editor.getData();
            });
            }).catch( error => {
                console.error( error );
            });

         ClassicEditor.create(document.querySelector('#editorNewsletter'), {
            language: 'es',
            }).then( editor => {
                editor.model.document.on( 'change:data', () => {
                let contentckN = editor.getData();
            });
            }).catch( error => {
                console.error( error );
            });

    ";
    $this->registerJS($JS);
 ?>