<?php

namespace backend\modules\base\assets\lib;

use backend\modules\base\assets\InitBundle;

/**
 * Class MaskedInputBundle
 * @package backend\modules\base\assets\lib
 */
class MaskedInputBundle extends InitBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $js = [
        'js/jquery/jquery.maskedinput.js',
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