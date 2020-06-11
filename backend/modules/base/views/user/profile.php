<?php

use backend\modules\base\assets\user\ProfileBundle;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/**
 * @var $model
 * @var $email
 */
ProfileBundle::register($this);

$this->title = 'Редактирование профиля';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="div-box">
    <h1 class="h1-title"><?= Html::encode($this->title) ?></h1>
    <?php $form = ActiveForm::begin([
        'action' => Url::toRoute(['user/profile']),
        'options' => [
                'enctype' => 'multipart/form-data'
        ]
    ]) ?>
    <div class="row form-group">
        <div class="col-sm-6">
            <?= HTML::activeFileInput($model, 'photo', [
                'id' => 'input_add_photo',
                'class' => 'hidden',
            ]) ?>
            <div id="avatar" style="background-image: url(<?=Yii::$app->user->GetImg()?>);"></div>
            <span id="add_photo" class="fa fa-camera foto_icon"></span>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <?= $form->field($model, 'last_name', [])->label('Фамилия')->textInput(['placeholder' => $model->getAttributeLabel('Иванов')]) ?>
            </div>
            <div class="form-group">
                <?= $form->field($model, 'first_name', [])->label('Имя')->textInput(['placeholder' => $model->getAttributeLabel('Иван')]) ?>
            </div>
            <div class="form-group">
                <?= $form->field($model, 'middle_name', [])->label('Отчество')->textInput(['placeholder' => $model->getAttributeLabel('Иванович')]) ?>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label for="email" class="col-sm-12 control-label">E-mail</label>
                <?= Html::textInput( 'email',$email, [
                    'id'       => 'email',
                    'class'    => 'option-str form-control',
                    'disabled' => true,
                ]) ?>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label for="get_pas">Получить новый пароль на E-mail адрес</label>
                <div>
                    <button id="get_pas" type="button" class="btn btn-outline-primary form-control">Получить</button>
                </div>
            </div>
        </div>
    </div>

    <div class="row form-group">
        <div class="col-xs-12">
            <button type="submit" class="btn btn-success">Сохранить</button>
        </div>
    </div>
    <?php ActiveForm::end() ?>
</div>
