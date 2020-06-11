<?php

namespace backend\modules\helpers\user;

/**
 * Class UserHelpers
 * @package backend\modules\helpers\file
 */
class UserHelpers
{

    //генератор случайных паролей
    public static function GenPassword($length = 10)
    {
        $chars = "qazxswedcvfrtgbnhyujmkiolp1234567890QAZXSWEDCVFRTGBNHYUJMKIOLP";
        $length = intval($length);
        $size = strlen($chars) - 1;
        $password = "";
        while ($length--) $password .= $chars[rand(0, $size)];
        return $password;
    }

}