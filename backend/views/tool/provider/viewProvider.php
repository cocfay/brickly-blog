<?php
    use yii\helpers\Html;
    use yii\helpers\Url;
    use yii\bootstrap5\ActiveForm;
    use common\components\datatables\DataTables;
    $this->title = 'Nuevo proveedor';
?>

<div style="color: var(-bs-dark)">
    <h3><?= $this->title ?></h3>
    <div class="d-flex gap-3 align-items-center mt-3 mb-5">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addws"><i class="fa-solid fa-plus me-2"></i> Agregar</button>
    </div>
</div>


<?php if(!empty($Mfijo) || !empty($Mvariable)): ?>

    <div>
        <?php if(!empty($Mfijo)): ?>
            <div class="fw-bold mb-2 fs-4">Monto fijo</div>

            <div class="d-flex gap-3 align-items-center">
                <a href="<?= Url::to(['pay-serv-provider', 'id' => $Mfijo->ProviderID]) ?>" style="color: #495057;">
                    <div class="d-flex gap-3 align-items-center py-3 px-5 fs-4" style="background: #d5d5d5; border-radius: 10px; border: 1px solid gray;">
                        <i class="fa-solid fa-dollar-sign"></i>
                        <div><?= $Mfijo->Name ?></div>
                    </div>
                </a>
            </div>
        <?php endif ?>

        <?php if(!empty($Mvariable)): ?>
            <hr class="mt-4 mb-3">
            <div class="fw-bold mb-2 fs-4">Monto variable</div>

            <div class="d-flex gap-3 align-items-center">
                <?php foreach($Mvariable as $mv): ?>
                    <a href="<?= Url::to(['pay-serv-provider', 'id' => $mv->ProviderID]) ?>" style="color: #495057;">
                        <div class="d-flex gap-3 align-items-center py-3 px-5 fs-4" style="background: #d5d5d5; border-radius: 10px; border: 1px solid gray;">
                            <i class="fa-solid fa-money-check-dollar"></i>
                            <div><?= $mv->Name ?></div>
                        </div>
                    </a>
                <?php endforeach ?>
            </div>
        <?php endif ?>
    </div>

<?php endif ?>

<!-- Add Modal -->
<div class="modal fade" id="addws" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
    <?php $form = ActiveForm::begin() ?>
    <div class="modal-content p-4">
        <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Formulario</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body row">
            <div class="col-md-6">
                <?= $form->field($model, 'Name')->textInput() ?>
            </div>
        </div>
        <div class="modal-footer">
        <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
        <button type="submit" class="btn btn-primary">Agregar</button>
        </div>
    </div>
    <?php ActiveForm::end() ?>
    </div>
</div>


<?php

    if (Yii::$app->session->hasFlash('success')):
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

?>