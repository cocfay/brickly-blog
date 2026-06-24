<?php 
    use yii\helpers\Html;
    use yii\helpers\Url;
    use yii\bootstrap5\ActiveForm;
    use frontend\assets\AppAssetAwesome;
    AppAssetAwesome::register($this);

    $this->title = 'Home';
 ?>
 <style type="text/css">
     .previmgconfirm{
        max-height: 80px;
        width: auto;
        max-width: 100%;
     }
 </style>
<div>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div id="menu-Colecciones">
                    <p class="tituloMenuColecciones" data-section="sidevar-collection" data-value="title">
                        COLECCIONES MOTU
                    </p>
                    <ul>
                        <?php foreach($Collections as $c): ?>
                        <li>
                            <a href="<?= Url::to(['/home/checklist','id'=>$c->CollectionID])?>">
                                <p class="textoColecciones" style="<?= ($id == $c->CollectionID)? 'color: #006f9b;':''; ?>"><?= $c->Name; ?></p>
                            </a> 
                        </li>
                        <?php endforeach; ?>
                       
                    </ul>
                </div>
                <div class="mt-5">
                    <?php if($modelCollection): ?>
                        <p class="tituloMenuForo">
                            Escenario
                        </p>
                    <?php endif; ?>
                    <div class="MenuForoContenido">
                        <div class="row">
                        <?php if($UserAccount && $modelCollection): ?>
                            <?php if($modelStad): ?>
                                <div class="col-md-10 d-flex justify-content-center align-items-center" style="flex-direction: column;">
                                    <img src="<?= Url::to(['/']).'images/ChecklistUser/'.$UserAccount->AccountID.'/stands/'.$modelStad->StandIMG; ?>" style="height: 90px; width: auto;" />
                                    <hr class="w-100">
                                    <small><p><i>nota: Si la imagen del escenario es cambiada debera cargar nuevamente el checklist en el nuevo escenario y esperar la aprobación para sumar nuevamete sus puntos.</i></p></small>
                                </div>
                                <input type="hidden" name="Stand" id='stand-scenary' value="<?= $modelStad->StandID; ?>" />
                            <?php endif; ?>
                            <div class="col-md-10">
                                <label>Nombre del escenario</label>
                                <input type="text" name="Name" id="name-scenary" value="<?= isset($modelStad->Name)? $modelStad->Name:''; ?>" class="form-control"/>
                                
                            </div>
                            <div class="col-md-10">
                                <label>Imagen</label>
                                <input type="file" name="ImageFile" id="image-scenary" class="form-control"/>
                            </div>
                            <div class="col-md-10">
                               <button class="btn btn-warning w-100 mt-2" id="btn-save-scenary"><?= ($modelStad)? 'Guardar cambios' : 'Cargar escenario'; ?></button>
                            </div>
                        <?php elseif(!$UserAccount && $modelCollection): ?>
                            <div class="col-md-10">
                                <button class="btn btn-warning w-100 mt-2" onclick="alert('Inicia session para cargar tu scenario');">Cargar escenario</button>
                            </div>
                        <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <?php if($modelCollection): ?>
                <div id="seccion-1">
                    <p>Figuras</p>
                    <div class="container">
                        
                        <?php foreach ($modelCollection->objectCollections as $ob): ?>
                            <div class="row">
                                <div class="col-md-4 d-flex justify-content-center align-items-center">
                                    <img src="<?= Url::to(['/images/Fotos'])."/".$ob->ImageUrl ?>" style=" max-height: 250px; width: auto;">
                                </div>
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <?= $ob->Name; ?>
                                        </div>
                                        <div class="col-md-12">
                                            <?= $ob->ShortText; ?>
                                        </div>
                                        <div class="col-md-12">
                                            <?= $ob->TypeObject; ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h3>Condición:</h3>
                                            <ul>
                                                <?php foreach($ob->conditions as $co): ?>
                                                    <li style="padding: 5px;">
                                                        <?= $co->Description; ?> 
                                                        <span>
                                                         <input type="file" id="filepicture-<?= $co->ConditionOfObjectCollectionID ?>" style="display:none" data-inf="<?= $co->ConditionOfObjectCollectionID ?>" class="file-picture-upload"/>
                                                             <button class="btnfolder" title="Cargar figura a mi checklist" id="btnfolder-<?= $co->ConditionOfObjectCollectionID ?>" for="#filepicture-<?= $co->ConditionOfObjectCollectionID ?>">
                                                                <i class="fa fa-folder-open"></i>
                                                            </button>
                                                            <!-- CoMprobar si tiene cargado y mostrar -->
                                                            <?php if(in_array($co->ConditionOfObjectCollectionID, array_keys($MyChecklistArr))): ?>
                                                            <span> 
                                                                <button class="btn-info btn-small" title="Mis figuras cargadas" style="background: #0dcaf0;" data-toggle="modal" onclick="$('#showmychecklist-<?= $co->ConditionOfObjectCollectionID; ?>').modal('show');">
                                                                    <i class="fa fa-eye"></i>
                                                                </button>
                                                            </span>
                                                            <?php endif; ?>
                                                            <!--  -->
                                                             <span class="name-picture-folder-<?= $co->ConditionOfObjectCollectionID ?>"></span>
                                                        </span>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                            <h3>Variantes:</h3>
                                            <ul>
                                                <?php foreach($ob->variants as $vo): ?>
                                                     <li style="padding: 5px;">
                                                        <?= $vo->Description; ?>
                                                        <span>
                                                         <input type="file" id="filepicture-<?= $vo->ConditionOfObjectCollectionID ?>" style="display:none" data-inf="<?= $vo->ConditionOfObjectCollectionID ?>" class="file-picture-upload"/>
                                                            <button class="btnfolder" title="Cargar figura a mi checklist" id="btnfolder-<?= $vo->ConditionOfObjectCollectionID ?>" for="#filepicture-<?= $vo->ConditionOfObjectCollectionID ?>">
                                                                <i class="fa fa-folder-open"></i>
                                                            </button>
                                                            <!-- CoMprobar si tiene cargado y mostrar -->
                                                            <?php if(in_array($vo->ConditionOfObjectCollectionID, array_keys($MyChecklistArr))): ?>
                                                            <span> 
                                                                <button class="btn-info btn-small" title="Mis figuras cargadas" style="background: #0dcaf0;" data-toggle="modal" onclick="$('#showmychecklist-<?= $vo->ConditionOfObjectCollectionID; ?>').modal('show');">
                                                                    <i class="fa fa-eye"></i>
                                                                </button>
                                                            </span>
                                                            <?php endif; ?>
                                                            <!--  -->
                                                            <span class="name-picture-folder-<?= $vo->ConditionOfObjectCollectionID ?>"></span>
                                                        </span>
                                                         
                                                     </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    </div>
                                    

                                </div>
                            </div>

                        <?php endforeach; ?>
                     </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ConfirmCheckToSave" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Confirma tu checklist</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="cotainer" id='containerSendConfirm'>
            
        </div>
      </div>
      <div class="modal-footer">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data','id' => 'SaveChecklist']]); ?>
            <div id="formSendBtn"></div>
        <?php ActiveForm::end(); ?>
      </div>
    </div>
  </div>
</div>



<?php foreach($MyChecklistArr as $key => $value): ?>

    <div class="modal fade" id="showmychecklist-<?= $key; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Estado de tus items cargados:</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="cotainer">
                <?php if(isset($value[0])): ?>
                    <div class="row">
                        <div class="col-md-4 d-flex justify-content-center align-items-center">
                            <img src="<?= Url::to(['/images/Fotos'])."/".$value[0]->condition->objectCollection->ImageUrl ?>" style=" max-height: 80px; width: auto;">
                        </div>
                        <div class="col-md-8">
                            <p><?= $value[0]->condition->objectCollection->Name; ?></p>
                            <p><?= $value[0]->condition->objectCollection->ShortText; ?></p>
                            <p><?= $value[0]->condition->objectCollection->TypeObject; ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h4><?= $value[0]->condition->Description; ?></h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <hr style="width: 100%;">
                        </div>
                    </div>
                <?php endif; ?>
                <?php foreach($value as $k => $item): ?>
                    <div class="row">
                        <div class="col-md-3">
                            <img src="<?= Url::to(['/']).'images/ChecklistUser/'.$UserAccount->AccountID.'/'.$item->UrlIMG; ?>" class="previmgconfirm">
                        </div>
                        <div class="col-md-3">
                            <?= ($item->Status == 0)? '<p style="color:orange;">PENDIENTE</p>':''; ?>
                            <?= ($item->Status == 1)? '<p style="color:green;">APROBADO</p>':''; ?>
                            <?= ($item->Status == 2)? '<p style="color:red;">RECHAZADO</p>':''; ?>
                        </div>
                        <div class="col-md-3">
                            Puntos: <?= $item->Points; ?>
                        </div>
                        <div class="col-md-3">
                           <button style="background: red;" class="deleteitemChecklist" title="Eliminar item" data-cod="<?= $item->UserByObjectCollectionConditionID; ?>"><i class="fa fa-trash"></i></button>
                        </div>
                        <hr style="width: 100%;">
                    </div>
                    
                <?php endforeach; ?>
            </div>
          </div>
          <div class="modal-footer">
          </div>
        </div>
      </div>
    </div>

<?php endforeach; ?>
<script type="text/javascript">
    function showmodalCofirmCL(){
        $('#ConfirmCheckToSave').modal('show');
    }
</script>
<?php 
$urltempImg = Url::to(["/images/temp/checklist/"]);
if($modelStad){
    $namestand = $modelStad->Name;
    $this->registerJS("
        var ChecklistToSend = {};
        var urlTempChecklist = '".Url::to(['/'])."images/ChecklistUser/temp/".$UserAccount->AccountID."/';
        $(document).on('click','.btnfolder', function(e){
            let elmClick = $(this).attr('for');
            $(elmClick).click();
            $(this).find('i').removeClass('fa-folder-open').addClass('fa-spinner').addClass('fa-spin');
        })
        
        $(document).on('change','.file-picture-upload', function(e){
            let inf = $(this).attr('data-inf');
            formdata = new FormData();

            if($(this).prop('files').length > 0)
            {
                file = $(this).prop('files')[0];
                formdata.append('ChecklistFilesForm[ImageFile]', file);
                formdata.append('ChecklistFilesForm[ConditionID]', inf);

                $.ajax({
                        url: '".Url::to(['/home/picturechecklist'])."',
                        type: 'POST',
                        data: formdata,
                        processData: false,
                        contentType: false,
                        success: function (result) {
                             if(!result.error){
                                $('.name-picture-folder-'+inf).html(' Cargado temporalmente <a href=\"'+ urlTempChecklist + result.url + '\" target=\"_blank\" >click para ver</a>');
                                ChecklistToSend[result.inf] = result;
                                CheckButtonSedBiew();

                             }else{
                                alert(result.message);
                             }
                              $('#btnfolder-'+inf).find('i').removeClass('fa-spinner').removeClass('fa-spin').addClass('fa-folder-open');
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) { 
                             $('#btnfolder-'+inf).find('i').removeClass('fa-spinner').removeClass('fa-spin').addClass('fa-folder-open');
                             delete  ChecklistToSend[inf];
                             CheckButtonSedBiew();
                        }
                    });

                
            }else{
                delete  ChecklistToSend[inf];
                CheckButtonSedBiew();
                $('.name-picture-folder-'+inf).html('');
                 $('#btnfolder-'+inf).find('i').removeClass('fa-spinner').removeClass('fa-spin').addClass('fa-folder-open');
            }

           
        })

        CheckButtonSedBiew = function(){
            if(Object.keys(ChecklistToSend).length > 0){
                if($('#sendMyChecklistButton').length == 0){
                    $('body').prepend('<div id=\"box-btn-save-checklist\" style=\"display:none; position:fixed; right:40px; bottom: 100px;\"><b>Guardar Checklist</b><button id=\"sendMyChecklistButton\" style=\"font-size:20px;margin:5px;\" class=\"btn btn-info\" ><i class=\"fa fa-save\"></i></button>')
                    $('#box-btn-save-checklist').fadeIn();
                }
            }else{
                $('#box-btn-save-checklist').remove();
            }
        }

        $(document).on('click','#sendMyChecklistButton',function(){
            let htmlConfirm = '';

            let inpts = '';

            Object.keys(ChecklistToSend).forEach((k,i) => {
                let Obj = ChecklistToSend[k];

            htmlConfirm += '<div class=\"row\">';
            htmlConfirm +=    '<div class=\"col-md-4\"><img src=\"'+urlTempChecklist+Obj.url+'\" class=\"previmgconfirm\"></div>';
            htmlConfirm +=    '<div class=\"col-md-8\">';
            htmlConfirm +=        '<p>'+Obj.objectcollection+'</p>';
            htmlConfirm +=        '<p>'+Obj.condition+'</p>';
            htmlConfirm +=    '</div>';
            htmlConfirm +=    '<hr style=\"width: 100%;\">';
            htmlConfirm += '</div>';
            inpts += '<input type=\"hidden\" value=\"'+Obj.inf+'\" name=\"CheckListForm['+i+'][Condition]\"></input>';
            inpts += '<input type=\"hidden\" value=\"'+Obj.url+'\" name=\"CheckListForm['+i+'][File]\"></input>';

            })



            $('#containerSendConfirm').html(htmlConfirm);
            $('#formSendBtn').html(inpts+'<button type=\"submit\" class=\"btn btn-primary\">Guardar</button>');

            showmodalCofirmCL();
        });


        $(document).on('click','.deleteitemChecklist',function(e){
            var Btn = $(this);
            if(confirm('¿Esta segur de eliminar este item?')){
                formdata = new FormData();
                formdata.append('ItemDelete', Btn.attr('data-cod'));
                $.ajax({
                        url: '".Url::to(['/home/deleteitemchecklist'])."',
                        type: 'POST',
                        data: formdata,
                        processData: false,
                        contentType: false,
                        success: function (result) {
                             if(result.error == false){
                                alert(result.message);
                                Btn.parent().parent().remove();
                             }else{
                                alert(result.message);
                             }
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) { 
                             alert('Ocurrio un error intente nuevamente.');
                        }
                    });

            }else{
                return true;
            }
        });
    ");
}else{
    $namestand = '';
    $this->registerJS("
        $(document).on('click','.btnfolder', function(e){
            alert('Debe cargar un escenario primer para llenar su checklist.');
        })
    ");
}

if($id){
$this->registerJS("
    $(document).on('click','#btn-save-scenary', function(e){
        formdata = new FormData();
        let upimagescenary = false;
        let upnamescenary = false;

        formdata.append('Stands[CollectionID]', ".$id.");

        if($('#image-scenary').length > 0){
            if($('#image-scenary').prop('files').length > 0){
                file = $('#image-scenary').prop('files')[0];
                formdata.append('Stands[ImageFile]', file);
                upimagescenary = true;
            }
        }

        if($('#stand-scenary').length > 0){
            formdata.append('Stands[StandID]', $('#stand-scenary').val());

        }

        if($('#name-scenary').val().length > 0){
            if($('#name-scenary').val() != '".$namestand."'){
                formdata.append('Stands[Name]', $('#name-scenary').val());
                upnamescenary = true;
            }
        }

        if(!upnamescenary && !upimagescenary){
            alert('No hay cambios para guardar');
        }else{

            $.ajax({
                        url: '".Url::to(['/home/upscenary'])."',
                        type: 'POST',
                        data: formdata,
                        processData: false,
                        contentType: false,
                        success: function (result) {
                             if(result.error == false){
                                alert(result.message);
                                location.reload();
                                
                             }else{
                                alert(result.message);
                             }
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) { 
                             alert('Ocurrio un error intente nuevamente.');
                        }
                    });




        }

    });
");
}
 ?>
