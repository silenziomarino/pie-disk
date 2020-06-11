<?php

namespace backend\modules\base\assets\file;

use backend\modules\base\assets\InitBundle;

class FilePageBundle extends InitBundle
{
    public $css = [
        'css/file/file_page.css'
    ];

    public $js = [
        'js/file/file_page.js'
    ];

    public function __construct()
    {
        parent::__construct();
        foreach ($this->css as $k => $v) {
            $this->css[$k] = $v . "?m=" . strval(rand(10000, 99999));
        }
        foreach ($this->js as $k => $v) {
            $this->js[$k] = $v . "?m=" . strval(rand(10000, 99999));
        }
    }
}