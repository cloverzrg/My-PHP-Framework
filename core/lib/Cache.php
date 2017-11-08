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

use core\lib\connection\Redis;

class Cache
{
    private static $cacheKeyPrefix = 'Cache:';
    private static $cacheDB = 0;
    protected static $handler = null;

    /**
     * 初始化
     */
    public static function init()
    {
        self::$cacheDB = Config::get('CACHE.REDIS.SELECT');
        self::$handler = Redis::getInstance(self::$cacheDB);
        self::$cacheKeyPrefix = Config::get('CACHE.CACHE_PREFIX');
    }

    /**
     * @param string $key
     * @param string|bool $default
     * @return bool|mixed  返回前尝试json解码,不能解码则返回字符串
     */
    public static function get($key, $default = false)
    {
        $key = self::getCacheKey($key);
        $value = self::$handler->get($key);

        if (is_null($value)) {
            return $default;
        }

        $json_data = json_decode($value);

        return $json_data === null ? $value : $json_data;
    }


    /** 给key加前缀
     * @param string $key
     * @return string
     */
    private static function getCacheKey($key)
    {
        return self::$cacheKeyPrefix . $key;
    }


    /**
     * @param string $key
     * @param string|array $value  数组会json编码
     * @param int $expire 过期时间(秒) 0 为永久
     * @return mixed result
     */
    public static function set($key, $value, $expire = 0)
    {
        $key = self::getCacheKey($key);

        if (is_array($value) || is_object($value)) {
            $value = json_encode($value);
        }

        if (is_int($expire) && $expire) {
            $result = self::$handler->setex($key, $expire, $value);
        } else {
            $result = self::$handler->set($key, $value);
        }

        return $result;


    }

    /**
     * 给相应的 $key增加 $d
     * @param string $key
     * @param int $step 步长
     * @return mixed 完成操作后 $key 的值
     */
    public static function inc($key, $step = 1)
    {
        $key = self::getCacheKey($key);
        return self::$handler->incrby($key, $step);
    }

    /**
     * @param string $key   自减的key
     * @param int $step  步长
     * @return mixed 完成操作后 $key 的值
     */
    public static function dec($key, $step = 1)
    {
        $key = self::getCacheKey($key);
        return self::$handler->decrby($key, $step);
    }

    /**
     * 删除指定缓存
     * @param string $key
     * @return mixed
     */
    public static function rm($key)
    {
        $key = self::getCacheKey($key);
        return self::$handler->delete($key);
    }
}