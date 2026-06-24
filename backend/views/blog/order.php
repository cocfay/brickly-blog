<?php
    use yii\helpers\Url;
    $this->title = "Ordenar posts para el home";
?>

<style>
    #PresenterList,
#ContactList,
#FacilitatorList {
  height: 95px;
  margin-bottom: 10px;
}

.style-select select {
  padding: 0;
}

.btn-default {
    color: #333;
    background-color: #fff;
    border-color: #ccc;
}

.style-select select option {
  padding: 4px 10px 4px 10px;
}

.style-select select option:hover {
  background: #EEEEEE;
}

.add-btns {
  padding: 0;
}

.add-btns input {
  margin-top: 25px;
  width: 100%;
}

.selected-left {
  float: left;
  width: 88%;
}

.selected-right {
  float: left;
}

.selected-right button {
  display: block;
  margin-left: 4px;
  margin-bottom: 2px;
}

@media (max-width: 517px) {
  .selected-right button {
    display: inline;
    margin-bottom: 5px;
  }
}

.subject-info-box-1,
.subject-info-box-2 {
  float: left;
  width: 45%;
}

.subject-info-box-1 select,
.subject-info-box-2 select {
  height: 200px;
  padding: 0;
}

.subject-info-box-1 select option,
.subject-info-box-2 select option {
  padding: 4px 10px 4px 10px;
}

.subject-info-box-1 select option:hover,
.subject-info-box-2 select option:hover {
  background: #EEEEEE;
}

.subject-info-arrows {
  float: left;
  width: 10%;
}

.subject-info-arrows input {
  width: 70%;
  margin-bottom: 5px;
}

</style>

<div class="row style-select">
    <div class="col-md-12">
        <div class="subject-info-box-1">
            <label class="fw-bold mb-2 d-block">Listado de posts</label>
            <select multiple class="form-control" id="lstBox1">
                <?php foreach($modelL as $data): ?>
                    <option value="<?= $data->PostBlogID ?>" style="border-top: 1px solid gray; border-bottom: 1px solid gray;"><?= $data->title ?></option>
                <?php endforeach ?>
            </select>
        </div>

        <div class="subject-info-arrows text-center">
            <br /><br />
            <input type='button' id='btnRight' value='>' class="btn btn-default" /><br />
            <input type='button' id='btnLeft' value='<' class="btn btn-default" /><br />
        </div>

        <div class="subject-info-box-2">
            <label class="fw-bold mb-2 d-block">Visibles en el home</label>
            <select multiple class="form-control" id="lstBox2">
                <?php if(!is_null($modelR)): ?>
                    <?php foreach($modelR as $data): ?>
                        <option value="<?= $data->PostBlogID ?>" style="border-top: 1px solid gray; border-bottom: 1px solid gray;"><?= $data->title ?></option>
                    <?php endforeach ?>
                <?php endif ?>
            </select>
        </div>

        <div class="clearfix"></div>
        <div class="mt-4 col-12">
            <div class="btn btn-primary save">Guardar</div>
        </div>
    </div>
</div>

<?php
    $this->registerJs("
        $('#btnRight').click(function (e) {
            // Mover elementos a la derecha
            $('select').moveToListAndDelete('#lstBox1', '#lstBox2');
            
            // Deshabilitar btnRight si hay 4 o más elementos
            if ($('#lstBox2 option').length >= 4) {
                $('#btnRight').prop('disabled', true); // Usar prop() de jQuery
            }
            e.preventDefault();
        });

        $('#btnLeft').click(function (e) {
            // Mover elementos a la izquierda
            $('select').moveToListAndDelete('#lstBox2', '#lstBox1');
            
            // Siempre habilitar btnRight al mover elementos de vuelta
            $('#btnRight').prop('disabled', false); // Forzar habilitación
            e.preventDefault();
        });

        $('.save').click(function () {
           const selectedValues = $('#lstBox2 option').map(function() { return $(this).val() } ).get()
            $.post('".Url::to(['ajaxhome'])."', { ids: selectedValues }, function(response) {
                location.reload()
            });
        })

        if ($('#lstBox2 option').length >= 4) {
            $('#btnRight').prop('disabled', true);
        }
    ");
?>