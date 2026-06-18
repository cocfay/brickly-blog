<?php 
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap5\ActiveForm;
use common\components\DinamycForm\DynamicFormWidget;
use common\components\chosen\Chosen;
use kartik\select2\Select2; // Usamos Select2, que es la versión moderna

    $this->title = 'Usuarios';

    /* $this->registerCss('
        input, select, ul.chosen-choices{
            border-color: #FF0351 !important;
        }
        ul.chosen-choices{
            padding: 0.13rem 1rem !important;
        }
    '); */
?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center">
        <div class="fs-3 mb-4" style="color: color: #fff;"><?=($ModelAccount->isNewRecord)? 'Crear usuario' : 'Actualizar usuario'; ?> </div>
        <a href="<?= Url::to(['/my-account#nav-users']) ?>" title="Atrás"><i class="fa-regular fa-circle-left fs-1" style="color: #FF0461"></i></a>
    </div>
    <!-- <hr> -->
    <div class="row-fluid">

            <div class="customer-form">
                      <?php $form = ActiveForm::begin(['id'=>'form-user', 'method'=>'post','enableClientValidation' => true, 'enableAjaxValidation' => true]) ?>
                            <div class="row">
                                <div class="col-md-4">
                                    
                                    <?= $form->field($ModelUserAccount,'UserName')->textInput(['maxlength' => true]); ?>
                                </div>
                               <div class="col-md-4">
                                  
                                    <?= $form->field($ModelUserAccount,'UserPassword')->passwordInput(['maxlength' => true]); ?>
                                </div>
                                <?php if($UserData->TypeUser == 1): ?>
                                <div class="col-md-4">
                                  
                                    <?= $form->field($ModelUserAccount, 'TypeUser')->dropDownList($aTypeUsers,['class'=>'typemenu form-control']) ?>
                                </div>
                                <?php endif; ?>
                                <div class="col-md-4">
                                    
                                    <?= $form->field($ModelUserAccount,'Name')->textInput(['maxlength' => true]); ?>
                                </div>
                                <div class="col-md-4">
                                    <?= $form->field($ModelUserAccount,'Email')->textInput(['type'=>'email','maxlength' => true]); ?>
                                </div>
                                <?php if($UserData->TypeUser !== 2):  ?>
                                    <div class="col-md-4">
                                        <?= $form->field($ModelByRole, 'RoleID')->widget(Chosen::classname(), [
                                            'items' => $ItemsRole,
                                            'allowDeselect' => true,
                                            'disableSearch' => true, // Search input will be disabled
                                            'clientOptions' => [
                                                'search_contains' => true,
                                                'max_selected_options' => 2,
                                            ],
                                            'options' => [
                                                'multiple' => true,
                                                'data-placeholder' => 'Seleccione alguna opción',
                                            ]
                                        ])->label('Rol'); ?>
                                    </div>
                                <?php else: ?>
                                    <?= $form->field($ModelByRole, 'RoleID')->hiddenInput(['value' => 19])->label(false) ?>
                                <?php endif ?>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="my-3 fs-4">
                                        Avatar
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 d-flex align-items-end gap-2 mb-4">
                                            <img src="<?= Url::to('@raizweb');?>/images/profile/avatar1.png" alt="" style="height:60px;" class="rounded-circle">
                                            <?= $form->field($ModelUserAccount,'PhotoUrl', ['options' => ['class' => 'mb-0']])->radio(['label'=>'','value' =>'avatar1.png', 'uncheck' => null]); ?>
                                        </div>
                                        <div class="col-md-4 d-flex align-items-end gap-2 mb-4">
                                            <img src="<?= Url::to('@raizweb');?>/images/profile/avatar2.png" alt="" style="height:60px;" class="rounded-circle">
                                            <?= $form->field($ModelUserAccount,'PhotoUrl', ['options' => ['class' => 'mb-0']])->radio(['label'=>'','value' =>'avatar2.png', 'uncheck' => null]); ?>
                                        </div>
                                        <div class="col-md-4 d-flex align-items-end gap-2 mb-4">
                                            <img src="<?= Url::to('@raizweb');?>/images/profile/avatar3.png" alt="" style="height:60px;" class="rounded-circle">
                                            <?= $form->field($ModelUserAccount,'PhotoUrl', ['options' => ['class' => 'mb-0']])->radio(['label'=>'','value' =>'avatar3.png', 'uncheck' => null]); ?>
                                        </div>
                                        <div class="col-md-4 d-flex align-items-end gap-2 mb-4">
                                            <img src="<?= Url::to('@raizweb');?>/images/profile/avatar4.png" alt="" style="height:60px;" class="rounded-circle">
                                            <?= $form->field($ModelUserAccount,'PhotoUrl', ['options' => ['class' => 'mb-0']])->radio(['label'=>'','value' =>'avatar4.png', 'uncheck' => null]); ?>
                                        </div>
                                        <div class="col-md-4 d-flex align-items-end gap-2 mb-4">
                                            <img src="<?= Url::to('@raizweb');?>/images/profile/avatar5.png" alt="" style="height:60px;" class="rounded-circle">
                                            <?= $form->field($ModelUserAccount,'PhotoUrl', ['options' => ['class' => 'mb-0']])->radio(['label'=>'','value' =>'avatar5.png', 'uncheck' => null]); ?>
                                        </div>
                                        <div class="col-md-4 d-flex align-items-end gap-2 mb-4">
                                            <img src="<?= Url::to('@raizweb');?>/images/profile/avatar6.png" alt="" style="height:60px;" class="rounded-circle">
                                            <?= $form->field($ModelUserAccount,'PhotoUrl', ['options' => ['class' => 'mb-0']])->radio(['label'=>'','value' =>'avatar6.png', 'uncheck' => null]); ?>
                                        </div>
                                        <div class="col-md-4 d-flex align-items-end gap-2 mb-4">
                                            <img src="<?= Url::to('@raizweb');?>/images/profile/avatar7.png" alt="" style="height:60px;" class="rounded-circle">
                                            <?= $form->field($ModelUserAccount,'PhotoUrl', ['options' => ['class' => 'mb-0']])->radio(['label'=>'','value' =>'avatar7.png', 'uncheck' => null]); ?>
                                        </div>
                                        <div class="col-md-4 d-flex align-items-end gap-2 mb-4">
                                            <img src="<?= Url::to('@raizweb');?>/images/profile/avatar8.png" alt="" style="height:60px;" class="rounded-circle">
                                            <?= $form->field($ModelUserAccount,'PhotoUrl', ['options' => ['class' => 'mb-0']])->radio(['label'=>'','value' =>'avatar8.png', 'uncheck' => null]); ?>
                                        </div>
                                        <div class="col-md-4 d-flex align-items-end gap-2 mb-4">
                                            <img src="<?= Url::to('@raizweb');?>/images/profile/avatar9.png" alt="" style="height:60px;" class="rounded-circle">
                                            <?= $form->field($ModelUserAccount,'PhotoUrl', ['options' => ['class' => 'mb-0']])->radio(['label'=>'','value' =>'avatar9.png', 'uncheck' => null]); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6"></div>
                            </div>


                            <div class="row mt-5">
                                <div class="col-md-6">
                                <?= Html::submitButton($ModelAccount->isNewRecord ? 'Crear nuevo usuario' : 'Actualizar usuario', ['class' => 'btn click-confirm px-5', 'style' => 'font-size: 14px; background: #FF0461; border-radius: 4px; color: #fff;',
                            "tittle-alert" => $ModelAccount->isNewRecord ? 'Crear usuario' : 'Actualizar usuario',
                            "text-alert" => $ModelAccount->isNewRecord ? 'Crear un nuevo usuario. ¿Desea continuar?' : 'Actualizar usuario ['.$ModelUserAccount->UserName.'] . ¿Deseas continuar?',

                    ]) ?>
                                </div>
                            </div>
                     <?php ActiveForm::end(); ?>

            </div>
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

    if (Yii::$app->session->hasFlash('error')):

        $this->registerJS('
            $(document).ready(function(){
                _Message("error","¡Error!","'.Yii::$app->session->getFlash('error').'");
            });

            ');
    endif;
 ?>