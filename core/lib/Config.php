<?php
/**
 * Created by PhpStorm.
 * User: zhurungen
 * Date: 2017/11/4
 * Time: 19:23
 *
 * 配置类
 */

namespace core\lib;

use core\lib\driver\Redis;

class Config
{
    private static $configData = [];

    /**
     * @param $name
     * @return array|mixed
     * 当获取的值是数组时,返回数组
     * 当获取的是具体值,则返回值
     * REDIS.HOST返回值,
     * REDIS返回数组
     */
    public static function get($name)
    {
        $name_arr = explode('.', $name);
        $config = self::$configData;
        foreach ($name_arr as $value) {
            $config = $config[$value];
        }
        return $config;
    }

    /*
     * 将所有配置文件加载进来
     */
    public static function init()
    {

        $config = include_once CONFIG_PATH . 'base.php';
        self::$configData = $config;
        $database = include_once CONFIG_PATH . 'database.php';
        if (isset($database['CONFIG_PREFIX']) && $database['CONFIG_PREFIX']) {
            self::$configData[$database['CONFIG_PREFIX']] = $database;
        } else {
            self::$configData = array_merge(self::$configData, $database);
        }

    }


}