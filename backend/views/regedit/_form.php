<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var $model common\models\TopicsNotifications */

$form = ActiveForm::begin([
    'id' => 'topics-form',
    'enableAjaxValidation' => false,
]);
?>

<div class="form-group">
    <?= $form->field($model, 'ChannelKey')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'Channel')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'Description')->textarea(['rows' => 4]) ?>
</div>

<div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>