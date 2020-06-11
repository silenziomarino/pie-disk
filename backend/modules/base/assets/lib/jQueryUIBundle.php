<?php

namespace backend\modules\base\assets\lib;

use backend\modules\base\assets\InitBundle;

/**
 * Class jQueryUIBundle
 * @package backend\modules\base\assets\lib
 */
class jQueryUIBundle extends InitBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $js = [
        'js/jquery/jquery-ui.min.js',
    ];
    public $css = [
        'css/jquery/jquery-ui.min.css',
    ];
}