<?php

namespace backend\modules\base\assets\lib;

use backend\modules\base\assets\InitBundle;

/**
 * Class ChartJsBundle
 * @package backend\modules\base\assets\lib
 */
class ChartJsBundle extends InitBundle
{
    public $sourcePath = '@vendor/nnnick/chartjs/dist';
    public $js = [
        'Chart.min.js',
        'Chart.bundle.min.js',
    ];
    public $css = [
        'Chart.min.css',
    ];
}