<?php

namespace backend\modules\base\assets\lib;

use backend\modules\base\assets\InitBundle;

/**
 * Class ChosenBundle
 * @package backend\modules\base\assets\lib
 */
class ChosenBundle extends InitBundle
{

    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $js = [
        'js/chosen/chosen.jquery.js',
    ];

    public $css = [
        'css/chosen/chosen.css',
    ];

    public $depends = [
        jQueryUIBundle::class,
    ];
}
