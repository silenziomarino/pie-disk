<?php

namespace backend\modules\base\assets\home;

use backend\modules\base\assets\lib\BootboxBundle;
use backend\modules\base\assets\lib\ChosenBundle;
use backend\modules\base\assets\lib\DateTimePickerBundle;
use backend\modules\base\assets\InitBundle;
use backend\modules\base\assets\lib\MaskedInputBundle;

class HomeBundle extends InitBundle
{
    public $css = [
        'css/home/index.css',
    ];

    public $js = [
        'js/home/index.js',
    ];

    public $depends = [
        ChosenBundle::class,
        MaskedInputBundle::class,
        DateTimePickerBundle::class,
    ];
}