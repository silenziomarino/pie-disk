<?php

use backend\modules\base\assets\AuthThemeBundle;
use yii\helpers\Html;

/**
 * @var $content
 */
AuthThemeBundle::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link rel="shortcut icon" href="/img/favicon.png" type="/image/png">
</head>
<body class="login-page body_fon">

<?php $this->beginBody() ?>

    <?= !empty($content)? $content : '' ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
