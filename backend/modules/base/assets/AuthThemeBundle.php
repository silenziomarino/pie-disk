<?php

namespace backend\modules\base\assets;

use dmstr\web\AdminLteAsset;
use yii\web\AssetBundle;

/**
 * Скрипты и цсс необходимые для темы
 */
class AuthThemeBundle extends InitBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'css/auth.css',
    ];
}
