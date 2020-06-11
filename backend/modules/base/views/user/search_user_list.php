<?php

use backend\modules\base\assets\user\SearchUserListBundle;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;

/**
 * @var $model
 * @var $param
 * @var $data
 * @var $pages
 */
SearchUserListBundle::register($this);
?>

<?php Pjax::begin(['id' => 'user_report', 'timeout' => false, 'enablePushState' => false, 'clientOptions' => ['method' => 'POST']]); ?>
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
                    <th class="caption_block">Дата регистрации</th>
                    <th class="caption_block">ФИО</th>
                    <th class="caption_block">E-mail</th>
                    <th class="caption_block"></th>
                </tr>
                </thead>
                <tbody>
                <?php if (!empty($data)): ?>
                    <?php foreach ($data as $key => $value): ?>
                        <tr id="<?=$value['id']?>">
                            <td><?= date('d.m.Y H:m:s',$value['date']) ?></td>
                            <td><?= $value['fio'] ?></td>
                            <td><?= $value['email'] ?></td>
                            <td>
                                <?php if(Yii::$app->user->getId() != $value['id']):?>
                                <div class="pull-right">
                                    <button id="user_set_role" class="btn btn-primary" title="Выбрать роль">
                                        <i class="fa fa-cog"></i>
                                    </button>
                                    <?php if($value['lock']):?>
                                        <button id="user_unlock" class="btn btn-secondary" title="Разблокировать">
                                            <i class="fa fa-unlock"></i>
                                        </button>
                                    <?php else:?>
                                        <button id="user_lock" class="btn btn-secondary" title="Заблокировать">
                                            <i class="fa fa-lock"></i>
                                        </button>
                                    <?php endif;?>

                                    <button id="user_delete" class="btn btn-danger" title="Удалить">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                                <?php endif;?>
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
<?php Pjax::end(); ?>
