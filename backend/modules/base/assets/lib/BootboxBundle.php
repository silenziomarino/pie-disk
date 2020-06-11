<?php

namespace backend\modules\base\assets\lib;

use yii\web\JqueryAsset;

/**
 * Class BootboxBundle
 * @package backend\modules\base\assets\lib
 */
class BootboxBundle extends JqueryAsset
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $js = [
        'js/bootbox/bootbox.min.js',
    ];
}
