<?php
/**
 * Created by PhpStorm.
 * User: zhurungen
 * Date: 2017/11/4
 * Time: 21:55
 *
 * 缓存类
 * 所有缓存都放在redis中的cache命名空间中(即 key 为 cache:*)
 *
 */

namespace core\lib;

use core\lib\driver\Redis;

class Cache
{
    private static $cacheKeyPrefix = 'Cache:';
    private static $cacheDB = 0;

    /**
     * @param $key string
     * @param $default string|bool
     * @return bool|mixed  返回前尝试json解码,不能解码则返回字符串
     */
    public static function get($key, $default = false)
    {
        $key = self::getCacheKey($key);
        $redis = Redis::getInstance(self::$cacheDB);
        $value = $redis->get($key);

        if (is_null($value)) {
            return $default;
        }

        $json_data = json_decode($value);

        return $json_data === null ? $value : $json_data;
    }


    /** 给key加前缀
     * @param $key string
     * @return string
     */
    private static function getCacheKey($key)
    {
        return self::$cacheKeyPrefix . $key;
    }


    /**
     * @param $key string
     * @param $value string|array 数组会json编码
     * @param $expire int 过期时间(秒) 0 为永久
     * @return mixed result
     */
    public static function set($key, $value, $expire = 0)
    {
        $key = self::getCacheKey($key);
        $redis = Redis::getInstance(self::$cacheDB);

        if (is_array($value) || is_object($value)) {
            $value = json_encode($value);
        }

        if (is_int($expire) && $expire) {
            $result = $redis->setex($key, $expire, $value);
        } else {
            $result = $redis->set($key, $value);
        }

        return $result;


    }

    /**
     * 给相应的 $key增加 $d
     * @param $key string
     * @param $step int 步长
     * @return mixed 完成操作后 $key 的值
     */
    public static function inc($key, $step = 1)
    {
        $key = self::getCacheKey($key);
        $redis = Redis::getInstance(self::$cacheDB);
        return $redis->incrby($key, $step);
    }

    /**
     * @param $key  string 自减的key
     * @param $step int 步长
     * @return mixed 完成操作后 $key 的值
     */
    public static function dec($key, $step = 1)
    {
        $key = self::getCacheKey($key);
        $redis = Redis::getInstance(self::$cacheDB);
        return $redis->decrby($key, $step);
    }

    public static function rm($key)
    {
        $key = self::getCacheKey($key);
        return Redis::getInstance(self::$cacheDB)->delete($key);
    }
}