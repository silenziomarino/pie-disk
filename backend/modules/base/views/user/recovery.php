<?php

use yii\bootstrap\ActiveForm;

?>
<div>
    <p>Введите E-mail адресс который вы используете для аккаунта на ПИЭ Диске и мы вышлим Вам новый пароль</p>
    <?php $form = ActiveForm::begin(['id' => 'recovery-form', 'enableClientValidation' => false]); ?>
    <?= $form->field($model, 'email', [
            'options' => [
            'class' => 'form-group has-feedback'],
        'inputTemplate' => "{input}<span class='glyphicon glyphicon-envelope form-control-feedback'></span>"
    ])->label(false)->textInput([
            'id' => 'recovery_email',
        'placeholder' => $model->getAttributeLabel('Email')]) ?>
    <?php ActiveForm::end(); ?>
</div>

