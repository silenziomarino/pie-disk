<?php
/**
 * @var $max_filesize
 * @var $dic_format
 */
?>


<h3 class="text-danger">Ограничения</h3>
<div class="row">
    <div class="col-sm-11">
    <ul>
        <li>Файл не должен превышать <b><?=$max_filesize?></b></li>
        <li>Поддерживаемые типы файлов:
            <?php foreach ($dic_format as $value):?>
                <b><?= $value ?></b>,
            <?php endforeach;?>
        </li>
        <li>Документ не должен нарушать авторские права.</li>
    </ul>
    </div>
</div>



