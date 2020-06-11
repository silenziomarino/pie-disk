<?php
namespace backend\modules\helpers\file;

class FileHelpers
{
    public static function GetMaxFileSize(){
        
    }

    //подсчет максимального значения для валидации данных
    public static function ReturnBytes($val)
    {
        $val = trim($val);
        $last = strtolower($val[strlen($val) - 1]);
        switch ($last) {
            case 'g':
                $val = (float)$val * 1024;
            case 'm':
                $val = (float)$val * 1024;
            case 'k':
                $val = (float)$val * 1024;
        }
        return $val;
    }


    /**
     * переводит байты в читабельный вид. Например: в Mb или в Gb (в зависимости от размера файла)
     * @param integer|string $bytes - число в байтах
     * @return string
     */
    public static function FileSizeFormat($bytes)
    {
        $Kb = ($bytes / 1024);
        if (strlen((int)$Kb) > 3) {
            $Mb = (float)($Kb / 1024);
            if (strlen((int)$Mb) > 3) {
                $Gb = (float)($Mb / 1024);
                $size = fmod($Gb,2) == 0 ? $Gb.' Gb' : sprintf("%01.2f", $Gb) . ' Gb';
            } else {
                $size = fmod($Mb,2) == 0 ? $Mb.' Mb' : sprintf("%01.2f", $Mb) . ' Mb';
            }
        } else {
            $size = fmod($Kb,2) == 0 ? $Kb.' Kb' : sprintf("%000.1f", $Kb) . ' Kb';
        }
        return $size;
    }
}