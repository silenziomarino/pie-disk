<?php
/**
 * @var $inviter
 */

$this->title = 'Что дальше!?';
$this->params['breadcrumbs'][] = $this->title;
$this->render('../../../base/views/layouts/main-login');

use yii\helpers\Url; ?>

<div class="div-box">
    <div class="login-logo">
        <a href="#"><b class="blue"><?= $this->title ?></a>
    </div>
    <div class="login-box-body">
        <p>После того как <?= $inviter ?> подвердит вашу регистрацию в системе.
            На указаный Вами E-mail придет письмо с паролем для аутентификации.</p>
        <a href="<?= Url::toRoute(['/'])?>">Вернуться на главную страницу</a>
    </div>
</div>


