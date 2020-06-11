<?php

namespace backend\modules\base\assets\home;

use backend\modules\base\assets\file\FilePageBundle;
use backend\modules\base\assets\InitBundle;

class SearchIndexBundle extends InitBundle
{
    public $js = [
        'js/home/search_index.js'
    ];

    public $depends = [
        FilePageBundle::class,
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