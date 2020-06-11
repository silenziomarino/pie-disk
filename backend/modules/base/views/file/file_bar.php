<?php

use backend\modules\base\assets\file\FileBarBundle;
use yii\helpers\Url;

/**
 * @var $file
 * @var $access_crud
 */
$this->registerJs('var file_id="' . $file['id'] . '"; ', yii\web\View::POS_BEGIN);
FileBarBundle::register($this);
?>

<span class="fa fa-info file_info"></span>
<span class="file_name"><?= $file['name'] ?></span>
<span style="padding-left: 50px">
    <span id="share-block">
        <button id="share_btn" class="file_btn file_bar_btn">
            <i class="fa fa-bullhorn"></i>
            <span class="file_bar_btn_text">Поделиться</span>
        </button>
        <div class="rambler-share"></div>
    </span>

    <a href="<?= Url::toRoute(['file/download', 'id' => $file['id']]) ?>"
       class="file_btn file_bar_btn"
       title="скачать"
       download
       data-pjax="0">
        <i class="fa fa-save"></i>
        <span class="file_bar_btn_text">Скачать</span>
    </a>
</span>


<span class="pull-right">
    <?php if (\Yii::$app->user->can('updateFile', ['file' => $file])): ?>
        <a href="<?= Url::toRoute(['file/option', 'list' => $file['id']]) ?>"
           class="file_btn"
           title="настройки"
           data-pjax="0">
            <i class="fa fa-cog"></i>
            <span class="file_bar_btn_text">Изменить</span>
        </a>
        <button id="file_delete"
           class="file_btn"
           title="удалить">
            <i class="fa fa-trash"></i>
            <span class="file_bar_btn_text">Удалить</span>
        </button>
        <button id="history" class="file_btn">
            <span class="fa fa-history"></span>
        </button>
    <?php endif; ?>

    <button id="close_file_bar" class="file_btn pull-right">
        <i class="fa fa-times"></i>
    </button>
</span>


