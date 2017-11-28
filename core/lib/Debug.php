<?php
/**
 * Created by PhpStorm.
 * User: zhurungen
 * Date: 2017/11/29
 * Time: 1:24
 */

namespace core\lib;

class Debug
{
    private static $time = [];
    private static $mem = [];

    public static function remark($name)
    {
        self::$time[$name] = microtime(true);
        self::$mem[$name] = memory_get_usage();
    }

    public static function getRangeTime($start, $end)
    {
        return number_format(self::$time[$end] - self::$time[$start],6);
    }
}