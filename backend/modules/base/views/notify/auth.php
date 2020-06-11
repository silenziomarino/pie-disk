<?php

use backend\modules\base\assets\notify\NotifyAuthBundle;
use yii\helpers\Html;

/**
 * @var $invited_id
 * @var $dic_auth_item
 * @var $invited_fio
 */

NotifyAuthBundle::register($this);
?>

<div class="notify_block">
    <h5>Подтвердите регистрацию </h5>
    <h3 style="color: green"><?=$invited_fio ?></h3>
    <div>
        <span>Выберите роль для нового пользователя:</span>
        <?= Html::dropDownList('auth_item','',$dic_auth_item)?>
    </div>
    <button class="btn btn-success confirm_reg" data-id="<?= $invited_id ?>">Подтвердить</button>
    <button class="btn btn-danger reg_denial" data-id="<?= $invited_id ?>">Отказать</button>
</div>
