<?php

use backend\modules\base\assets\user\SignupBundle;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

/**
 * @var $auth_item
 * @var $inviter_list
 */
$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;
SignupBundle::register($this);
?>

<div class="signup-box">
    <div class="login-logo">
        <a href="#"><b class="blue"><?= $this->title ?></a>
    </div>
    <?php $form = ActiveForm::begin(['id' => 'signup-form']); ?>
    <div class="login-box-body">
        <a href="<?= Url::toRoute(['/'])?>" class="btn btn-success" style="float: left">Вход</a>
        <p class="login-box-msg">Введите ваши данные</p>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <?= $form->field($model, 'last_name', [])->label('Фамилия')->textInput(['placeholder' => $model->getAttributeLabel('Иванов')]) ?>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <?= $form->field($model, 'first_name', [])->label('Имя')->textInput(['placeholder' => $model->getAttributeLabel('Иван')]) ?>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                    <?= $form->field($model, 'middle_name', [])->label('Отчество')->textInput(['placeholder' => $model->getAttributeLabel('Иванович')]) ?>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <?= $form->field($model, 'email', [])->label('E-mail')->textInput(['id' => 'email','placeholder' => $model->getAttributeLabel('ivanov@gmail.com')]) ?>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <?= $form->field($model, 'inviter', [])->label('Кто подтвердит вашу регистрацию')->dropDownList($inviter_list, [
                        'class' => 'form-control input-sm',
                        'prompt' => 'Выберите',
                    ]) ?>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <button type="submit" class="btn btn-success btn-block btn-flat">Зарегистрироваться</button>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
