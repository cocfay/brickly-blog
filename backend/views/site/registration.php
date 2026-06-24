<?php
use frontend\assets\AppAsset;
AppAsset::register($this);
 
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap5\Button;
use yii\bootstrap5\ActiveForm;
use common\components\chosen\Chosen;
use common\components\datatables\DataTables;

$this->title = 'Registro';
/* $this->params['breadcrumbs'][] = $this->title; */
?>


<div class="container" style="min-height:100vh;margin-top:50px">
    <h2>Registro de Usuario</h2>
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-7">
            <!-- <label for="validationCustom01" class="form-label">Nombe</label>
            <input type="text" class="form-control" id="validationCustom01" value="Mark" required>
            <div class="valid-feedback">
            Looks good! 
            </div> -->
            <?= $form->field($LoginForm, 'Name')->textInput(['maxlength' => 30]) ?>
        </div>
        <div class="col-md-7">
            <!-- <label for="validationCustom02" class="form-label">Apellido</label>
            <input type="text" class="form-control" id="validationCustom02" value="Otto" required>
            <div class="valid-feedback">
            Looks good!
            </div> -->
            <?= $form->field($LoginForm, 'Email')->textInput(['maxlength' => 80]) ?>
        </div>
        <div class="col-md-7">
            <!-- <label for="validationCustomUserName" class="form-label">UserName</label>
            <div class="input-group has-validation">
            <span class="input-group-text" id="inputGroupPrepend">@</span>
            <input type="text" class="form-control" id="validationCustomUserName" aria-describedby="inputGroupPrepend" required>
            <div class="invalid-feedback">
                Please choose a UserName.
            </div>
            </div> -->
            <?= $form->field($LoginForm, 'UserName')->textInput(['maxlength' => 30]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-7">
            <?= $form->field($LoginForm, 'CountryID')->widget(Chosen::classname(), [
                'items' => $ItemsCountry,
                'allowDeselect' => true,
                'disableSearch' => true, // Search input will be disabled
                'clientOptions' => [
                    'search_contains' => true,
                    'max_selected_options' => 10,
                ],
                'multiple' => false,
            ])->label('Pais'); ?>
        </div>
        <div class="col-md-7">
            <!-- <label for="validationCustom03" class="form-label">City</label>
            <input type="text" class="form-control" id="validationCustom03" required>
            <div class="invalid-feedback">
            Please provide a valid city.
            </div> -->
            <?= $form->field($LoginForm, 'Password')->passwordInput(['maxlength' => 80]) ?>
        </div>
        <div class="col-md-7">
            <!-- <label for="validationCustom03" class="form-label">City</label>
            <input type="text" class="form-control" id="validationCustom03" required>
            <div class="invalid-feedback">
            Please provide a valid city.
            </div> -->
            <?= $form->field($LoginForm, 'Password2')->passwordInput(['maxlength' => 80]) ?>
        </div>
    </div>
    <div class="col-12">
    <?= Html::submitButton('Registrarse', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>

