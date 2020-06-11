<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var $model
 */
$this->title = 'Типы загружаемых файлов';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="div-box">
    <h1 class="h1-title"><?= Html::encode($this->title) ?></h1>
    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal',]]); ?>
        <div class="panel panel-primary">
            <div class="panel-body">
                <div class="col-sm-offset-2 col-sm-8">
                    <div class="form-group">
                        <label class="col-sm-12">Укажите поддерживаемые типы файлов через запятую</label>
                        <?= Html::activeTextarea($model, 'str', [
                            'id' => 'FileName',
                            'class' => 'option-str form-control',
                        ]) ?>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                <div class="form-row">
                    <button type="submit" class="update_file btn  btn-success">Сохранить</button>
                </div>
            </div>
        </div>
    <?php ActiveForm::end() ?>
</div>
