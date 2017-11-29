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

    /**
     * 记录当前时间和内存使用情况
     * @param string $name 标记名称
     */
    public static function remark($name)
    {
        self::$time[$name] = microtime(true);
        self::$mem[$name] = memory_get_usage();
    }

    /**
     * 返回开始标记和结束标记之间的时间差
     * @param string $start 开始标记
     * @param string $end 结束标记
     * @return string
     */
    public static function getRangeTime($start, $end)
    {
        return number_format(self::$time[$end] - self::$time[$start],6);
    }
}