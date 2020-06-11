<?php

/**
 * @var $model
 * @var $data
 * @var $pages
 */

use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;

?>

<?php Pjax::begin(['id' => 'file_history', 'timeout' => false, 'enablePushState' => false, 'clientOptions' => ['method' => 'POST']]); ?>
    <div class="widget-body">
        <div class="widget-main no-padding">
            <h3 class="text-center">История изменений</h3>
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                    <thead class="thin-border-bottom">
                    <tr>
                        <th class="caption_block">Дата и время</th>
                        <th class="caption_block">Операция</th>
                        <th class="caption_block">Исполнитель</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($data)): ?>
                        <?php foreach ($data as $key => $value): ?>
                            <tr class="file-row">
                                <td><?= $value['date'] ?></td>
                                <td><?= $value['operation_name'] ?></td>
                                <td><?= $value['user'] ?></td>
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