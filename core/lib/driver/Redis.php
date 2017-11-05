<?php
/**
 * Created by PhpStorm.
 * User: zhurungen
 * Date: 2017/11/4
 * Time: 20:18
 *
 * Redis 驱动
 */

namespace core\lib\driver;

use core\lib\Config;

/*
 * redis连接,单例模式
 * 获取一个连接:
 * use \core\lib\driver\Redis;
 * Redis::getInstance();
 */

class Redis
{

    protected static $handler = null;

    private function __construct()
    {

    }

    private static function getRedis()
    {
        self::$handler = new \Redis();
        self::$handler->connect(Config::get('REDIS.HOST'), Config::get('REDIS.PORT'));
    }

    public static function getInstance($db = 0)
    {
        if (self::$handler == null) {
            self::getRedis();
        }
        self::$handler->select($db);
        return self::$handler;
    }

    private function __clone()
    {
        //trigger_error("单例模式,不能被克隆");
    }
}