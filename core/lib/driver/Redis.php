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
 * redis连接
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


    /**
     * 连接redis
     */
    private static function connect()
    {
        $host = Config::get('REDIS.HOST');
        $port = Config::get('REDIS.PORT');
        $connect_type = Config::get('REDIS.persistent')? 'pconnect':'connect';
        $password = Config::get('REDIS.PASSWORD');
        self::$handler = new \Redis();
        self::$handler->$connect_type($host, $port);
        if ($password != ''){
            self::$handler->auth($password);
        }
    }

    /**
     * @param int $db 连接的redis库
     * @return \Redis 连接已连接对象
     */
    public static function getInstance($db = 0)
    {
        if (self::$handler == null) {
            self::connect();
        }
        self::$handler->select($db);
        return self::$handler;
    }

    private function __clone()
    {

    }
}