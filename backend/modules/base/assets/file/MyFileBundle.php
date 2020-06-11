<?php

namespace backend\modules\base\assets\file;

use backend\modules\base\assets\lib\ChosenBundle;
use backend\modules\base\assets\lib\DateTimePickerBundle;
use backend\modules\base\assets\InitBundle;
use backend\modules\base\assets\lib\MaskedInputBundle;

class MyFileBundle extends InitBundle
{
    public $css = [
        'css/file/my_file.css',
    ];

    public $js = [
        'js/file/my_file.js',
    ];

    public $depends = [
        ChosenBundle::class,
        MaskedInputBundle::class,
        DateTimePickerBundle::class,
    ];
}