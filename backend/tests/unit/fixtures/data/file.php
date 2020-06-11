<?php


$JSON = file_get_contents(__DIR__ . '/json/file.json');

$JSON = str_replace("TRASH_DATE", date('Y-m-d H:i:s', strtotime('-31 day', strtotime(date("Y-m-d H:i:s")))), $JSON);
$JSON = str_replace("TRASH_UPDATE", strtotime('-31 day', strtotime(date("Y-m-d H:i:s"))), $JSON);

return json_decode($JSON, true);