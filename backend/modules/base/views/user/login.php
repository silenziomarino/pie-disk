<?php

use backend\modules\base\assets\user\LoginBundle;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = 'Вход';
LoginBundle::register($this);
?>

<div class="login-box">
    <div class="login-logo">
        <a href="#"><b class="">ПИЭ Диск</a>
    </div>
    <div class="login-box-body">
        <p class="login-box-msg">Введите ваши данные</p>

        <?php $form = ActiveForm::begin(['id' => 'login-form', 'enableClientValidation' => false]); ?>

        <?= $form->field($model, 'email', [
            'options' => ['class' => 'form-group has-feedback'],
            'inputTemplate' => "{input}<span class='glyphicon glyphicon-envelope form-control-feedback'></span>"
        ])->label(false)->textInput(['placeholder' => $model->getAttributeLabel('E-mail')]) ?>

        <?= $form->field($model, 'password', [
            'options' => ['class' => 'form-group has-feedback'],
            'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
        ])->label(false)->passwordInput(['placeholder' => $model->getAttributeLabel('Пароль')]) ?>

        <div class="row form-group">
            <div class="col-xs-8">
                <button type="button" class="btn btn-link" id="recovery-btn">Востановить пароль</button>
            </div>
            <div class="col-xs-4">
                <button type="submit" class="btn btn-success btn-block btn-flat">Вход</button>
            </div>
        </div>
        <?php ActiveForm::end(); ?>

        <div class="row form-group">
            <div class="col-xs-12">
                <a href="<?= Url::toRoute('user/signup'); ?>" class="btn btn-primary btn-block btn-flat">Регистрация</a>
            </div>
        </div>
    </div>
</div>
