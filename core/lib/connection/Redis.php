<?php
/**
 * Created by PhpStorm.
 * User: zhurungen
 * Date: 2017/11/4
 * Time: 20:18
 *
 * Redis 驱动
 */

namespace core\lib\connection;

use core\lib\Config;

/*
 * redis连接
 * 获取一个连接:
 * use \core\lib\driver\Redis;
 * Redis::getInstance();
 */

class Redis
{

    protected static $handler = [];

    private function __construct()
    {

    }


    /**
     * 连接redis
     */
    private static function connect($db)
    {
        $host = Config::get('REDIS.HOST');
        $port = Config::get('REDIS.PORT');
        $connect_type = Config::get('REDIS.PERSISTENT')? 'pconnect':'connect';
        $password = Config::get('REDIS.PASSWORD');
        self::$handler[$db] = new \Redis();
        self::$handler[$db]->$connect_type($host, $port);
        if ($password != ''){
            self::$handler[$db]->auth($password);
        }
        self::$handler[$db]->select($db);
    }

    /**
     * @param int $db 连接的redis库
     * @return \Redis 连接已连接对象
     */
    public static function getInstance($db = 0)
    {
        if (!isset(self::$handler[$db])) {
            self::connect($db);
        }
        return self::$handler[$db];
    }

    private function __clone()
    {

    }
}