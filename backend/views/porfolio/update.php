<?php
    use yii\widgets\ActiveForm;
    use yii\helpers\Html;
    use yii\helpers\Url;
    use common\models\PorfolioAnexos;

    $this->title = "Editar Portafolio";
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
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
            <div class="col-lg-6 mb-2">
                <div class="mb-1 fw-bold">Imagen</div>
                <div class="imagepreview">
                    <img src="<?=Yii::getAlias('/images/')?><?= $model->Image ?>" alt="" srcset="">
                    <?= $form->field($model, 'Photo')->fileInput(['accept' => 'image/png, image/jpeg, image/jpg, image/webp'])->label(false) ?>
                </div>
                <div class="text-muted mt-2 form-text">Se recomienda que la imagen esté en una resolución de 1139x643</div>
            </div>
            <div class="col-lg-6 mb-2">
                <?=$form->field($model, 'Restriction', ['labelOptions' =>['class' => 'fw-bold']])->dropDownList(
                [
                    '1' => 'Si',
                    '0' => 'No',
                ],
                ['prompt' => 'Seleccionar'])->label('Restringir en España y Panamá') ?>
            </div>
            <div class="col-lg-6 mb-2">
                <?=$form->field($model, 'NGuatemala', ['labelOptions' =>['class' => 'fw-bold']])->dropDownList(
                [
                    '1' => 'Si',
                    '0' => 'No',
                ],
                ['prompt' => 'Seleccionar'])->label('Restringir en Guatemala') ?>
            </div>
            <div class="col-lg-6 mb-2">
                <?=$form->field($model, 'Type', ['labelOptions' =>['class' => 'fw-bold']])->dropDownList(
                [
                    '1' => 'Sitio',
                    '2' => 'Landing page',
                    '3' => 'Plataforma',
                    '4' => 'Aplicación movil',
                    '5' => 'e-Commerce',
                ],
                ['prompt' => 'Seleccionar']) ?>
            </div>
            <div class="col-lg-6 mb-2">
                <?= $form->field($model, 'Title', ['labelOptions' =>['class' => 'fw-bold']])->textInput(['maxlength' => true]); ?>
            </div>
            <div class="col-lg-6 mb-2">
                <?= $form->field($model, 'Client', ['labelOptions' =>['class' => 'fw-bold']])->textInput(['maxlength' => true]); ?>
            </div>
            <div class="col-lg-6 mb-2">
                <?= $form->field($model, 'Proyect', ['labelOptions' =>['class' => 'fw-bold']])->textInput(['maxlength' => true]); ?>
            </div>
            <div class="col-lg-6 mb-2">
                <?= $form->field($model, 'Link', ['labelOptions' =>['class' => 'fw-bold']])->textInput(['placeholder' => 'example.com', 'maxlength' => true]); ?>
                <div class="text-muted mt-1" style="font-size: 12px">(opcional)</div>
            </div> 
            <div class="col-lg-6 mb-2">
                <?= $form->field($model, 'Description', ['labelOptions' =>['class' => 'fw-bold']])->textarea(['maxlength' => true, 'style' => 'min-height: 130px;']); ?>
            </div>
            <div class="mb-1 fw-bold">Lista de imágenes - Anexos (opcional)</div>
            <div class="row col-lg-6 mb-2">
                <?php 
                    $porane = PorfolioAnexos::find()->where(['PorfolioID' => $model->PorfolioID])->all(); 
                    for($i = 0 ; $i <= 7 ; $i++):
                ?>
                        <div class="col-lg-6 mb-2">
                            <?php if($i < count($porane)): ?>
                                <div class="text-danger deleteitems" style="cursor:pointer" data-id="<?= $porane[$i]->AnexosID ?>" data-image="<?= $porane[$i]->Image ?>">Eliminar</div>
                            <?php endif ?>
                            <div class="imagepreview">
                                <?php if($i < count($porane)): ?>
                                    <img src="<?=Yii::getAlias('/images/')?><?= $porane[$i]->Image ?>" alt="" srcset="">
                                    <?= $form->field($porane[$i], "[$i]PhotoAnexos")->fileInput(['accept' => 'image/png, image/jpeg, image/jpg, image/webp'])->label(false) ?>
                                    <?= $form->field($porane[$i], "[$i]AnexosID")->hiddenInput(['value' => $porane[$i]->AnexosID])->label(false) ?>
                                <?php else: ?>
                                    <img src="<?=Url::to(['/images'])?>/uploadpreview.webp" alt="" srcset="">
                                    <?= $form->field(new PorfolioAnexos(), "[$i]PhotoAnexos")->fileInput(['accept' => 'image/png, image/jpeg, image/jpg, image/webp'])->label(false) ?>
                                <?php endif ?>
                            </div>
                        </div>
                <?php endfor ?>
            </div>
            <div class="col-lg-6 mb-2">
                <?= $form->field($model, 'VideoPF', ['labelOptions' => ['class' => 'fw-bold']])->fileInput(['aria-describedby' => 'VideoTY', 'class' => 'form-control', 'accept' => 'video/mp4, video/mpeg']) ?>
            </div>
            <div class="text-muted form-text">Solo se permiten videos en formato mp4 o mpeg y con tamaño menor o igual a 60mb</div>
            <?php if($model->Video != ""): ?>
                <div class="col-6 mt-3">
                    <div class="text-danger deleteitems videodlt" style="cursor:pointer" data-id="<?= $model->PorfolioID ?>" data-video= "<?= $model->Video ?>">Eliminar</div>
                </div>
                <div class="col-lg-6 videoPreview">
                    <video width="420" height="260" controls>
                        <source src="<?=Yii::getAlias('/')?><?= $model->Video ?>" type="video/mp4">
                    </video>
                </div>
            <?php endif ?>
            <div class="col-lg-6 mb-2">
                <?=$form->field($model, 'Visibility', ['labelOptions' =>['class' => 'fw-bold']])->dropDownList(
                [
                    '0' => 'Público',
                    '1' => 'Privado',
                ],
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

<script>
    const fileImG = document.querySelectorAll(".imagepreview input[type=file]")
    fileImG.forEach((items, index) => {
        items.addEventListener("change", (e) =>{
            if(e.target.files[0]){
                const PreviewImg = document.querySelectorAll(".imagepreview img")[index]
                PreviewImg.src = URL.createObjectURL(e.target.files[0])
            }
        })
    })

    const fileVideo = document.querySelector("#porfolio-videopf")
    if(fileVideo != null){
        fileVideo.addEventListener("change", (e) =>{
            if(e.target.files[0]){
                document.querySelector(".videodlt").classList.add('d-none')
                const OldVideo = document.querySelector("video")
                OldVideo.remove()
                const previewVideo = document.querySelector(".videoPreview")
                const video = 
                    `<video width="420" height="260" controls>
                        <source src="${URL.createObjectURL(e.target.files[0])}" type="video/mp4">
                    </video>`
                previewVideo.insertAdjacentHTML('afterbegin', video)
                
            }
        })
    }

</script>

<?php

    $this->registerJS("
        document.querySelectorAll('.deleteitems').forEach(items =>{
            items.addEventListener('click', (e) =>{
           
            const data = {'id': e.target.dataset.id, 'image': e.target.dataset.image, 'video': e.target.dataset.video}
            console.log(data)

            $.post('" . Url::to(['deleteitems']) . "', { data }, function(resp) {
                //console.log(resp)
                var respuesta = JSON.parse(resp);
                if(respuesta.status)
                    location.reload()
                else
                    console.error(respuesta.status)

            }, false)
        })
        
        })
    ");

?>