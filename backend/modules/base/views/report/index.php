<?php

use backend\modules\base\assets\report\ReportBundle;
use yii\web\View;

/**
 * @var $disk
 * @var $timeline
 * @var $activeUser
 */

$this->registerJs(
    'var disk_name= "' . $disk['chart_name'] . '"; '
    . 'var disk_total= "' . $disk['total_sum'] . '"; '
    . 'var disk_labels= ' . json_encode($disk['labels']) . '; '
    . 'var disk_data= ' . json_encode($disk['data']) . '; '
    , yii\web\View::POS_HEAD);

$this->registerJs(
    'var timeline_name= "' . $timeline['chart_name'] . '"; '
    . 'var timeline_total= "' . $timeline['total'] . '"; '
    . 'var timeline_labels= ' . json_encode($timeline['labels']) . '; '
    . 'var timeline_data= ' . json_encode($timeline['data']) . '; '
    , yii\web\View::POS_HEAD);

$this->registerJs(
    'var activeUser_name= "' . $activeUser['chart_name'] . '"; '
    . 'var activeUser_total= "' . $activeUser['total'] . '"; '
    . 'var activeUser_labels= ' . json_encode($activeUser['labels']) . '; '
    . 'var activeUser_data= ' . json_encode($activeUser['data']) . '; '
    , yii\web\View::POS_HEAD);

ReportBundle::register($this); ?>

<!--загруженность диска по типу файла-->
<div class="div-box">
    <div class="panel panel-primary">
        <div class="panel-body">
            <div class="col-md-offset-1 col-md-10">
                <canvas id="Disk"></canvas>
            </div>
        </div>
    </div>
</div>
<!--интенсивность добавления файлов за год-->
<div class="div-box">
    <div class="panel panel-primary">
        <div class="panel-body">
            <div class="col-md-offset-1 col-md-10">
                <canvas id="timeline"></canvas>
            </div>
        </div>
    </div>
</div>
<!--Активность пользователей-->
<div class="div-box">
    <div class="panel panel-primary">
        <div class="panel-body">
            <div class="col-md-offset-1 col-md-10">
                <canvas id="activeUser"></canvas>
            </div>
        </div>
    </div>
</div>
