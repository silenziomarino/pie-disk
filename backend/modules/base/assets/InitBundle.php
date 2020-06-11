<?php

namespace backend\modules\base\assets;

use yii\web\AssetBundle;

/**
 * Базовый класс для остальных асссетов
 */
abstract class InitBundle extends AssetBundle
{
    public $sourcePath = '@app/modules/base/web';

    public $depends = [
        ThemeBundle::class,
    ];
    public $publishOptions = ['forceCopy' => true];
}
