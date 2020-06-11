<?php

use backend\modules\base\assets\file\OptionsFileBundle;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var $data_file
 * @var $data_teg
 * @var $dic_tegs
 */
$this->title = 'Настройка файлов';
$this->params['breadcrumbs'][] = $this->title;
OptionsFileBundle::register($this);
?>
<div class="div-box">
    <h1 class="h1-title"><?= Html::encode($this->title) ?></h1>
    <p class="alert alert-info" role="alert">Заполните информацию о загружаемых файлах, для более легкого поиска на сайте</p>
    <?php foreach ($data_file as $model): ?>
        <?php $form = ActiveForm::begin([
                'action' => 'javascript:void(null);',
                'options' => [
                        'enctype' => 'multipart/form-data'
                ]
        ]) ?>
        <div class="panel panel-primary">
            <div class="panel-body">
                <div class="col-sm-offset-2 col-sm-8">
                    <div class="form-group">
                        <?= Html::activeHiddenInput($model, 'id') ?>
                        <label class="col-sm-12 control-label">Название файла</label>
                        <?= Html::activeTextInput($model, 'name', [
                            'id' => 'FileName',
                            'class' => 'option-str form-control',
                            'placeholder' => 'Пример: Списки Учащихся',
                        ]) ?>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12 control-label">Укажите ключевые слова через запятую</label>
                        <?= Html::activeTextInput($data_teg[$model->id], 'str', [
                            'id' => 'FileName',
                            'class' => 'option-str form-control',
                            'placeholder' => 'Пример: Ордер,pdf,2016...',
                        ]) ?>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                <div class="form-row">
                    <button class="update_file btn  btn-success">Сохранить</button>
                    <button class="skip btn  btn-secondary">Пропустить</button>
                </div>
            </div>
        </div>
        <?php ActiveForm::end() ?>
    <?php endforeach; ?>
</div>
