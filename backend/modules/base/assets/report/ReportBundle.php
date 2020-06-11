<?php

namespace backend\modules\base\assets\report;

use backend\modules\base\assets\lib\ChartJsBundle;
use backend\modules\base\assets\InitBundle;

class ReportBundle extends InitBundle
{
    public $js = [
        'js/report/index.js',
    ];

    public $depends = [
        ChartJsBundle::class,
    ];
}