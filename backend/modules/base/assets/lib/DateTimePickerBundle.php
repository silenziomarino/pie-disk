<?php

namespace backend\modules\base\assets\lib;

use backend\modules\base\assets\InitBundle;

/**
 * Class DateTimePickerBundle
 * @package backend\modules\base\assets\lib
 */
class DateTimePickerBundle extends InitBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $js = [
        'js/date-time/moment.js',
        'js/date-time/bootstrap-datepicker.js',
        'js/date-time/bootstrap-timepicker.js',
        'js/date-time/bootstrap-datetimepicker.js',
        'js/date-time/daterangepicker.js'
    ];

    public $css = [
        'css/date-time/bootstrap-timepicker.css',
        'css/date-time/bootstrap-datetimepicker.css',
        'css/date-time/datepicker.css',
        'css/date-time/daterangepicker.css',
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