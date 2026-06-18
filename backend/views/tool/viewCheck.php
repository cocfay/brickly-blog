<?php
    use yii\helpers\Html;
    use yii\helpers\Url;
    use yii\bootstrap5\ActiveForm;
    use common\components\datatables\DataTables;
    $this->title = 'Chequeo de políticas de seguridad';
?>

<div style="color: var(-bs-dark)">
    <div class="d-flex mb-5 justify-content-between align-items-center">
        <h3 ><?= $this->title ?></h3>
        <a href="<?= Url::to(['prod-project']) ?>" title="Atrás"><i class="fa-regular fa-circle-left fs-1" style="color: #FF0461"></i></a>
    </div>

    <?php $form = ActiveForm::begin() ?>
        <div class="row">
            <?php 
            foreach($query as $i => $q): 
                if($q->PolicySecureID == ($q->projectSecure->PolicySecureID ?? null) && $q->projectSecure->ProjectWeclickID == $id)
                    $checked = true;
                else 
                    $checked = false; 
            ?>
                <div class="col-md-3 mb-4">
                    <div class="d-flex gap-2 p-3 h-100" style="background: #e5e5e5; border-radius: 10px;">
                        <div><?= $form->field($model, "PolicySecureID[]")->checkbox(['uncheck' => null, 'value' => $q->PolicySecureID, 'checked' => $checked])->label(false); ?></div>
                        <div class="w-100">
                            <div class="fw-bold"><?= $q->Nombre ?></div>
                            <hr class="mt-1 mb-2">
                            <div><?= $q->Descripcion ?></div>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
            <div class="col-12 mt-4">
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    <?php ActiveForm::end() ?>
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

