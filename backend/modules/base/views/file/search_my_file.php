<?php

use backend\modules\base\assets\home\SearchIndexBundle;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;

/**
 * @var $model
 * @var $param
 * @var $data
 * @var $pages
 */
SearchIndexBundle::register($this);
?>

<?php Pjax::begin(['id' => 'report', 'timeout' => false, 'enablePushState' => false, 'clientOptions' => ['method' => 'POST']]); ?>
<div class="widget-body">
    <div class="widget-main no-padding">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead class="thin-border-bottom">
                <tr style="background: #17aae22e">
                    <th colspan="4">
                        <ul class="list-inline">
                            <li>Отображать по</li>
                            <li>
                                <select class="form-control input-sm" id="count" name="count">
                                    <?php foreach ($param['option'] as $item): ?>
                                        <option value="<?= $item ?>" <?= ($param['count'] == $item) ? 'selected' : ''; ?> ><?= $item ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </li>
                            <li>записей</li>
                        </ul>
                    </th>
                </tr>
                <tr>

                    <th class="caption_block">Название</th>
                    <th class="caption_block">Дата загрузки</th>
                </tr>
                </thead>
                <tbody>
                <?php if (!empty($data)): ?>
                    <?php foreach ($data as $key => $value): ?>
                        <tr id="<?=$value['id']?>" class="file-row">
                            <td>
                                <span class="span-name"><?= $value['file_name'] ?></span><br>
                                <span class="span-info"><?= $value['file_size'] ?></span>
                                <span class="span-exception"><?= $value['file_extension'] ?></span>
                            </td>
                            <td><span class="span-info"><?= $value['date_create'] ?></span></td>
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
<?php Pjax::end(); ?>
