<?php
    use yii\widgets\ActiveForm;
    use yii\helpers\Html;
    use yii\helpers\Url;
    use common\models\PorfolioAnexos;

    $this->title = "Editar";
?>

<div class="container">
    <div class="row">
        <div class="row justify-content-between">
            <div class="col-lg-6">
                <div class="col-12 fs-2 text-uppercase mb-2" style="line-height: 1;">Formulario portafolio</div>
            </div>
            <div class="col-lg-6">
                <a href="<?= Url::to(['index']) ?>" class="btn btn-warning">Atrás</a>
            </div>
        </div>
        <?php $form = ActiveForm::begin(); ?>
            <div class="col-lg-6 mb-2">
                <?= $form->field($model, 'Type', ['labelOptions' =>['class' => 'fw-bold']])->dropDownList([
                    '1' => 'Talleres',
                    '2' => 'Restaurantes',
                    '3' => 'Logística',
                    '4' => 'Médicos'],
                ['prompt' => 'Seleccionar']) ?>
            </div>
            <div class="col-12 mt-3">
                <div class="contenedorBoton">
                    <?= Html::submitButton('Enviar', ['class' => 'btn btn-primary']); ?>
                </div>
            </div>
        <?php ActiveForm::end(); ?>
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