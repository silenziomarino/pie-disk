<?php

use backend\modules\base\assets\user\UserListBundle;
use backend\modules\base\assets\VariablesForJs;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/**
 * $model
 */

$this->title = 'Управление пользователями';
$this->params['breadcrumbs'][] = $this->title;
$this->registerJs(VariablesForJs::VariablesForDatePicker(), yii\web\View::POS_BEGIN);
UserListBundle::register($this);
?>


<div class="page-content">
    <h1 class="h1-title"><?= $this->title ?></h1>
    <br>
    <p class="span-info" style="text-align: center;font-size: 12px;">Фильтры поиска по пользователям</p>
    <?php ActiveForm::begin([
        'action' => 'javascript:void(null);',
        'options' => [
            'class' => 'form-horizontal',
            'id' => 'search-user',
        ]
    ]); ?>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label class="col-sm-5 control-label">Выберите пользователя</label>
                <div class="col-sm-7">
                    <?= Html::activeDropDownList($model, 'user_id', [],[
                        'id'               => 'UserId',
                        'class'            => 'chosen-select',
                        'multiple'         => 'multiple',
                        'data-placeholder' => 'Начните вводить ФИО'
                    ]) ?>
                    <i class="fa fa-spinner fa-spin tag-spinner"></i>
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="form-group">
                <label class="col-sm-5 control-label">Дата регистрации</label>
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
