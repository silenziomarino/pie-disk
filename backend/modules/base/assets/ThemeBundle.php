<?php

namespace backend\modules\base\assets;

use backend\modules\base\assets\lib\BootboxBundle;
use dmstr\web\AdminLteAsset;
use yii\web\JqueryAsset;
use yii\web\AssetBundle;

/**
 * Скрипты и цсс необходимые для работы темы
 */
class ThemeBundle extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $js = [
        'js/main.js',
        'js/jquery/ace.ajax-content.js'
    ];

    public $css = [
        'css/main.css'
    ];

    public $depends = [
        JqueryAsset::class,
        AdminLteAsset::class,
        BootboxBundle::class,
    ];
}
