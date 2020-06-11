<?php

namespace backend\modules\base\assets\user;

use backend\modules\base\assets\InitBundle;

class ProfileBundle extends InitBundle
{
    public $css = [
        'css/user/profile.css'
    ];

    public $js = [
        'js/user/profile.js'
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