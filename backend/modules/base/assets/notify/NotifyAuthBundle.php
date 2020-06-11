<?php

namespace backend\modules\base\assets\notify;

use backend\modules\base\assets\InitBundle;

class NotifyAuthBundle extends InitBundle
{
    public $js = [
        'js/notify/auth.js',
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