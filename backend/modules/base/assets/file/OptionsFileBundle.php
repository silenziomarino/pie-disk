<?php

namespace backend\modules\base\assets\file;

use backend\modules\base\assets\lib\ChosenBundle;
use backend\modules\base\assets\InitBundle;

class OptionsFileBundle extends InitBundle
{
    public $js = [
        'js/file/options.js'
    ];
    public $depends = [
        ChosenBundle::class,
    ];
}