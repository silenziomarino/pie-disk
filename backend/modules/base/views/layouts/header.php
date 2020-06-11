<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var $this \yii\web\View */
/* @var $content string */
$notify_count = Yii::$app->user->GetCountNotify();
$this->registerJs('var notify_count="' . $notify_count . '"; ', yii\web\View::POS_BEGIN);
?>

<header class="main-header">

    <?= Html::a('<span class="logo-mini">Диск</span><span class="logo-lg">ПИЭ Диск</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">
                <li id="notify" class="notifications-menu">
                    <a href="#">
                        <i class="fa fa-bell-o"></i>
                        <?php if (!empty($notify_count)):?>
                            <span class="label label-warning"><?=$notify_count?></span>
                        <?php endif;?>
                    </a>
                </li>

                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="hidden-xs" style="padding: 5px;"><?= Yii::$app->user->GetUserName() ?></span>
                        <img src="<?=Yii::$app->user->GetImg()?>" class="user_image" alt="User Image" style="float: right;" />
                    </a>
                    <ul class="dropdown-menu">
                        <!-- Menu Body -->
                        <li class="user-footer">
                            <div class="col-xs-6 text-center">
                                <a href="<?= Url::toRoute(['user/profile'])?>">Профиль</a>
                            </div>
                            <div class="col-xs-6 text-center">
                                <a href="<?= Url::toRoute(['user/logout'])?>">Выйти</a>
                            </div>
                        </li>
                        <!-- Menu Footer
                        <li class="user-footer"></li>-->
                    </ul>
                </li>

                <!-- User Account: style can be found in dropdown.less -->
            </ul>
        </div>
    </nav>
</header>
