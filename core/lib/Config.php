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


class Config
{
    private static $configData = [];

    /**
     * @param string $name
     * @param mixed $default
     * @return string|array
     * 当获取的值是数组时,返回数组
     * 当获取的是具体值,则返回值
     * REDIS.HOST返回值,
     * REDIS返回数组
     * 不传入参数则返回所有配置
     */
    public static function get($name = null, $default = false)
    {
        if ($name == null) return self::$configData;
        $name_arr = explode('.', $name);
        $config = self::$configData;
        foreach ($name_arr as $value) {
            if (isset($config[$value])) {
                $config = $config[$value];
            } else {
                return $default;
            }

        }
        return $config;
    }

    /*
     * 遍历配置文件夹,将所有配置文件加载进来
     */
    public static function init()
    {
        $pattern = CONFIG_PATH . '*.php';
        $configFiles = glob($pattern);
        foreach ($configFiles as $file) {
            $config = include_once $file;
            if (isset($config['CONFIG_PREFIX']) && $config['CONFIG_PREFIX']) {
                self::$configData[$config['CONFIG_PREFIX']] = $config;
            } else {
                self::$configData = array_merge(self::$configData, $config);
            }
        }

    }


}