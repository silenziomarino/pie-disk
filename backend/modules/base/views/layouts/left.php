<?php
use dmstr\widgets\Menu;
?>
<aside class="main-sidebar">

    <section class="sidebar">
        <?= Menu::widget(Yii::$app->user->GetLeftMenu())?>
    </section>

</aside>
