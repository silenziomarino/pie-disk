<?php

use backend\modules\base\assets\teg\DicTegFileBundle;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;

/**
 * @var $data
 * @var $param
 * @var $pages
 */
$this->title = 'Ключевые слова';
$this->params['breadcrumbs'][] = $this->title;

DicTegFileBundle::register($this);
?>
<?php Pjax::begin(['id' => 'dic_teg', 'timeout' => false, 'enablePushState' => false, 'clientOptions' => ['method' => 'POST']]); ?>
<div class="div-box">
    <h1 class="h1-title"><?= Html::encode($this->title) ?></h1>
    <div class="panel panel-primary">
        <div class="panel-body">
            <div class="widget-body">
                <div class="widget-main no-padding">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead class="thin-border-bottom">
                            <tr style="background: #17aae22e">
                                <th colspan="2">
                                    <ul class="list-inline">
                                        <li>Отображать по</li>
                                        <li>
                                            <?php $form = ActiveForm::begin([
                                                'action' => Url::toRoute(['teg/dic-teg-file']),
                                                'method' => 'get',
                                                'options' => [
                                                    'name' => 'dic_teg',
                                                    'class' => 'form-horizontal',
                                                ]
                                            ]); ?>
                                                <select class="form-control input-sm" id="count" name="count">
                                                    <?php foreach ($param['option'] as $item): ?>
                                                        <option value="<?= $item ?>" <?= ($param['count'] == $item) ? 'selected' : ''; ?> ><?= $item ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            <?php ActiveForm::end() ?>
                                        </li>
                                        <li>записей</li>
                                    </ul>
                                </th>
                                <th style="text-align: right">
                                    <button id="deleteAll" class="btn btn-danger">Удалить всё</button>
                                </th>
                            </tr>
                            <tr>

                                <th class="caption_block">id</th>
                                <th class="caption_block">Ключевое слово</th>
                                <th class="caption_block"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (!empty($data)): ?>
                                <?php foreach ($data as $key => $value): ?>
                                    <tr id="<?= $value['id'] ?>" class="file-row">
                                        <td><?= $value['id'] ?></td>
                                        <td><?= $value['name'] ?></td>
                                        <td style="text-align: right">
                                            <button class="btn btn-danger teg_delete" title="Удалить">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <th colspan="17">
                                        <div align="center">Нет данных</div>
                                    </th>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php echo LinkPager::widget(['pagination' => $pages, 'id' => 'main_pagination']); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php Pjax::end(); ?>
