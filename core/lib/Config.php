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
    private static $config_data = [];

    /*
     * 当获取的值是数组时,返回数组
     * 当获取的是具体值,则返回值
     * REDIS.HOST返回值,
     * REDIS返回数组
     */
    public static function get($name)
    {
        $name_arr = explode('.', $name);
        $config = self::$config_data;
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
        self::$config_data = $config;
        $database = include_once CONFIG_PATH . 'database.php';
        if (isset($database['CONFIG_PREFIX']) && $database['CONFIG_PREFIX']) {
            self::$config_data[$database['CONFIG_PREFIX']] = $database;
        } else {
            self::$config_data = array_merge(self::$config_data, $database);
        }

//        $redis->set("Config:data",serialize(self::$config_data));
    }


}