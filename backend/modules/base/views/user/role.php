<?php

use yii\helpers\Html;

/**
 * @var $role
 * @var $dic_auth_item
 */
?>
<div class="row">
    <div class="form-group">
        <label class="col-sm-4 control-label text-right">Роль пользователя:</label>
        <div class="col-sm-7">
            <?= Html::dropDownList('item_name', $role, $dic_auth_item, [
                'id' => 'role',
                'class' => 'form-control input-sm',
                'prompt' => 'Выберите роль',
            ]); ?>
        </div>
    </div>
</div>