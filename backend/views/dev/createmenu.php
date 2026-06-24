<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\components\DinamycForm\DynamicFormWidget;

$this->title = 'Menu';
$isNewRecord = $ModelsMenuByRole->isNewRecord;
?>

<div class="container-fluid px-0 cpanel-form-page cpanel-menu-form-page">
    <div class="cpanel-page-heading">
        <h1><?= $isNewRecord ? 'Crear menú' : 'Actualizar menú'; ?></h1>
        <?= Html::a('<i class="fa-solid fa-arrow-left"></i> Atrás', ['menu'], ['class' => 'cpanel-menu-back-link']) ?>
    </div>

    <div class="cpanel-form-shell">
        <?php $form = ActiveForm::begin(['id' => 'dynamic-form-menu']); ?>

        <div class="cpanel-form-section">
            <div class="cpanel-menu-section-heading">
                <span class="cpanel-menu-section-icon"><i class="fa-regular fa-file-lines"></i></span>
                <h2 class="cpanel-section-title">Datos del menú</h2>
                <span class="cpanel-menu-section-line"></span>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="cpanel-menu-icon-field">
                        <?= $form->field($MenuModel, 'MenuName')->textInput(['maxlength' => true, 'class' => 'form-control cpanel-has-icon', 'placeholder' => 'Ej. Gestión de usuarios'])->label('Nombre del men&uacute;', ['encode' => false]) ?>
                        <i class="fa-solid fa-list-ul"></i>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="cpanel-menu-icon-field">
                        <?= $form->field($MenuModel, 'ClassIcon')->textInput(['maxlength' => true, 'class' => 'form-control cpanel-has-icon', 'placeholder' => 'Ej. fa-solid fa-users'])->label('Icono FontAwesome') ?>
                        <i class="fa-regular fa-flag"></i>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="cpanel-menu-icon-field">
                        <?= $form->field($MenuModel, 'ControllerUse')->textInput(['maxlength' => true, 'class' => 'form-control cpanel-has-icon', 'placeholder' => 'Ej. user'])->label('Controlador') ?>
                        <i class="fa-solid fa-code"></i>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="cpanel-menu-select-field">
                        <?= $form->field($MenuModel, 'Type')->dropDownList(['0' => 'Menu con sub menus', '1' => 'Menu simple'], ['class' => 'typemenu form-control'])->label('Tipo de men&uacute;', ['encode' => false]) ?>
                    </div>
                </div>
            </div>

            <div class="row SingleMenu" style="<?php if ($isNewRecord): echo 'display:none;'; elseif ($MenuModel->Type == 0): echo 'display:none;'; endif; ?>">
                <div class="col-md-6">
                    <div class="cpanel-menu-icon-field">
                        <?= $form->field($MenuModel, 'Path')->textInput(['maxlength' => true, 'class' => 'form-control val-vaciar cpanel-has-icon', 'placeholder' => 'Ej. user/index'])->label('Ruta') ?>
                        <i class="fa-solid fa-link"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="cpanel-form-section">
            <div class="cpanel-menu-section-heading">
                <span class="cpanel-menu-section-icon"><i class="fa-solid fa-users"></i></span>
                <h2 class="cpanel-section-title">Roles con acceso</h2>
                <span class="cpanel-menu-section-line"></span>
            </div>
            <div class="cpanel-role-list">
                <?php
                    if (!$isNewRecord) {
                        $ModelsMenuByRole->RoleID = $checkedList;
                    }
                ?>
                <?= $form->field($ModelsMenuByRole, 'RoleID')->checkboxList($items, [
                    'item' => function ($index, $label, $name, $checked, $value) {
                        return Html::label(
                            Html::checkbox($name, $checked, ['value' => $value]) .
                            '<i class="fa-regular fa-user"></i>' .
                            '<span>' . Html::encode($label) . '</span>',
                            null,
                            ['class' => 'cpanel-role-chip']
                        );
                    },
                ])->label(false) ?>
            </div>
        </div>

        <div class="NosingleMenu" style="<?php if ($isNewRecord): echo ''; elseif ($MenuModel->Type == 1): echo 'display:none;'; endif; ?>">
            <div class="cpanel-menu-section-heading">
                <span class="cpanel-menu-section-icon"><i class="fa-regular fa-file"></i></span>
                <h2 class="cpanel-section-title">P&aacute;ginas del men&uacute;</h2>
                <span class="cpanel-menu-section-line"></span>
            </div>

            <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_wrapper',
                'widgetBody' => '.container-items',
                'widgetItem' => '.item',
                'limit' => 10,
                'min' => 1,
                'insertButton' => '.add-item',
                'deleteButton' => '.remove-item',
                'model' => $PagesModel[0],
                'formId' => 'dynamic-form-menu',
                'formFields' => [
                    'PageName',
                    'PagePath',
                    'ClassIcon',
                ],
            ]); ?>

            <div class="container-items">
                <?php foreach ($PagesModel as $i => $modelPages): ?>
                    <div class="item cpanel-repeater-item">
                        <div class="cpanel-repeater-toolbar">
                            <span class="cpanel-repeater-title">P&aacute;gina del men&uacute;</span>
                            <div class="cpanel-icon-actions">
                                <button type="button" class="add-item btn btn-primary" title="Agregar pagina"><i class="fa-solid fa-plus"></i></button>
                                <button type="button" class="remove-item btn btn-danger" title="Quitar pagina"><i class="fa-solid fa-minus"></i></button>
                            </div>
                        </div>

                        <?php
                            if (!$modelPages->isNewRecord) {
                                echo Html::activeHiddenInput($modelPages, "[{$i}]PageID");
                            }
                        ?>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="cpanel-menu-icon-field">
                                    <?= $form->field($modelPages, "[{$i}]PageName")->textInput(['maxlength' => true, 'class' => 'form-control val-vaciar cpanel-has-icon', 'placeholder' => 'Ej. Listar usuarios'])->label('Nombre de p&aacute;gina', ['encode' => false]) ?>
                                    <i class="fa-solid fa-t"></i>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="cpanel-menu-icon-field">
                                    <?= $form->field($modelPages, "[{$i}]PagePath")->textInput(['maxlength' => true, 'class' => 'form-control val-vaciar cpanel-has-icon', 'placeholder' => 'Ej. user/index'])->label('Ruta de p&aacute;gina', ['encode' => false]) ?>
                                    <i class="fa-solid fa-link"></i>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="cpanel-menu-icon-field">
                                    <?= $form->field($modelPages, "[{$i}]ClassIcon")->textInput(['maxlength' => true, 'class' => 'form-control val-vaciar cpanel-has-icon', 'placeholder' => 'Ej. fa-solid fa-list'])->label('Icono') ?>
                                    <i class="fa-regular fa-flag"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <?php DynamicFormWidget::end(); ?>
        </div>

        <div class="cpanel-form-actions">
            <?= Html::submitButton($isNewRecord ? '<i class="fa-solid fa-plus"></i> Crear men&uacute;' : 'Actualizar men&uacute;', [
                'class' => 'btn btn-primary click-confirm',
                'tittle-alert' => $isNewRecord ? 'Crear menu' : 'Actualizar menu',
                'text-alert' => $isNewRecord ? 'Crear un nuevo menu. Desea continuar?' : 'Actualizar menu ['.$MenuModel->MenuName.'] Desea continuar?',
            ]) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>

<?php
$this->registerJs("
$(function(){
    $('.typemenu').change(function(){
        if($(this).val() == 1){
            $('.NosingleMenu').hide('slow');
            $('.SingleMenu').show('slow');
            $('.val-vaciar').val('');
        }
        if($(this).val() == 0){
            $('.NosingleMenu').show('slow');
            $('.SingleMenu').hide('slow');
        }
    });
});
");
?>

<?php
if (Yii::$app->session->hasFlash('success')):
    $this->registerJS('
        $(document).ready(function(){
            _Message("success","Exito","'.Yii::$app->session->getFlash('success').'");
        });
    ');
endif;

if (Yii::$app->session->hasFlash('error')):
    $this->registerJS('
        $(document).ready(function(){
            _Message("error","Error","'.Yii::$app->session->getFlash('error').'");
        });
    ');
endif;
?>
