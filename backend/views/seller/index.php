<?php
    use yii\bootstrap5\ActiveForm;
    use yii\helpers\Html;
    use yii\helpers\Url;
    use common\components\chosen\Chosen;

    $this->title = "Formulario vendedor";
    
    $expList = ['B2B' => 'B2B', 'B2C' => 'B2C', 'Ventas consultivas' => 'Ventas consultivas' ,'Ventas sociales' => 'Ventas sociales', 'Ventas inbound' => 'Ventas inbound', 'Ventas outbound' => 'Ventas outbound', 'Ventas en frío' => 'Ventas en frío', 'Ventas por suscripción' => 'Ventas por suscripción'];

    $sourceList = ['Fuentes digitales' => 'Fuentes digitales', 'Fuentes humanas (Networking)' => 'Fuentes humanas (Networking)', 'Fuentes tradicionales' => 'Fuentes tradicionales', 'Fuentes automatizadas' => 'Fuentes automatizadas', 'Fuentes creativas' => 'Fuentes creativas'];

    $langList = ['Español' => 'Español', 'Ingles' => 'Ingles', 'Frances' => 'Frances', 'Italiano' => 'Italiano', 'Portugues' => 'Portugues', 'Aleman' => 'Aleman'];
?>
<?php $form = ActiveForm::begin(); ?>
    <div class="row mx-0">
        <div class="col-12 mb-4">
            <div class="fw-bold fs-3">Ingresa tus datos personales</div>
        </div>
        <div class="col-md-6 col-lg-5">
            <?= $form->field($model, 'Name')->textInput(['maxlength' => true]); ?>
        </div>
        <div class="col-md-6 col-lg-3">
            <?= $form->field($model, 'Country')->dropDownList($contryList, ['options' => [$countryCode => ['Selected' => true]]]) ?>
        </div>
        <div class="col-md-6 col-lg-4">
            <?= $form->field($model, 'NumberDocument')->textInput(['maxlength' => true]); ?>
        </div>
        <div class="col-md-6 col-lg-3">
            <?= $form->field($model, 'Date')->input('date', ['maxlength' => true]); ?>
        </div>
        <div class="col-md-6 col-lg-3">
            <?= $form->field($model, 'Address')->textInput(['maxlength' => true]); ?>
        </div>
        <div class="col-md-6 col-lg-3">
            <?= $form->field($model, 'City')->textInput(['maxlength' => true]); ?>
        </div>
        <div class="col-md-6 col-lg-3">
            <?= $form->field($model, 'Email')->input('email', ['maxlength' => true]); ?>
        </div>
        <div class="col-md-6 col-lg-3">
            <?= $form->field($model, 'Phone')->input('number', ['maxlength' => true]); ?>
        </div>
        <div class="col-md-6 col-lg-3">
            <?= $form->field($model, 'Profession')->textInput(['maxlength' => true]); ?>
        </div>
        <div class="col-md-6 col-lg-3">
            <?= $form->field($model, 'CivilState')->dropDownList(['Soltero' => 'Soltero', 'Casado' => 'Casado', 'Viudo' => 'Viudo']); ?>
        </div>
        <div class="col-12 my-4">
            <div class="fw-bold fs-3">Experiencia laboral</div>
        </div>
        <div class="col-md-6 col-lg-3">
            <?= $form->field($model, 'ExplField1')->textInput(['maxlength' => true]); ?>
        </div>
        <div class="col-md-6 col-lg-3">
            <?= $form->field($model, 'ExplField2')->textInput(['maxlength' => true]); ?>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="form-label">Tiempo laborado *</div>
            <div class="d-flex gap-2 align-items-baseline">
                <div style="flex: 1; min-width: 0;"><?= $form->field($model, 'ExplField3')->input('date', ['maxlength' => true])->label(false); ?></div>
                <div>al</div>
                <div style="flex: 1; min-width: 0;"><?= $form->field($model, 'ExplField4')->input('date', ['maxlength' => true])->label(false); ?></div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <?= $form->field($model, 'ExplField5')->input('number', ['maxlength' => true]); ?>
        </div>
        <div class="col-md-6 col-lg-3">
            <?= $form->field($model, 'ExplField6')->textInput(['maxlength' => true]); ?>
        </div>
        <div class="col-md-6 col-lg-3">
            <?= $form->field($model, 'ExplField7')->textInput(['maxlength' => true]); ?>
        </div>
        <div class="col-md-6 col-lg-3">
            <?= $form->field($model, 'ExplField8')->dropDownList(['No' => 'No', 'Si' => 'Si']); ?>
        </div>
        <div class="col-12 my-4">
            <div class="fw-bold fs-3">Habilidades comerciales</div>
        </div>
        <div class="col-md-6 col-lg-3">
            <?=
                $form->field($model, 'Expe')->widget(Chosen::classname(), [                            
                    'items' => $expList,
                    'allowDeselect' => true,
                    'disableSearch' => true, // Search input will be disabled
                    'clientOptions' => [
                        'search_contains' => true,
                        'max_selected_options' => 4,
                    ],
                        'options'  => [
                            'id' => 'fieldMulti',
                    ],
                    'placeholder' => 'Seleccione',
                    'multiple' => true,
                ])->label('Experiencia en tipos de ventas *', ['class' => 'form-label']);             
            ?>
        </div>
        <div class="col-md-6 col-lg-3">
            <?=
                $form->field($model, 'Source')->widget(Chosen::classname(), [                            
                    'items' => $sourceList,
                    'allowDeselect' => true,
                    'disableSearch' => true, // Search input will be disabled
                    'clientOptions' => [
                        'search_contains' => true,
                        'max_selected_options' => 4,
                    ],
                        'options'  => [
                            'id' => 'fieldMulti2',
                    ],
                    'placeholder' => 'Seleccione',
                    'multiple' => true,
                ])->label('Fuentes usuales de prospección *', ['class' => 'form-label']);             
            ?>
        </div>
        <div class="col-md-6 col-lg-3">
            <?=
                $form->field($model, 'Language')->widget(Chosen::classname(), [                            
                    'items' => $langList,
                    'allowDeselect' => true,
                    'disableSearch' => true, // Search input will be disabled
                    'clientOptions' => [
                        'search_contains' => true,
                        'max_selected_options' => 4,
                    ],
                        'options'  => [
                            'id' => 'fieldMulti3',
                    ],
                    'placeholder' => 'Seleccione',
                    'multiple' => true,
                ])->label('Idioma que dominas *', ['class' => 'form-label']);             
            ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'HCField1')->textarea(['maxlength' => true, 'style' => 'min-height: 140px']) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'HCField2')->textarea(['maxlength' => true, 'style' => 'min-height: 140px']) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'HCField3')->textarea(['maxlength' => true, 'style' => 'min-height: 140px']) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'HCField4')->textarea(['maxlength' => true, 'style' => 'min-height: 140px']) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'HCField5')->textarea(['maxlength' => true, 'style' => 'min-height: 140px']) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'HCField6')->textarea(['maxlength' => true, 'style' => 'min-height: 140px']) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'HCField7')->input('number', ['maxlength' => true, 'placeholder' => 'USD']) ?>
        </div>
        <div class="col-12 mt-5 d-flex justify-content-end">
            <input type="hidden" id="recaptcha-token" name="recaptcha-token">
            <button type="submit" class="btn text-white px-5 text-uppercase fw-bold" style="font-size: 14px; background: #FF0461; border-radius: 4px;" data-section="contact" data-value="text9">Enviar</button>
        </div>
    </div>
<?php ActiveForm::end(); ?>
   
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