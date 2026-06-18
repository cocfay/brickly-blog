<?php 
  use yii\helpers\Html;
//  use frontend\assets\AppAssetLayoutAll;
//  AppAssetLayoutAll::register($this);
  use common\components\datatables\DataTables;
  use yii\helpers\Url;
  use yii\bootstrap5\Button;
  use yii\bootstrap5\ActiveForm;
  $this->title = 'Posición';
?>

<style>
    #sortable { list-style-type: none; margin: 0; padding: 0; width: 60%; }
    #sortable li { margin: 0 5px 5px 5px; padding: 10px; font-size: 1.2em;  }
    html>body #sortable li { line-height: 1.2em; }
    .ui-state-highlight { height: 1.5em; line-height: 1.2em; }
    .ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default, .ui-button, html .ui-button.ui-state-disabled:hover, html .ui-button.ui-state-disabled:active {
        border: 1px solid #c5c5c5;
        background: #f6f6f6;
        font-weight: normal;
        color: #454545;
    }
    .ui-sortable-handle {
        -ms-touch-action: none;
        touch-action: none;
    }
</style>

<div class="container-fluid">

    <div class="row align-items-center">
        <div class="col-6"><h1 style="color: var(--color-principal);">Posición de los proyectos</h1></div>
        <div class="col-6" align="right"><a class="btn btn-warning" href="<?= Url::to(['porfolio/']) ?>">Atrás</a></div>
    </div>
    
    <hr>

    <div class="row-fluid">
        <div class="row mt-2 mb-2">
            <div class="col-12 fw-bold fs-4">Lista de proyectos</div>
        </div>
        <ul id="sortable">
            <?php foreach($position as $rows): ?>
                <li class="ui-state-default" data-value="<?= $rows->PorfolioID ?>"><?= $rows->Title ?></li>
            <?php endforeach ?>
        </ul>
    </div>
    <div class="row mt-3">
        <div class="col-12"><button type="button" class="btn btn-primary" name="save">Aplicar cambios</button></div>
    </div>
</div>
<?php
    $this->registerJS('
        $( function(){
            $( "#sortable" ).sortable({
            placeholder: "ui-state-highlight"
            });
            $( "#sortable" ).disableSelection();

            document.querySelector("[name=save]").addEventListener("click", () => {

                var data = []
                const collinfo = document.querySelectorAll(".ui-state-default")
                collinfo.forEach((items, index) =>{
                    data.push({position: (parseInt(index) + 1), id: items.dataset.value})
                })

                //console.log(data)

                $.post("' . Url::to(['ajaxneworden']) . '", { data }, function(resp) {
                    var respuesta = JSON.parse(resp);

                    if(respuesta.response)
                        location.reload()
                    else
                        console.error(respuesta.response)

                }, false)

            })

        });
    ');
?>