<?php

use backend\modules\base\assets\file\MyFileBundle;
use backend\modules\base\assets\VariablesForJs;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var $model
 * @var $modelFileForm
 * @var $dic_profile
 * @var $dic_teg
 * @var $param
 * @var $data
 * @var $pages
 * @var $sort
 * @var $addDocRule
 */

$this->title = 'Мои документы';
$this->params['breadcrumbs'][] = $this->title;

MyFileBundle::register($this);
$this->registerJs(VariablesForJs::VariablesForDatePicker(), yii\web\View::POS_BEGIN);
?>

<div class="page-content">
    <?php if($addDocRule):?>
    <div class="row" style="position: absolute;">
        <div class="col-sm-12">
            <div class="btn-group pull-left">
                <?php $form = ActiveForm::begin([
                    'action' => Url::toRoute(['file/create']),
                    'options' => [
                        'class' => 'form-horizontal',
                        'enctype' => 'multipart/form-data'
                    ]
                ]); ?>
                <?= HTML::activeFileInput($modelFileForm, 'files[]', [
                    'id' => 'input_add_file',
                    'class' => 'hidden',
                    'multiple' => true,
                ]) ?>
                <button id='add_file' type="button" class="btn btn-success" title="Добавить документ">
                    <i class="fa fa-plus"></i> <span class="add_file_btn_text">Добавить документ</span>
                </button>
                <?php ActiveForm::end() ?>
            </div>
        </div>
    </div>
    <?php endif;?>
    <h1 class="h1-title"><?= Html::encode($this->title) ?></h1>
    <hr>
    <p class="span-info" style="text-align: center;font-size: 12px;">фильтры поиска по файлам</p>
    <?php ActiveForm::begin([
        'action' => 'javascript:void(null);',
        'options' => [
            'class' => 'form-horizontal',
            'id' => 'search-form',
        ]
    ]); ?>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label class="col-sm-5 control-label">Название файла</label>
                <div class="col-sm-7">
                    <?= Html::activeTextInput($model, 'file_name', [
                        'id' => 'FileName',
                        'class' => 'form-control input-sm',
                        'placeholder' => 'Пример: Ордера',
                    ]) ?>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label class="col-sm-5 control-label">Дата загрузки файла</label>
                <div class="col-sm-7">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-calendar bigger-110"></i>
                        </span>
                        <input class="form-control input-sm" type="text" id="date-range"
                               value="<?= "{$model->start_date} - {$model->end_date}" ?>"/>
                        <?= Html::activeHiddenInput($model, 'start_date', ['id' => 'StartDate']) ?>
                        <?= Html::activeHiddenInput($model, 'end_date', ['id' => 'EndDate']) ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="form-group">
                <label class="col-sm-5 control-label">Выберите ключивые слова</label>
                <div class="col-sm-7">
                    <?= Html::activeDropDownList($model, 'teg', $dic_teg, [
                        'id' => 'Teg',
                        'class' => 'chosen-select',
                        'multiple' => 'multiple',
                        'data-placeholder' => 'Выберите тег'
                    ]) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="btn-group pull-right">
                <button type="button" class="btn  btn-primary" id="searchButton">
                    <i class="fa fa-search" id="iconSearch"></i> Поиск
                </button>
                <button type="button" class="btn  btn-secondary" id="clearFilter">
                    <i class="fa fa-snowplow"></i> очистить
                </button>
            </div>
        </div>
    </div>

    <div class="tabbable" id="searchInfo" style="margin-top: 20px;"></div>
    <?php ActiveForm::end() ?>
</div>

